<?php


namespace Components;


  /**
   * Resource_Url_Factory
   *
   * @api
   * @package net.evalcode.components.type
   * @subpackage resource.url
   *
   * @author evalcode.net
   */
  class Resource_Url_Factory implements Resource_Factory
  {
    // STATIC ACCESSORS
    /**
     * @param \Components\Uri $uri_
     *
     * @return \Components\Resource_Url
     */
    public static function create(Uri $uri_)
    {
      if(Resource_Url_Curl::isSupported())
        return new Resource_Url_Curl($uri_);

      return new Resource_Url_Default($uri_);
    }
    //--------------------------------------------------------------------------
  }
?>
