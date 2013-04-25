<?php


namespace Components;


  /**
   * Collection
   *
   * @package net.evalcode.components
   * @subpackage type
   *
   * @author evalcode.net
   */
  interface Collection extends Object, Iterator, Countable
  {
    // ACCESSORS
    /**
     * Determines whether this collection is empty.
     *
     * @return boolean
     */
    function isEmpty();

    /**
     * Determines whether given element exists in this collection.
     *
     * @param mixed $element_
     */
    function contains($element_);

    /**
     * Determines whether given elements exist in this collection.
     *
     * @param array|mixed $elements_
     */
    function containsArray(array $elements_);

    /**
     * Determines whether elements of given collection exist in this one.
     *
     * @param Collection $elements_
     */
    function containsCollection(Collection $elements_);

    /**
     * Returns copy of array used as internal storage for this collection.
     *
     * @return array
     */
    function arrayValue();
    //--------------------------------------------------------------------------
  }
?>
