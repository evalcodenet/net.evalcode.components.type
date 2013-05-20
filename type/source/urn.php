<?php


namespace Components;


  /**
   * Urn
   *
   *  urn:namespace:namespace-specific-string
   *  \_/ \_______/ \_______________________/
   *   |      |                  |
   *   |  namespace       attributes+values
   *   |  \_________________________________/
   *   |             |
   * scheme         path
   *
   * @package net.evalcode.components
   * @subpackage type
   *
   * @author evalcode.net
   */
  class Urn extends Uri
  {
    // ACCESSORS
    public function getNamespace()
    {
      return $this->m_namespace;
    }

    public function setNamespace($namespace_)
    {
      $this->m_namespace=$namespace_;
    }
    //--------------------------------------------------------------------------


    // OVERRIDES
    // FIXME Should be not necessary if Uri()->getPath() is correct.
    public function getPath()
    {
      $pathParams=array();
      foreach($this->getPathParams() as $pathParam)
        array_push($pathParams, String::urlEncode($pathParam));

      return implode(':', $pathParams);
    }

    public function setPath($path_)
    {
      $this->m_pathParams=array();

      if(0==String::indexOf($path_, ':'))
        $pathParams=explode(':', String::substring($path_, 1));
      else
        $pathParams=explode(':', $path_);

      foreach($pathParams as $pathParam)
        $this->pushPathParam(String::urlDecode($pathParam));

      return $this;
    }

    public function equals($object_)
    {
      if($object_ instanceof self)
        return String::equal((string)$this, (string)$this);

      return false;
    }

    public function __toString()
    {
      $string=$this->getScheme().':'.$this->getNamespace();

      if($path=$this->getPath())
        $string.=':'.$path;

      return $string;
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    protected $m_namespace;
    //-----


    protected function parseImpl(array $urn_)
    {
      if(isset($urn_['scheme']))
        $this->setScheme($urn_['scheme']);
      else
        $this->setScheme('urn');

      $urn=explode(':', $urn_['path']);

      if(1>count($urn))
      {
        throw new Exception_IllegalArgument('components/type/urn',
          'An urn must contain at least [<scheme>:<namespace>:'.
          '<path|namespace-specific-string>].'
        );
      }

      $this->setNamespace(array_shift($urn));
      $this->setPathParams($urn);
    }
    //--------------------------------------------------------------------------
  }
?>
