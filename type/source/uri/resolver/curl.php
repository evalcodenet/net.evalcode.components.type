<?php


namespace Components;


  /**
   * Net_Uri_Resolver_Curl
   *
   * @package tncNetPlugin
   * @subpackage lib.uri.resolver
   *
   * @author evalcode.net
   */
  class Net_Uri_Resolver_Curl implements Net_Uri_Resolver
  {
    // PREDEFINED PROPERTIES
    // TODO CURL options
    //--------------------------------------------------------------------------


    // CONSTRUCTION
    public function __construct()
    {
      $this->m_options=Misc_BitSet::forBitMask(0);
    }
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    public static function isCurlSupported()
    {
      if(null===self::$m_isCurlSupported)
        self::$m_isCurlSupported=extension_loaded('curl');

      return self::$m_isCurlSupported;
    }
    //--------------------------------------------------------------------------


    // OVERRIDES/IMPLEMENTS
    /**
     * @see Net_Resolver::resolve()
     */
    public function resolve(Net_Uri $uri_)
    {
      // TODO Implement
    }

    /**
     * @see Net_Resolver::getContents()
     */
    public function getContents(Net_Uri $uri_)
    {
      // TODO Implement curl
      return @file_get_contents((string)$uri_);
    }

    /**
     * @see Net_Resolver::getOptions()
     */
    public function getOptions()
    {
      return $this->m_options;
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    private static $m_isCurlSupported;
    /**
     * @var Misc_BitSet
     */
    private $m_options;
    //--------------------------------------------------------------------------
  }
?>
