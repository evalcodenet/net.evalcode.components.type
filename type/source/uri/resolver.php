<?php


namespace Components;


  /**
   * Uri_Resolver
   *
   * @package net.evalcode.components
   * @subpackage type.uri
   *
   * @author evalcode.net
   */
  interface Uri_Resolver
  {
    // ACCESSORS
    /**
     * @param \Components\Uri $uri_
     */
    function resolve(Uri $uri_);

    /**
     * @param \Components\Uri $uri_
     */
    function getContents(Uri $uri_);

    /**
     * @return \Components\Bitmask
     */
    function getOptions();
    //--------------------------------------------------------------------------
  }
?>
