<?php


namespace Components;


  /**
   * Number
   *
   * @package net.evalcode.components
   * @subpackage type
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
