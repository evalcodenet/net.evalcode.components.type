<?php


namespace Components;


  /**
   * Number
   *
   * @api
   * @package net.evalcode.components.type
   *
   * @author evalcode.net
   */
  interface Number extends Comparable, Cloneable
  {
    // ACCESSORS
    /**
     * @return integer
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
