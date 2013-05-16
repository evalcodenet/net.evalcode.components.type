<?php


namespace Components;


  /**
   * Uri_Resolver_Curl
   *
   * @package net.evalcode.components
   * @subpackage type.uri.resolver
   *
   * @author evalcode.net
   */
  class Uri_Resolver_Curl implements Uri_Resolver
  {
    // PREDEFINED PROPERTIES
    // TODO CURL options
    //--------------------------------------------------------------------------


    // CONSTRUCTION
    public function __construct()
    {
      $this->m_options=Bitmask::createEmpty();
    }
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    public static function isSupported()
    {
      if(null===self::$m_isSupported)
        self::$m_isSupported=extension_loaded('curl');

      return self::$m_isSupported;
    }
    //--------------------------------------------------------------------------


    // OVERRIDES
    /**
     * (non-PHPdoc)
     * @see Components\Uri_Resolver::resolve()
     */
    public function resolve(Uri $uri_)
    {
      // TODO Implement
    }

    /**
     * (non-PHPdoc)
     * @see Components\Uri_Resolver::getContents()
     */
    public function getContents(Uri $uri_)
    {
      // TODO Implement curl
      return @file_get_contents((string)$uri_);
    }

    /**
     * (non-PHPdoc)
     * @see Components\Uri_Resolver::getOptions()
     */
    public function getOptions()
    {
      return $this->m_options;
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    /**
     * @var boolean
     */
    private static $m_isSupported;

    /**
     * @var Components\Bitmask
     */
    private $m_options;
    //--------------------------------------------------------------------------
  }
?>
