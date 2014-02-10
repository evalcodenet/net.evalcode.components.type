<?php


namespace Components;


  /**
   * Resource_Uri
   *
   * @api
   * @package net.evalcode.components.type
   * @subpackage resource
   *
   * @author evalcode.net
   */
  interface Resource_Uri extends Resource
  {
    // ACCESSORS
    function resolve();
    /**
     * @return string
     */
    function getContents();
    /**
     * @return \Components\Bitmask
     */
    function getOptions();
    //--------------------------------------------------------------------------
  }
?>
