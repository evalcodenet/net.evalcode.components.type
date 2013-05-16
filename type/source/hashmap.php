<?php


namespace Components;


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
    // PREDEFINED PROPERTIES
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
     *
     * @see Components\Primitive::native()
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
      return new static(array());
    }
    //--------------------------------------------------------------------------


    // OVERRIDES
    /**
     * (non-PHPdoc)
     * @see Components\Collection::arrayValue()
     */
    public function arrayValue()
    {
      return $this->m_value;
    }

    /**
     * (non-PHPdoc)
     * @see Components\Collection::isEmpty()
     */
    public function isEmpty()
    {
      return 0===count($this->m_keys);
    }

    /**
     * (non-PHPdoc)
     * @see Components\Countable::count()
     */
    public function count()
    {
      return count($this->m_value);
    }

    /**
     * (non-PHPdoc)
     * @see Components\Map::containsKey()
     */
    public function containsKey($key_)
    {
      return isset($this->m_value[$key_]);
    }

    /**
     * (non-PHPdoc)
     * @see Components\Map::containsValue()
     */
    public function containsValue($value_)
    {
      return Arrays::containsValue($this->m_value, $value_, Arrays::UNSORTED);
    }

    /**
     * (non-PHPdoc)
     * @see Components\Map::get()
     */
    public function get($key_)
    {
      return $this->m_value[$key_];
    }

    /**
     * (non-PHPdoc)
     * @see Components\Map::put()
     */
    public function put($key_, $value_)
    {
      $this->m_value[$key_]=$value_;
    }

    /**
     * (non-PHPdoc)
     * @see Components\Map::putMap()
     */
    public function putMap(Map $map_)
    {
      foreach($map_->m_value as $key=>$value)
        $this->m_value[$key]=$value;
    }

    /**
     * (non-PHPdoc)
     * @see Components\Map::putArray()
     */
    public function putArray(array $array_)
    {
      foreach($array_ as $key=>$value)
        $this->m_value[$key_]=$value;
    }

    /**
     * (non-PHPdoc)
     * @see Components\Map::remove()
     */
    public function remove($key_)
    {
      // TODO Benchmark set null / unset / copy to new array.
      $value=$this->m_value[$key_];
      $this->m_value[$key_]=null;

      return $value;
    }

    /**
     * (non-PHPdoc)
     * @see Components\Map::clear()
     */
    public function clear()
    {
      $this->m_value=array();
    }

    /**
     * (non-PHPdoc)
     * @see Components\Map::keys()
     */
    public function keys()
    {
      return array_keys($this->m_value);
    }

    /**
     * (non-PHPdoc)
     * @see Components\Map::keySet()
     */
    public function keySet()
    {
      return Collection_Set::of($this->keys());
    }

    /**
     * (non-PHPdoc)
     * @see Components\Map::values()
     */
    public function values()
    {
      return array_values($this->m_value);
    }

    /**
     * (non-PHPdoc)
     * @see Components\Map::valueSet()
     */
    public function valueSet()
    {
      return Collection_Set::of($this->values());
    }

    /**
     * (non-PHPdoc)
     * @see Components\Map::__isset()
     */
    public function __isset($key_)
    {
      return isset($this->m_value[$key_]);
    }

    /**
     * (non-PHPdoc)
     * @see Components\Map::__unset()
     */
    public function __unset($key_)
    {
      unset($tihs->m_value[$key_]);
    }

    /**
     * (non-PHPdoc)
     * @see Components\Map::__get()
     */
    public function __get($key_)
    {
      return $this->m_value[$key_];
    }

    /**
     * (non-PHPdoc)
     * @see Components\Map::__set()
     */
    public function __set($key_, $value_)
    {
      $this->m_value[$key_]=$value_;
    }

    /**
     * (non-PHPdoc)
     * @see Components\Map::offsetExists()
     */
    public function offsetExists($offset_)
    {
      return array_key_exists($offset_, $this->m_value);
    }

    /**
     * (non-PHPdoc)
     * @see Components\Map::offsetGet()
     */
    public function offsetGet($offset_)
    {
      return $this->m_value[$offset_];
    }

    /**
     * (non-PHPdoc)
     * @see Components\Map::offsetSet()
     */
    public function offsetSet($offset_, $value_)
    {
      $this->m_value[$offset_]=$value_;
    }

    /**
     * (non-PHPdoc)
     * @see Components\Map::offsetUnset()
     */
    public function offsetUnset($offset_)
    {
      // TODO Benchmark set null / unset / copy to new array.
      $this->m_value[$offset_]=null;
    }

    /**
     * (non-PHPdoc)
     * @see Components\Cloneable::__clone()
     */
    public function __clone()
    {
      return new self($this->m_value);
    }

    /**
     * (non-PHPdoc)
     * @see Components\Object::hashCode()
     */
    public function hashCode()
    {
      // TODO Implement
      return object_hash($this);
    }

    /**
     * (non-PHPdoc)
     * @see Components\Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return $this->hashCode()===$object_->hashCode();

      return false;
    }

    /**
     * (non-PHPdoc)
     * @see Components\Object::__toString()
     */
    public function __toString()
    {
      return Arrays::toString($this->m_value);
    }

    /**
     * (non-PHPdoc)
     * @see Components\Serializable::serialVersionUid()
     */
    public function serialVersionUid()
    {
      return 1;
    }
    //--------------------------------------------------------------------------
  }
?>
