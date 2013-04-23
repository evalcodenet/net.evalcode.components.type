<?php


  /**
   * HashMap
   *
   * @package net.evalcode.components
   * @subpackage type
   *
   * @author evalcode.net
   */
  class HashMap extends Primitive implements Map, Cloneable
  {
    // CONSTANTS
    const TYPE=__CLASS__;
    const TYPE_NATIVE='array';
    //--------------------------------------------------------------------------


    // CONSTRUCTION
    public function __construct(array $value_)
    {
      $this->m_value=$value_;
    }
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * @return string
     */
    public static function native()
    {
      return self::TYPE_NATIVE;
    }

    /**
     * @return array
     */
    public static function cast($value_)
    {
      return (array)$value_;
    }

    /**
     * @return HashMap
     */
    public static function valueOf($value_)
    {
      return new static(static::cast($value_));
    }

    /**
     * @return HashMap
     */
    public static function createEmpty()
    {
      return new static(array());
    }
    //--------------------------------------------------------------------------


    // ACCESSORS
    public function arrayValue()
    {
      return $this->m_value;
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTS
    /**
     * @see Map::isEmpty()
     */
    public function isEmpty()
    {
      return 0===count($this->m_keys);
    }

    /**
     * @see Map::containsKey()
     */
    public function containsKey($key_)
    {
      return isset($this->m_value[$key_]);
    }

    /**
     * @see Map::containsValue()
     */
    public function containsValue($value_)
    {
      return Arrays::containsValue($this->m_value, $value_, Arrays::UNSORTED);
    }

    /**
     * @see Map::get()
     */
    public function get($key_)
    {
      return $this->m_value[$key_];
    }

    /**
     * @see Map::put()
     */
    public function put($key_, $value_)
    {
      $this->m_value[$key_]=$value_;
    }

    /**
     * @see Map::putMap()
     */
    public function putMap(Map $map_)
    {
      foreach($map_->m_value as $key=>$value)
        $this->m_value[$key]=$value;
    }

    /**
     * @see Map::putArray()
     */
    public function putArray(array $array_)
    {
      foreach($array_ as $key=>$value)
        $this->m_value[$key_]=$value;
    }

    /**
     * @see Map::remove()
     */
    public function remove($key_)
    {
      // TODO Benchmark set null / unset / copy to new array.
      $value=$this->m_value[$key_];
      $this->m_value[$key_]=null;

      return $value;
    }

    /**
     * @see Map::clear()
     */
    public function clear()
    {
      $this->m_value=array();
    }

    /**
     * @see Map::keys()
     */
    public function keys()
    {
      return array_keys($this->m_value);
    }

    /**
     * @see Map::keySet()
     */
    public function keySet()
    {
      return Collection_Set::of($this->keys());
    }

    /**
     * @see Map::values()
     */
    public function values()
    {
      return array_values($this->m_value);
    }

    /**
     * @see Map::valueSet()
     */
    public function valueSet()
    {
      return Collection_Set::of($this->values());
    }

    /**
     * @see Map::__isset()
     */
    public function __isset($key_)
    {
      return isset($this->m_value[$key_]);
    }

    /**
     * @see Map::__unset()
     */
    public function __unset($key_)
    {
      unset($tihs->m_value[$key_]);
    }

    /**
     * @see Map::__get()
     */
    public function __get($key_)
    {
      return $this->m_value[$key_];
    }

    /**
     * @see Map::__set()
     */
    public function __set($key_, $value_)
    {
      $this->m_value[$key_]=$value_;
    }

    /**
     * @see Countable::count()
     */
    public function count()
    {
      return count($this->m_value);
    }

    /**
     * @see Map::offsetExists()
     */
    public function offsetExists($offset_)
    {
      return array_key_exists($offset_, $this->m_value);
    }

    /**
     * @see Map::offsetGet()
     */
    public function offsetGet($offset_)
    {
      return $this->m_value[$offset_];
    }

    /**
     * @see Map::offsetSet()
     */
    public function offsetSet($offset_, $value_)
    {
      $this->m_value[$offset_]=$value_;
    }

    /**
     * @see Map::offsetUnset()
     */
    public function offsetUnset($offset_)
    {
      // TODO Benchmark set null / unset / copy to new array.
      $this->m_value[$offset_]=null;
    }

    /**
     * @see Cloneable::__clone()
     */
    public function __clone()
    {
      return new static($this->m_value);
    }

    /**
     * @see Object::hashCode()
     */
    public function hashCode()
    {
      // TODO Implement
      return spl_object_hash($this);
    }

    /**
     * @see Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return $this->hashCode()===$object_->hashCode();

      return false;
    }

    /**
     * @see Object::__toString()
     */
    public function __toString()
    {
      return Arrays::toString($this->m_value);
    }
    //--------------------------------------------------------------------------
  }
?>
