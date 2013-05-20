<?php


namespace Components;


  /**
   * Resource_Url
   *
   * @package net.evalcode.components
   * @subpackage type.resource
   *
   * @author evalcode.net
   */
  interface Resource_Url extends Resource
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
