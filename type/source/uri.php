<?php


namespace Components;


  /**
   * Net_Uri
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
   * @package tncNetPlugin
   * @subpackage lib
   *
   * @author evalcode.net
   */
  class Net_Uri implements Core_Class_Serializable
  {
    // PREDEFINED PROPERTIES
    const NAME_CLASS_URI=__CLASS__;

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
     * Parses given string and returns an corresponding instance of Net_Uri.
     *
     * @param string $url_
     *
     * @return Net_Uri
     */
    public static function parse($uri_)
    {
      $uri=self::arrayForString($uri_);

      if(isset($uri['scheme'])
        && ($impl=Net_Scheme::getImplTypeForScheme($uri['scheme'])))
        $instance=new $impl();
      else
        $instance=new self();

      $instance->parseImpl($uri);

      return $instance;
    }
    //--------------------------------------------------------------------------


    // ACCESSORS/MUTATORS
    /**
     * @return Net_Uri_Resolver
     */
    public function getResolver()
    {
      // TODO Should be definable.
      if(null===$this->m_resolver)
      {
        if(Net_Uri_Resolver_Curl::isCurlSupported())
          $this->m_resolver=new Net_Uri_Resolver_Curl();
        else
          $this->m_resolver=new Net_Uri_Resolver_Default();
      }

      return $this->m_resolver;
    }

    public function setResolver(Net_Uri_Resolver $resolver_)
    {
      $this->m_resolver=$resolver_;
    }

    /**
     * Returns scheme.
     *
     * <pre>
     *   [scheme:]//[username]:[password]@[host]:[port]/[path]?[query_string]#[fragment]
     *    ^^^^^^^
     * </pre>
     *
     * @return Net_Uri
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
     * @return Net_Uri
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
        $user=Misc_Text::urlEncode($user);

        if($password=$this->getPassword())
          $user.=':'.Misc_Text::urlEncode($password);

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
     * @return Net_Uri
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
     * @return Net_Uri
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
     * @return int
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
     * @param int $port_
     *
     * @return Net_Uri
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
     * @return Net_Uri
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
     * @return Net_Uri
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
        array_push($pathParams, Misc_Text::urlEncode($pathParam));

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
     * @return Net_Uri
     */
    public function setPath($path_)
    {
      $this->m_pathParams=array();

      if(0==mb_strpos($path_, '/'))
        $pathParams=explode('/', mb_substr($path_, 1));
      else
        $pathParams=explode('/', $path_);

      foreach($pathParams as $pathParam)
        $this->pushPathParam(Misc_Text::urlDecode($pathParam));

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
     * @return Net_Uri
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
    public function getPathParams()
    {
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
     * @param int $idx_ Array-index of path parameters / Position of parameter in path.
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
     * @param int $idx_ Array-index of path parameters / Position of parameter in path.
     * @param string $pathParam_
     *
     * @return Net_Uri
     */
    public function setPathParam($idx_, $pathParam_)
    {
      if(null===$pathParam_ || 1>Misc_Text::len($pathParam_))
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
     * @return Net_Uri
     */
    public function pushPathParam($pathParam_)
    {
      if(null===$pathParam_ || 1>Misc_Text::len($pathParam_))
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
     * @return Net_Uri
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

      // FIXME Depends on php.ini configuration - Abstract with tncCorePlugin / Core_Config.
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
     * @return Net_Uri
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
     * @return Net_Uri
     */
    public function setQueryParam($key_, $value_)
    {
      $this->m_queryParams[$key_]=$value_;

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
     * @return Net_Uri
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
     * @return Net_Uri
     */
    public function setFragment($fragment_)
    {
      $this->m_fragment=$fragment_;

      return $this;
    }

    /**
     * Connects to & resolves contents for this url.
     *
     * @throws Core_Exception
     *
     * @return string
     */
    public function getContents()
    {
      if(false===($contents=$this->getResolver()->getContents($this)))
      {
        throw new Core_Exception('net/uri',
          sprintf('Unable to retrieve contents for URL [%1$s]', $this)
        );
      }

      return $contents;
    }

    /**
     * Returns bitset of activated options for this url.
     *
     * @return Misc_BitSet
     */
    public function getOptions()
    {
      if(null===$this->m_options)
      {
        $this->m_options=Misc_BitSet::forBitSet(array(
          self::OPTION_QUERY_STRING_FORMAT_PHP
        ));
      }

      return $this->m_options;
    }
    //--------------------------------------------------------------------------


    // OVERRIDES/IMPLEMENTS
    /**
     * @see Core_Class::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return Misc_Text::equals((string)$this, (string)$this);

      return false;
    }

    /**
     * @see Core_Class::hashCode()
     */
    public function hashCode()
    {
      return spl_object_hash($this);
    }

    /**
     * @see Core_Class_Serializable::serialize()
     */
    public function serialize()
    {
      return (string)$this;
    }

    /**
     * @see Core_Class_Serializable::unserialize()
     */
    public function unserialize($string_)
    {
      return self::parse($string_);
    }

    /**
     * @see Core_Class_Serializable::serialVersionUid()
     */
    public function serialVersionUid()
    {
      return 1;
    }

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
        $string.='#'.Misc_Text::urlEncode($fragment);

      return $string;
    }

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

      if(null!==$this->m_resolver)
      {
        $resolver=get_class($this->m_resolver);
        $url->setResolver(new $resolver());
      }

      if(null!==$this->m_options)
        $url->getOptions()->set($this->getOptions()->toBitMask());

      return $url;
    }

    public function __sleep()
    {
      $this->m_asString=(string)$this;

      $serialize=array('m_asString');

      if(null!==$this->m_options)
        $serialize[]='m_options';
      if(null!==$this->m_resolver)
        $serialize[]='m_resolver';

      return $serialize;
    }

    public function __wakeup()
    {
      $uri=self::arrayForString($this->m_asString);

      $this->parseImpl($uri);
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    protected $m_asString;
    /**
     * @var Net_Uri_Resolver
     */
    protected $m_resolver;
    /**
     * @var Misc_BitSet
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
      $this->setScheme(isset($uri_['scheme'])?$uri_['scheme']:null);
      $this->setHost(isset($uri_['host'])?$uri_['host']:null);
      $this->setPort(isset($uri_['port'])?$uri_['port']:null);
      $this->setUsername(isset($uri_['user'])?Misc_Text::urlDecode($uri_['user']):null);
      $this->setPassword(isset($uri_['pass'])?Misc_Text::urlDecode($uri_['pass']):null);
      $this->setPath(isset($uri_['path'])?$uri_['path']:null);
      $this->setQueryString(isset($uri_['query'])?$uri_['query']:null);
      $this->setFragment(isset($uri_['fragment'])?Misc_Text::urlDecode($uri_['fragment']):null);
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
          $queryParams[Misc_Text::urlDecode($chunks[0])]=Misc_Text::urlDecode($chunks[1]);
        else
          $queryParams[Misc_Text::urlDecode($chunks[0])]=null;
      }

      return $queryParams;
    }

    protected static function arrayForString($uri_)
    {
      if(false===($uri=@parse_url($uri_)))
      {
        throw new Core_Exception('net/uri',
          sprintf('Unable to parse URI for string [%1$s].', $uri_)
        );
      }

      return $uri;
    }
    //--------------------------------------------------------------------------
  }
?>
