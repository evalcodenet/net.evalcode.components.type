<?php


namespace Components;


  /**
   * Uri_Resolver_Default
   *
   * @package net.evalcode.components
   * @subpackage type.uri.resolver
   *
   * @author evalcode.net
   */
  class Uri_Resolver_Default implements Uri_Resolver
  {
    // CONSTRUCTION
    public function __construct()
    {
      $this->m_options=Bitmask::createEmpty();
    }
    //--------------------------------------------------------------------------


    // OVERRIDES
    /**
     * (non-PHPdoc)
     * @see Components.Uri_Resolver::resolve()
     */
    public function resolve(Uri $uri_)
    {
      // TODO Implement
    }

    /**
     * (non-PHPdoc)
     * @see Components.Uri_Resolver::getContents()
     */
    public function getContents(Uri $uri_)
    {
      return @file_get_contents((string)$uri_);
    }

    /**
     * (non-PHPdoc)
     * @see Components.Uri_Resolver::getOptions()
     */
    public function getOptions()
    {
      return $this->m_options;
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    /**
     * @var Components\Bitmask
     */
    private $m_options;
    //--------------------------------------------------------------------------
  }
?>
