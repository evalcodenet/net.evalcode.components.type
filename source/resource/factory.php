<?php


namespace Components;


  /**
   * Resource_Factory
   *
   * @api
   * @package net.evalcode.components.type
   * @subpackage resource
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
