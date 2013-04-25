<?php


namespace Components;


  /**
   * Net_Urn
   *
   *  urn:namespace:namespace-specific-string
   *  \_/ \_______/ \_______________________/
   *   |      |                  |
   *   |  namespace       attributes+values
   *   |  \_________________________________/
   *   |             |
   * scheme         path
   *
   * @package tncNetPlugin
   * @subpackage lib
   *
   * @author evalcode.net
   */
  class Net_Urn extends Net_Uri
  {
    // PREDEFINED PROPERTIES
    const NAME_CLASS_URN=__CLASS__;
    //--------------------------------------------------------------------------


    // ACCESSORS/MUTATORS
    public function getNamespace()
    {
      return $this->m_namespace;
    }

    public function setNamespace($namespace_)
    {
      $this->m_namespace=$namespace_;
    }
    //--------------------------------------------------------------------------


    // OVERRIDES/IMPLEMENTS
    // FIXME Should be not necessary if Net_Uri()->getPath() is correct.
    public function getPath()
    {
      $pathParams=array();
      foreach($this->getPathParams() as $pathParam)
        array_push($pathParams, Misc_Text::urlEncode($pathParam));

      return implode(':', $pathParams);
    }

    public function setPath($path_)
    {
      $this->m_pathParams=array();

      if(0==Misc_Text::pos($path_, ':'))
        $pathParams=explode(':', Misc_Text::sub($path_, 1));
      else
        $pathParams=explode(':', $path_);

      foreach($pathParams as $pathParam)
        $this->pushPathParam(Misc_Text::urlDecode($pathParam));

      return $this;
    }

    /**
     * @see Core_Class::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return Misc_Text::equals((string)$this, (string)$this);

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
        throw new Core_Exception('net/urn',
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
