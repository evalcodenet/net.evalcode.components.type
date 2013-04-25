<?php


namespace Components;


  /**
   * Map
   *
   * @package net.evalcode.components
   * @subpackage type
   *
   * @author evalcode.net
   */
  interface Map extends \ArrayAccess, Countable
  {
    // ACCESSORS
    /**
     * Determines whether this map is empty.
     *
     * @return boolean
     */
    function isEmpty();

    /**
     * Determines whether a value is linked to
     * given key in this map.
     *
     * @param mixed $key_
     */
    function containsKey($key_);

    /**
     * Determines whether given value exists in this map.
     *
     * @param mixed $value_
     */
    function containsValue($value_);

    /**
     * Returns value linked to given key in this map.
     *
     * @param mixed $key_
     */
    function get($key_);

    /**
     * Links given value to given key in this map.
     *
     * @param mixed $key_
     * @param mixed $value_
     */
    function put($key_, $value_);

    /**
     * Adds key/value pairs of given map to this one.
     *
     * @param Map $map_
     */
    function putMap(Map $map_);

    /**
     * Adds key/value pairs of given array to this one.
     *
     * @param mixed|array $array_
     */
    function putArray(array $array_);

    /**
     * Removes value linked to given key in this map.
     *
     * @param mixed $key_
     */
    function remove($key_);

    /**
     * Removes all key/value pairs of this map.
     */
    function clear();

    /**
     * Returns all keys of this map.
     *
     * @return mixed|array
     */
    function keys();

    /**
     * Returns collection of keys of this map.
     *
     * @return Collection
     */
    function keySet();

    /**
     * Returns all values of this map.
     *
     * @return mixed|array
     */
    function values();

    /**
     * Returns collection of values of this map.
     *
     * @return Collection
     */
    function valueSet();

    /**
     * Determines whether a value is linked to given key in this map.
     *
     * @param mixed $key_
     */
    function __isset($key_);

    /**
     * Unlinks value corresponding to given key in this map.
     *
     * @param mixed $key_
     */
    function __unset($key_);

    /**
     * Returns value linked to given key in this map.
     *
     * @param mixed $key_
     */
    function __get($key_);

    /**
     * Links given value to given key in this map.
     *
     * @param mixed $key_
     * @param mixed $value_
     */
    function __set($key_, $value_);

    /**
     * Returns array used as internal storage.
     *
     * @return mixed|array
     */
    function arrayValue();

    /**
     * Determines whether an element is linked to given offset in this map.
     *
     * @see ArrayAccess::offsetExists()
     *
     * @param mixed $offset_
     *
     * @return boolean
     */
    function offsetExists($offset_);

    /**
     * Returns the element linked to given offset in this map.
     *
     * @see ArrayAccess::offsetExists()
     *
     * @param mixed $offset_
     *
     * @return mixed
     */
    function offsetGet($offset_);

    /**
     * Links given element to given offset in this map.
     *
     * @see ArrayAccess::offsetExists()
     *
     * @param mixed $offset_
     * @param mixed $value_
     */
    function offsetSet($offset_, $value_);

    /**
     * Unlinks element corresponding to given offset in this map.
     *
     * @see ArrayAccess::offsetUnset()
     *
     * @param mixed $offset_
     */
    function offsetUnset($offset_);
    //--------------------------------------------------------------------------
  }
?>
