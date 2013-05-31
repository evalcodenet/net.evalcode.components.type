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
  interface Map extends \ArrayAccess, Collection
  {
    // ACCESSORS
    /**
     * Determines whether a value is linked to
     * given key in this map.
     *
     * @param mixed $key_
     *
     * @return boolean
     */
    function containsKey($key_);

    /**
     * Determines whether given value exists in this map.
     *
     * @param mixed $value_
     *
     * @return boolean
     */
    function containsValue($value_);

    /**
     * Returns value linked to given key in this map.
     *
     * @param mixed $key_
     *
     * @return mixed
     */
    function get($key_);

    /**
     * Links given value to given key in this map.
     *
     * @param mixed $key_
     * @param mixed $value_
     *
     * @return \Components\HashMap
     */
    function put($key_, $value_);

    /**
     * Adds key/value pairs of given map to this one.
     *
     * @param Map $map_
     *
     * @return \Components\HashMap
     */
    function putMap(Map $map_);

    /**
     * Adds key/value pairs of given array to this one.
     *
     * @param mixed|array $array_
     *
     * @return \Components\HashMap
     */
    function putArray(array $array_);

    /**
     * Removes and returns value linked to given key in this map.
     *
     * @param mixed $key_
     *
     * @return mixed
     */
    function remove($key_);

    /**
     * Removes all key/value pairs of this map.
     *
     * @return \Components\HashMap
     */
    function clear();

    /**
     * Returns all keys of this map.
     *
     * @return array|mixed
     */
    function keys();

    /**
     * Returns collection of keys of this map.
     *
     * @return \Components\Collection_Set
     */
    function keySet();

    /**
     * Returns all values of this map.
     *
     * @return array|mixed
     */
    function values();

    /**
     * Returns collection of values of this map.
     *
     * @return \Components\Collection_Set
     */
    function valueSet();

    /**
     * Determines whether a value is linked to given key in this map.
     *
     * @param mixed $key_
     *
     * @return boolean
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
     *
     * @return mixed
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
     * @see \Components\Collection::arrayValue()
     *
     * @return array|mixed
     */
    function arrayValue();

    /**
     * Determines whether an element is linked to given offset in this map.
     *
     * @see \ArrayAccess::offsetExists()
     *
     * @param mixed $offset_
     *
     * @return boolean
     */
    function offsetExists($offset_);

    /**
     * Returns the element linked to given offset in this map.
     *
     * @see \ArrayAccess::offsetExists()
     *
     * @param mixed $offset_
     *
     * @return mixed
     */
    function offsetGet($offset_);

    /**
     * Links given element to given offset in this map.
     *
     * @see \ArrayAccess::offsetExists()
     *
     * @param mixed $offset_
     * @param mixed $value_
     */
    function offsetSet($offset_, $value_);

    /**
     * Unlinks element corresponding to given offset in this map.
     *
     * @see \ArrayAccess::offsetUnset()
     *
     * @param mixed $offset_
     */
    function offsetUnset($offset_);
    //--------------------------------------------------------------------------
  }
?>
