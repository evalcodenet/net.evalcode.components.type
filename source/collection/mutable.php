<?php


namespace Components;


  /**
   * Collection_Mutable
   *
   * @api
   * @package net.evalcode.components.type
   * @subpackage collection
   *
   * @author evalcode.net
   */
  interface Collection_Mutable extends Collection
  {
    // ACCESSORS
    /**
     * Adds given element to this collection.
     *
     * @param mixed $element_
     */
    function add($element_);
    /**
     * Adds all elements of given collection to this one.
     *
     * @param \Components\Collection $elements_
     */
    function addAll(Collection $elements_);
    /**
     * Removes given element from this collection
     * or current element if 'null' is passed.
     *
     * @param mixed $element_
     */
    function remove($element_=null);
    /**
     * Removes given subset of elements from this collection.
     *
     * @param \Components\Collection $elements_
     */
    function removeAll(Collection $elements_);
    /**
     * Removes elements from this collection
     * that are not present in given subset.
     *
     * @param \Components\Collection $elements_
     */
    function retainAll(Collection $elements_);
    /**
     * Removes all elements from this collection.
     */
    function clear();
    //--------------------------------------------------------------------------
  }
?>
