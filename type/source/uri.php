<?php


namespace Components;


  /**
   * Uri
   *
   * scheme://username:password@domain.tld:port/path/file.ext?key0=val0#fragment
   * \____/   \_______________/ \________/ \__/      \__/ \_/ \_______/ \______/
   *   |              |             |       |          |   |      |        |
   *   |            user           host    port        |   |    query   fragment
   *   |      \_______________________________/\_______|___|/
   *   |                    |                      |   |   |
   * scheme             authority                path  |   |
   *                                                   |   |
   *                                               file-name
   *                                                       |
   *                                                   file-extension
   *
   * @package net.evalcode.components
   * @subpackage type
   *
   * @author evalcode.net
   */
  class Uri implements Object, Cloneable, Value_String, Serializable_Php
  {
    // PREDEFINED PROPERTIES
    /**
     * [DEFAULT] Format arrays in query strings without array index.
     *
     * <pre>
     *   [enabled] ?arg[0]=val1&arg[1]=val2
     *   [default] ?arg%5B0%5D=val1&arg%5B1%5D=val2
     * </pre>
     */
    const OPTION_QUERY_STRING_FORMAT_PHP=1;
    /**
     * Format arrays in query strings without array index.
     *
     * <pre>
     *   [enabled] ?arg[]=val1&arg[]=val2
     *   [default] ?arg%5B0%5D=val1&arg%5B1%5D=val2
     * </pre>
     */
    const OPTION_QUERY_STRING_FORMAT_HTTP=2;
    /**
     * Format arrays in query strings without array index & square brackets.
     *
     * <pre>
     *   [enabled] ?arg=val1&arg=val2
     *   [default] ?arg%5B0%5D=val1&arg%5B1%5D=val2
     * </pre>
     */
    const OPTION_QUERY_STRING_FORMAT_JAXRS=4;
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * Parses given string and returns an corresponding instance of Uri.
     *
     * @param string $url_
     *
     * @return \Components\Uri
     */
    public static function valueOf($uri_)
    {
      $uri=self::arrayForString($uri_);

      if(isset($uri['scheme']) && ($impl=Resource_Type::getResourceIdentifierTypeForScheme($uri['scheme'])))
        $instance=new $impl();
      else
        $instance=new static();

      $instance->parseImpl($uri);

      return $instance;
    }

    /**
     * @return \Components\Uri
     */
    public static function createEmpty()
    {
      return new static();
    }
    //--------------------------------------------------------------------------


    // ACCESSORS
    /**
     * @return \Components\Resource
     */
    public function getResource()
    {
      if(null===$this->m_resource)
      {
        if($type=Resource_Type::getResourceTypeForScheme($this->m_scheme))
          $this->m_resource=new $type($this);
        else
          $this->m_resource=Resource_Url_Factory::create($this);
      }

      return $this->m_resource;
    }

    /**
     * Returns scheme.
     *
     * <pre>
     *   [scheme:]//[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *    ^^^^^^^
     * </pre>
     *
     * @return \Components\Uri
     */
    public function getScheme()
    {
      return $this->m_scheme;
    }

    /**
     * Defines scheme.
     *
     * <pre>
     *   [scheme]://[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *    ^^^^^^
     * </pre>
     *
     * @param string $scheme_
     *
     * @return \Components\Uri
     */
    public function setScheme($scheme_)
    {
      $this->m_scheme=$scheme_;

      return $this;
    }

    /**
     * Returns authority.
     *
     * <pre>
     *   [scheme]://[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *              \_________________________________/
     *                               |
     *                           authority
     * </pre>
     *
     * @return string
     */
    public function getAuthority()
    {
      if(!$host=$this->getHost())
        return '';

      if($port=$this->getPort())
        $host.=':'.$port;

      if($user=$this->getUsername())
      {
        $user=String::urlEncode($user);

        if($password=$this->getPassword())
          $user.=':'.String::urlEncode($password);

        return $user.'@'.$host;
      }

      return $host;
    }

    /**
     * Returns host information.
     *
     * <pre>
     *   [scheme]://[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *                                     ^^^^
     * </pre>
     *
     * @return string
     */
    public function getHost()
    {
      return $this->m_host;
    }

    /**
     * Defines host information.
     *
     * <pre>
     *   [scheme]://[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *                                     ^^^^
     * </pre>
     *
     * @param string $host_
     *
     * @return \Components\Uri
     */
    public function setHost($host_)
    {
      $this->m_host=$host_;

      return $this;
    }

    /**
     * Returns instance containing the host only.
     *
     * <pre>
     *   [scheme]://[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *                                     ^^^^
     * </pre>
     *
     * @return \Components\Uri
     */
    public function reduceToHost()
    {
      $instance=new self();
      $instance->setHost($this->getHost());

      return $instance;
    }

    /**
     * Returns port information.
     *
     * <pre>
     *   [scheme]://[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *                                            ^^^^
     * </pre>
     *
     * @return integer
     */
    public function getPort()
    {
      return $this->m_port;
    }

    /**
     * Defines port information.
     *
     * <pre>
     *   [scheme]://[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *                                            ^^^^
     * </pre>
     *
     * @param integer $port_
     *
     * @return \Components\Uri
     */
    public function setPort($port_)
    {
      $this->m_port=(int)$port_;

      return $this;
    }

    /**
     * Returns username of authority information.
     *
     * <pre>
     *   [scheme]://[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *               ^^^^^^^^
     * </pre>
     *
     * @return string
     */
    public function getUsername()
    {
      return $this->m_username;
    }

    /**
     * Defines username for authority information.
     *
     * <pre>
     *   [scheme]://[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *               ^^^^^^^^
     * </pre>
     *
     * @param string $username_
     *
     * @return \Components\Uri
     */
    public function setUsername($username_)
    {
      $this->m_username=$username_;

      return $this;
    }

    /**
     * Returns password of authority information.
     *
     * <pre>
     *   [scheme]://[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *                          ^^^^^^^^
     * </pre>
     *
     * @return string
     */
    public function getPassword()
    {
      return $this->m_password;
    }

    /**
     * Defines password for authority information.
     *
     * <pre>
     *   [scheme]://[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *                          ^^^^^^^^
     * </pre>
     *
     * @param string $password_
     *
     * @return \Components\Uri
     */
    public function setPassword($password_)
    {
      $this->m_password=$password_;

      return $this;
    }

    /**
     * Returns path.
     *
     * <pre>
     *   [scheme]://[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *                                                   ^^^^
     * </pre>
     *
     * @return string
     */
    public function getPath()
    {
      $pathParams=array();
      foreach($this->getPathParams() as $pathParam)
        array_push($pathParams, String::urlEncode($pathParam));

      return '/'.implode('/', $pathParams);
    }

    /**
     * Replaces path parameters for given path.
     *
     * <pre>
     *   [scheme]://[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *                                                   ^^^^
     * </pre>
     *
     * @param sting $path_
     *
     * @return \Components\Uri
     */
    public function setPath($path_)
    {
      $this->m_pathParams=array();

      if(0===mb_strpos($path_, '/'))
        $pathParams=explode('/', mb_substr($path_, 1));
      else
        $pathParams=explode('/', $path_);

      foreach($pathParams as $pathParam)
        $this->pushPathParam(String::urlDecode($pathParam));

      return $this;
    }

    /**
     * Replaces path parameters.
     *
     * <pre>
     *   [scheme]://[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *                                                   ^^^^
     * </pre>
     *
     * @param array $pathParams_
     *
     * @return \Components\Uri
     */
    public function setPathParams(array $pathParams_)
    {
      $this->m_pathParams=array();

      foreach($pathParams_ as $pathParam)
        $this->pushPathParam($pathParam);

      return $this;
    }

    /**
     * Returns path parameters.
     *
     * <pre>
     *   [scheme]://[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *                                                   ^^^^
     * </pre>
     *
     * @return array
     */
    public function getPathParams($stipFileExtension_=false)
    {
      if(true===$stipFileExtension_)
      {
        $pathParams=$this->m_pathParams;

        if($filename=array_pop($pathParams))
        {
          if(false!==($pos=strpos($filename, '.')))
            $filename=substr($filename, 0, strpos($filename, '.'));

          array_push($pathParams, $filename);
        }

        return $pathParams;
      }

      return $this->m_pathParams;
    }

    /**
     * Returns path parameter of given position.
     *
     * <pre>
     *   [scheme]://[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *                                                   ^^^^
     * </pre>
     *
     * @param integer $idx_ Array-index of path parameters / Position of parameter in path.
     *
     * @return string
     */
    public function getPathParam($idx_)
    {
      if(isset($this->m_pathParams[$idx_]))
        return $this->m_pathParams[$idx_];

      return null;
    }

    /**
     * Updates path parameter at given position.
     *
     * <pre>
     *   [scheme]://[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *                                                   ^^^^
     * </pre>
     *
     * @param integer $idx_ Array-index of path parameters / Position of parameter in path.
     * @param string $pathParam_
     *
     * @return \Components\Uri
     */
    public function setPathParam($idx_, $pathParam_)
    {
      if(null===$pathParam_ || 1>String::length($pathParam_))
        return $this;

      $this->m_pathParams[$idx_]=$pathParam_;

      return $this;
    }

    /**
     * Pops path parameter off the end of path / Removes and returns last path parameter.
     *
     * <pre>
     *   [scheme]://[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *                                                   ^^^^
     * </pre>
     *
     * @return string
     */
    public function popPathParam()
    {
      return array_pop($this->m_pathParams);
    }

    /**
     * Adds given parameter to the end of path.
     *
     * <pre>
     *   [scheme]://[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *                                                   ^^^^
     * </pre>
     *
     * @param string $pathParam_
     *
     * @return \Components\Uri
     */
    public function pushPathParam($pathParam_)
    {
      if(null===$pathParam_ || 1>String::length($pathParam_))
        return $this;

      array_push($this->m_pathParams, $pathParam_);

      return $this;
    }

    /**
     * Shifts path parameter off the beginning of path / Removes and returns first path parameter.
     *
     * <pre>
     *   [scheme]://[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *                                                   ^^^^
     * </pre>
     *
     * @return string
     */
    public function shiftPathParam()
    {
      return array_shift($this->m_pathParams);
    }

    /**
     * Adds given parameter to the beginning of path.
     *
     * <pre>
     *   [scheme]://[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *                                                   ^^^^
     * </pre>
     *
     * @param string $pathParam_
     *
     * @return \Components\Uri
     */
    public function unshiftPathParam($pathParam_)
    {
      array_unshift($this->m_pathParams, $pathParam_);

      return $this;
    }

    /**
     * Returns query string.
     *
     * <pre>
     *   [scheme]://[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *                                                          ^^^^^^^^^^^^
     * </pre>
     *
     * @return string
     */
    public function getQueryString()
    {
      $queryString=str_replace(
        array('+'),
        array('%20'),
        http_build_query($this->getQueryParams())
      );

      // FIXME Depends on php.ini configuration - Abstract components/config.
      $queryString=str_replace(
        array('&amp;'),
        array('&'),
        $queryString
      );

      if($this->getOptions()->has(self::OPTION_QUERY_STRING_FORMAT_JAXRS))
        $queryString=preg_replace('/%5B(?:[0-9]|[1-9][0-9]+)%5D=/', '=', $queryString);

      return $queryString;
    }

    /**
     * Replaces query parameters for given given query string.
     *
     * <pre>
     *   [scheme]://[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *                                                          ^^^^^^^^^^^^
     * </pre>
     *
     * @param string $queryString_
     *
     * @return \Components\Uri
     */
    public function setQueryString($queryString_)
    {
      $this->setQueryParams(self::parseQueryString($queryString_));

      return $this;
    }

    public function hasQueryParam($key_)
    {
      return array_key_exists($key_, $this->m_queryParams);
    }

    /**
     * Returns value for given query parameter.
     *
     * <pre>
     *   [scheme]://[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *                                                          ^^^^^^^^^^^^
     * </pre>
     *
     * @param string $key_
     *
     * @return mixed
     */
    public function getQueryParam($key_)
    {
      if(isset($this->m_queryParams[$key_]))
        return $this->m_queryParams[$key_];

      return null;
    }

    /**
     * Updates value for given query parameter.
     *
     * <pre>
     *   [scheme]://[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *                                                          ^^^^^^^^^^^^
     * </pre>
     *
     * @param string $key_
     * @param mixed $value_
     *
     * @return \Components\Uri
     */
    public function setQueryParam($key_, $value_)
    {
      $this->m_queryParams[$key_]=$value_;

      return $this;
    }

    /**
     * Removes given query parameter.
     *
     * @param string $key_
     *
     * @return \Components\Uri
     */
    public function removeQueryParam($key_)
    {
      unset($this->m_queryParams[$key_]);

      return $this;
    }

    /**
     * Returns query parameters.
     *
     * <pre>
     *   [scheme]://[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *                                                          ^^^^^^^^^^^^
     * </pre>
     *
     * @return array
     */
    public function getQueryParams()
    {
      return $this->m_queryParams;
    }

    /**
     * Replaces query parameters.
     *
     * <pre>
     *   [scheme]://[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *                                                          ^^^^^^^^^^^^
     * </pre>
     *
     * @return \Components\Uri
     */
    public function setQueryParams(array $queryParams_)
    {
      $this->m_queryParams=$queryParams_;

      return $this;
    }

    /**
     * Returns url fragment.
     *
     * <pre>
     *   [scheme]://[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *                                                                         ^^^^^^^^
     * </pre>
     *
     * @return string
     */
    public function getFragment()
    {
      return $this->m_fragment;
    }

    /**
     * Updates url fragment.
     *
     * <pre>
     *   [scheme]://[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *                                                                         ^^^^^^^^
     * </pre>
     *
     * @return \Components\Uri
     */
    public function setFragment($fragment_)
    {
      $this->m_fragment=$fragment_;

      return $this;
    }

    /**
     * @return boolean
     */
    public function hasFileExtension()
    {
      return false!==strpos(end($this->m_pathParams), '.');
    }

    /**
     * @return string
     */
    public function getFileExtension()
    {
      $filename=end($this->m_pathParams);

      return substr($filename, strpos($filename, '.')+1);
    }

    /**
     * @return string
     */
    public function getFilename($stripFileExtension_=false)
    {
      if(true===$stripFileExtension_)
      {
        $filename=end($this->m_pathParams);

        return substr($filename, 0, strpos($filename, '.'));
      }

      return end($this->m_pathParams);
    }

    /**
     * Connects to & resolves contents for this url.
     *
     * @return string
     */
    public function getContents()
    {
      return $contents=$this->getResolver()->getContents($this);
    }

    /**
     * Returns bitmask of activated options for this url.
     *
     * @return \Components\Bitmask
     */
    public function getOptions()
    {
      if(null===$this->m_options)
      {
        $this->m_options=Bitmask::forBits(array(
          self::OPTION_QUERY_STRING_FORMAT_PHP
        ));
      }

      return $this->m_options;
    }
    //--------------------------------------------------------------------------


    // OVERRIDES
    /**
     * (non-PHPdoc)
     * @see Components\Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return String::equals((string)$this, (string)$this);

      return false;
    }

    /**
     * (non-PHPdoc)
     * @see Components\Object::hashCode()
     */
    public function hashCode()
    {
      return string_hash((string)$this);
    }

    /**
     * (non-PHPdoc)
     * @see Components\Object::__toString()
     */
    public function __toString()
    {
      $string='';

      if($scheme=$this->getScheme())
        $string=$scheme.'://'.$this->getAuthority();

      if($path=$this->getPath())
        $string.=$path;

      if($queryString=$this->getQueryString())
        $string.='?'.$queryString;

      if($fragment=$this->getFragment())
        $string.='#'.String::urlEncode($fragment);

      return $string;
    }

    /**
     * (non-PHPdoc)
     * @see Components\Cloneable::__clone()
     */
    public function __clone()
    {
      $url=new self();

      $url->setScheme($this->getScheme());
      $url->setHost($this->getHost());
      $url->setPort($this->getPort());
      $url->setUsername($this->getUsername());
      $url->setPassword($this->getPassword());
      $url->setPathParams($this->getPathParams());
      $url->setQueryParams($this->getQueryParams());
      $url->setFragment($this->getFragment());

      if(null!==$this->m_options)
        $url->getOptions()->set($this->getOptions()->toBitmask());

      return $url;
    }

    /**
     * (non-PHPdoc)
     * @see Components\Serializable_Php::__sleep()
     */
    public function __sleep()
    {
      $this->m_asString=(string)$this;

      $serialize=array('m_asString');

      if(null!==$this->m_options)
        $serialize[]='m_options';
      if(null!==$this->m_resource)
        $serialize[]='m_resource';

      return $serialize;
    }

    /**
     * (non-PHPdoc)
     * @see Components\Serializable_Php::__wakeup()
     */
    public function __wakeup()
    {
      $uri=static::arrayForString($this->m_asString);

      $this->parseImpl($uri);
    }

    /**
     * (non-PHPdoc)
     * @see Components\Serializable::serialVersionUid()
     */
    public function serialVersionUid()
    {
      return 1;
    }

    /**
     * (non-PHPdoc)
     * @see Components\Value_String::value()
     */
    public function value()
    {
      return (string)$this;
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    protected $m_asString;
    /**
     * @var Components\Resource_Url
     */
    protected $m_resource;
    /**
     * @var Components\Bitmask
     */
    protected $m_options;
    protected $m_scheme;
    protected $m_host;
    protected $m_port;
    protected $m_password;
    protected $m_username;
    protected $m_pathParams=array();
    protected $m_queryParams=array();
    protected $m_fragment;
    //-----


    protected function parseImpl(array $uri_)
    {
      $this->m_scheme=isset($uri_['scheme'])?$uri_['scheme']:null;
      $this->m_host=isset($uri_['host'])?$uri_['host']:null;
      $this->m_port=isset($uri_['port'])?(int)$uri_['port']:null;
      $this->m_username=isset($uri_['user'])?String::urlDecode($uri_['user']):null;
      $this->m_password=isset($uri_['pass'])?String::urlDecode($uri_['pass']):null;

      $this->setPath(isset($uri_['path'])?$uri_['path']:null);
      $this->m_queryParams=isset($uri_['query'])?self::parseQueryString($uri_['query']):array();

      $this->m_fragment=isset($uri_['fragment'])?String::urlDecode($uri_['fragment']):null;
    }


    // HELPERS
    protected static function parseQueryString($queryString_)
    {
      $queryParams=array();

      if(!$queryString_=trim($queryString_))
        return $queryParams;

      foreach(explode('&', $queryString_) as $pair)
      {
        $chunks=explode('=', $pair);

        if(isset($chunks[1]))
          $queryParams[String::urlDecode($chunks[0])]=String::urlDecode($chunks[1]);
        else
          $queryParams[String::urlDecode($chunks[0])]=null;
      }

      return $queryParams;
    }

    protected static function arrayForString($uri_)
    {
      if(false===($uri=@parse_url($uri_)))
      {
        throw new Exception_IllegalArgument('components/type/uri',
          sprintf('Unable to parse URI for string [%1$s].', $uri_)
        );
      }

      return $uri;
    }
    //--------------------------------------------------------------------------
  }
?>
