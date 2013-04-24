<?php


  /**
   * Object_Unmarshaller
   *
   * @package net.evalcode.components
   * @subpackage type.object
   *
   * @author evalcode.net
   */
  interface Object_Unmarshaller
  {
    // ACCESSORS
    function unmarshal($data_, /*Class<Object>*/ $type_);
    //--------------------------------------------------------------------------
  }
?>
