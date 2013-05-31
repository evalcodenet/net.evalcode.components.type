<?php


namespace Components;


  /**
   * Resource_Factory
   *
   * @package net.evalcode.components
   * @subpackage type.resource
   *
   * @author evalcode.net
   */
  interface Resource_Factory
  {
    // ACCESSORS
    /**
     * @param \Components\Uri $uri_
     *
     * @return \Components\Resource
     */
    static function create(Uri $uri_);
    //--------------------------------------------------------------------------
  }
?>
