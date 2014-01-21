<?php


namespace Components;


  /**
   * Resource_Url_Curl
   *
   * @api
   * @package net.evalcode.components.type
   * @subpackage resource.url
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


    // ACCESSORS/MUTATORS
    // TODO Magic custom method & protocol support.
    public function purge()
    {
      $curl=curl_init();

      curl_setopt($curl, CURLOPT_URL, (string)$this->m_uri);
      curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PURGE');
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 0);

      curl_exec($curl);

      curl_close($curl);
    }
    //--------------------------------------------------------------------------


    // OVERRIDES/IMPLEMENTS
    /**
     * @see \Components\Resource_Url::resolve() resolve
     */
    public function resolve()
    {
      // TODO Implement
    }

    /**
     * @see \Components\Resource_Url::getContents() getContents
     */
    public function getContents()
    {
      // TODO Implement curl
      return $this->get();
    }

    /**
     * @see \Components\Resource_Url::getOptions() getOptions
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
     * @var resource
     */
    private $m_curl;
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
