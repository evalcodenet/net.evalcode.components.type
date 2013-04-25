<?php


namespace Components;


  /**
   * Net_Uri_Resolver
   *
   * @package tncNetPlugin
   * @subpackage lib.uri
   *
   * @author evalcode.net
   */
  interface Net_Uri_Resolver
  {
    // ACCESSORS/MUTATORS
    function resolve(Net_Uri $uri_);

    function getContents(Net_Uri $uri_);

    /**
     * @return Misc_BitSet
     */
    function getOptions();
    //--------------------------------------------------------------------------
  }
?>
