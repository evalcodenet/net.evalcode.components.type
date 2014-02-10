<?php


namespace Components;


  /**
   * Resource_Uri_Factory
   *
   * @api
   * @package net.evalcode.components.type
   * @subpackage resource.uri
   *
   * @author evalcode.net
   */
  class Resource_Uri_Factory implements Resource_Factory
  {
    // STATIC ACCESSORS
    /**
     * @param \Components\Uri $uri_
     *
     * @return \Components\Resource_Uri
     */
    public static function create(Uri $uri_)
    {
      if(Resource_Uri_Curl::isSupported())
        return new Resource_Uri_Curl($uri_);

      return new Resource_Uri_Default($uri_);
    }
    //--------------------------------------------------------------------------
  }
?>
