<?php


namespace Components;


  /**
   * Resource_Uri_Default
   *
   * @api
   * @package net.evalcode.components.type
   * @subpackage resource.uri
   *
   * @author evalcode.net
   */
  class Resource_Uri_Default implements Resource_Uri
  {
    // CONSTRUCTION
    public function __construct(Uri $uri_)
    {
      $this->m_uri=$uri_;
      $this->m_options=Bitmask::createEmpty();
    }
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * @return boolean
     */
    public static function isSupported()
    {
      return true;
    }
    //--------------------------------------------------------------------------


    // OVERRIDES
    /**
     * @see \Components\Resource_Uri::resolve() resolve
     */
    public function resolve()
    {
      return $this->getContents();
    }

    /**
     * @see \Components\Resource_Uri::getContents() getContents
     */
    public function getContents()
    {
      return file_get_contents((string)$this->m_uri);
    }

    /**
     * @see \Components\Resource_Uri::getOptions() getOptions
     */
    public function getOptions()
    {
      return $this->m_options;
    }

    /**
     * @see \Components\Object::hashCode() hashCode
     */
    public function hashCode()
    {
      return object_hash($this);
    }

    /**
     * @see \Components\Object::equals() equals
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return $this->hashCode()===$object_->hashCode();

      return false;
    }

    /**
     * @see \Components\Object::__toString() __toString
     */
    public function __toString()
    {
      return sprintf('%s@%s{uri: %s, options: %s}',
        __CLASS__,
        $this->hashCode(),
        $this->m_uri,
        $this->m_options
      );
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    /**
     * @var boolean
     */
    private static $m_isSupported;
    /**
     * @var \Components\Uri
     */
    private $m_uri;
    /**
     * @var \Components\Bitmask
     */
    private $m_options;
    //--------------------------------------------------------------------------
  }
?>
