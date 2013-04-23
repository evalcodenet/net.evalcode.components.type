<?php


  /**
   * Number
   *
   * @package net.evalcode.components
   * @subpackage type
   *
   * @author evalcode.net
   */
  interface Number extends Object, Cloneable, Comparable, Serializable
  {
    // ACCESSORS
    /**
     * @return int
     */
    function intValue();

    /**
     * @return double
     */
    function doubleValue();

    /**
     * @return float
     */
    function floatValue();
    //--------------------------------------------------------------------------
  }
?>
