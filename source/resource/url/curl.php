<?php


namespace Components;


  /**
   * Resource_Url_Curl
   *
   * @package net.evalcode.components
   * @subpackage type.resource.url
   *
   * @author evalcode.net
   */
  class Resource_Url_Curl implements Resource_Url
  {
    // PREDEFINED PROPERTIES
    // TODO CURL options
    //--------------------------------------------------------------------------


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
      if(null===self::$m_isSupported)
        self::$m_isSupported=extension_loaded('curl');

      return self::$m_isSupported;
    }
    //--------------------------------------------------------------------------


    // OVERRIDES
    /**     * @see \Components\Resource_Url::resolve() \Components\Resource_Url::resolve()
     */
    public function resolve()
    {
      // TODO Implement
    }

    /**     * @see \Components\Resource_Url::getContents() \Components\Resource_Url::getContents()
     */
    public function getContents()
    {
      // TODO Implement curl
      return file_get_contents((string)$this->m_uri);
    }

    /**     * @see \Components\Resource_Url::getOptions() \Components\Resource_Url::getOptions()
     */
    public function getOptions()
    {
      return $this->m_options;
    }

    /**     * @see \Components\Object::hashCode() \Components\Object::hashCode()
     */
    public function hashCode()
    {
      return object_hash($this);
    }

    /**     * @see \Components\Object::equals() \Components\Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return $this->hashCode()===$object_->hashCode();

      return false;
    }

    /**     * @see \Components\Object::__toString() \Components\Object::__toString()
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
     * @var Components\Uri
     */
    private $m_uri;
    /**
     * @var Components\Bitmask
     */
    private $m_options;
    //--------------------------------------------------------------------------
  }
?>
