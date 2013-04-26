<?php


namespace Components;


  /**
   * Net_Uri_Resolver_Default
   *
   * @package tncNetPlugin
   * @subpackage lib.uri.resolver
   *
   * @author evalcode.net
   */
  class Net_Uri_Resolver_Default implements Net_Uri_Resolver
  {
    // CONSTRUCTION
    public function __construct()
    {
      $this->m_options=Misc_BitSet::forBitMask(0);
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
    /**
     * @var Misc_BitSet
     */
    private $m_options;
    //--------------------------------------------------------------------------
  }
?>