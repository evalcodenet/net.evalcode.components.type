<?php


namespace Components;


  /**
   * HashMap
   *
   * @api
   * @package net.evalcode.components.type
   *
   * @author evalcode.net
   */
  class HashMap extends Primitive implements Map, Cloneable
  {
    // PREDEFINED PROPERTIES
    const TYPE=__CLASS__;
    const TYPE_NATIVE='array';
    //--------------------------------------------------------------------------


    // CONSTRUCTION
    public function __construct(array $value_=array())
    {
      parent::__construct($value_);
    }
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     *
     * @see \Components\Primitive::native() \Components\Primitive::native()
     * @return string
     */
    public static function native()
    {
      return self::TYPE_NATIVE;
    }

    /**
     * @param mixed $value_
     *
     * @return array
     */
    public static function cast($value_)
    {
      return (array)$value_;
    }

    /**
     * @param mixed $value_
     *
     * @return \Components\HashMap
     */
    public static function valueOf($value_)
    {
      return new static((array)$value_);
    }

    /**
     * @return \Components\HashMap
     */
    public static function createEmpty()
    {
      return new static();
    }
    //--------------------------------------------------------------------------


    // OVERRIDES
    /**
     * @see \Components\Collection::arrayValue() \Components\Collection::arrayValue()
     */
    public function arrayValue()
    {
      return $this->m_value;
    }

    /**
     * @see \Components\Collection::isEmpty() \Components\Collection::isEmpty()
     */
    public function isEmpty()
    {
      return 0===count($this->m_keys);
    }

    /**
     * @see \Components\Countable::count() \Components\Countable::count()
     */
    public function count()
    {
      return count($this->m_value);
    }

    /**
     * @see \Components\Map::containsKey() \Components\Map::containsKey()
     */
    public function containsKey($key_)
    {
      return isset($this->m_value[$key_]);
    }

    /**
     * @see \Components\Map::containsValue() \Components\Map::containsValue()
     */
    public function containsValue($value_)
    {
      return Arrays::containsValue($this->m_value, $value_, Arrays::UNSORTED);
    }

    /**
     * @see \Components\Map::get() \Components\Map::get()
     */
    public function get($key_)
    {
      return $this->m_value[$key_];
    }

    /**
     * @see \Components\Map::put() \Components\Map::put()
     */
    public function put($key_, $value_)
    {
      $this->m_value[$key_]=$value_;

      return $this;
    }

    /**
     * @see \Components\Map::putMap() \Components\Map::putMap()
     */
    public function putMap(Map $map_)
    {
      foreach($map_->m_value as $key=>$value)
        $this->m_value[$key]=$value;

      return $this;
    }

    /**
     * @see \Components\Map::putArray() \Components\Map::putArray()
     */
    public function putArray(array $array_)
    {
      foreach($array_ as $key=>$value)
        $this->m_value[$key_]=$value;

      return $this;
    }

    /**
     * @see \Components\Map::remove() \Components\Map::remove()
     */
    public function remove($key_)
    {
      // TODO Benchmark set null / unset / copy to new array.
      $value=$this->m_value[$key_];
      $this->m_value[$key_]=null;

      return $value;
    }

    /**
     * @see \Components\Map::clear() \Components\Map::clear()
     */
    public function clear()
    {
      $this->m_value=array();

      return $this;
    }

    /**
     * @see \Components\Map::keys() \Components\Map::keys()
     */
    public function keys()
    {
      return array_keys($this->m_value);
    }

    /**
     * @see \Components\Map::keySet() \Components\Map::keySet()
     */
    public function keySet()
    {
      return Collection_Set::of($this->keys());
    }

    /**
     * @see \Components\Map::values() \Components\Map::values()
     */
    public function values()
    {
      return array_values($this->m_value);
    }

    /**
     * @see \Components\Map::valueSet() \Components\Map::valueSet()
     */
    public function valueSet()
    {
      return Collection_Set::of($this->values());
    }

    /**
     * @see \Components\Map::__isset() \Components\Map::__isset()
     */
    public function __isset($key_)
    {
      return isset($this->m_value[$key_]);
    }

    /**
     * @see \Components\Map::__unset() \Components\Map::__unset()
     */
    public function __unset($key_)
    {
      unset($tihs->m_value[$key_]);
    }

    /**
     * @see \Components\Map::__get() \Components\Map::__get()
     */
    public function __get($key_)
    {
      return $this->m_value[$key_];
    }

    /**
     * @see \Components\Map::__set() \Components\Map::__set()
     */
    public function __set($key_, $value_)
    {
      $this->m_value[$key_]=$value_;
    }

    /**
     * @see \Components\Map::offsetExists() \Components\Map::offsetExists()
     */
    public function offsetExists($offset_)
    {
      return array_key_exists($offset_, $this->m_value);
    }

    /**
     * @see \Components\Map::offsetGet() \Components\Map::offsetGet()
     */
    public function offsetGet($offset_)
    {
      return $this->m_value[$offset_];
    }

    /**
     * @see \Components\Map::offsetSet() \Components\Map::offsetSet()
     */
    public function offsetSet($offset_, $value_)
    {
      $this->m_value[$offset_]=$value_;
    }

    /**
     * @see \Components\Map::offsetUnset() \Components\Map::offsetUnset()
     */
    public function offsetUnset($offset_)
    {
      // TODO Benchmark set null / unset / copy to new array.
      $this->m_value[$offset_]=null;
    }

    /**
     * @see \Components\Cloneable::__clone() \Components\Cloneable::__clone()
     */
    public function __clone()
    {
      return new self($this->m_value);
    }

    /**
     * @see \Components\Object::hashCode() \Components\Object::hashCode()
     */
    public function hashCode()
    {
      // TODO Implement
      return object_hash($this);
    }

    /**
     * @see \Components\Object::equals() \Components\Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return $this->hashCode()===$object_->hashCode();

      return false;
    }

    /**
     * @see \Components\Object::__toString() \Components\Object::__toString()
     */
    public function __toString()
    {
      return Arrays::toString($this->m_value);
    }

    /**
     * @see \Components\Serializable::serialVersionUid() \Components\Serializable::serialVersionUid()
     */
    public function serialVersionUid()
    {
      return 1;
    }
    //--------------------------------------------------------------------------
  }
?>
