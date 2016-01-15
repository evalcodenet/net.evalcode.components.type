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
    public function __construct(array $value_=[])
    {
      parent::__construct($value_);
    }
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * @see \Components\Primitive::native() native
     *
     * @return string
     */
    public static function native()
    {
      return self::TYPE_NATIVE;
    }

    /**
     * @see \Components\Primitive::cast() cast
     *
     * @param mixed $value_
     *
     * @return mixed[]
     */
    public static function cast($value_)
    {
      return (array)$value_;
    }

    /**
     * @see \Components\Primitive::valueOf() valueOf
     *
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


    // OVERRIDES/IMPLEMENTS
    /**
     * @see \Components\Collection::arrayValue() arrayValue
     */
    public function arrayValue()
    {
      return $this->m_value;
    }

    /**
     * @see \Components\Collection::isEmpty() isEmpty
     */
    public function isEmpty()
    {
      return 0===count($this->m_keys);
    }

    /**
     * @see \Components\Countable::count() count
     */
    public function count()
    {
      return count($this->m_value);
    }

    /**
     * @see \Components\Map::containsKey() containsKey
     */
    public function containsKey($key_)
    {
      return array_key_exists($key_, $this->m_value);
    }

    /**
     * @see \Components\Map::containsValue() containsValue
     */
    public function containsValue($value_)
    {
      return Arrays::containsValue($this->m_value, $value_, Arrays::UNSORTED);
    }

    /**
     * @see \Components\Map::get() get
     */
    public function get($key_)
    {
      if(false===isset($this->m_value[$key_]))
        return null;

      return $this->m_value[$key_];
    }

    /**
     * @see \Components\Map::put() put
     */
    public function put($key_, $value_)
    {
      $this->m_value[$key_]=$value_;

      return $this;
    }

    /**
     * @see \Components\Map::putMap() putMap
     */
    public function putMap(Map $map_)
    {
      foreach($map_->m_value as $key=>$value)
        $this->m_value[$key]=$value;

      return $this;
    }

    /**
     * @see \Components\Map::putArray() putArray
     */
    public function putArray(array $array_)
    {
      foreach($array_ as $key=>$value)
        $this->m_value[$key_]=$value;

      return $this;
    }

    /**
     * @see \Components\Map::remove() remove
     */
    public function remove($key_)
    {
      // TODO Benchmark set null / unset / copy to new array.
      $value=$this->m_value[$key_];
      $this->m_value[$key_]=null;

      return $value;
    }

    /**
     * @see \Components\Map::clear() clear
     */
    public function clear()
    {
      $this->m_value=[];

      return $this;
    }

    /**
     * @see \Components\Map::keys() keys
     */
    public function keys()
    {
      return array_keys($this->m_value);
    }

    /**
     * @see \Components\Map::keySet() keySet
     */
    public function keySet()
    {
      return Collection_Set::of($this->keys());
    }

    /**
     * @see \Components\Map::values() values
     */
    public function values()
    {
      return array_values($this->m_value);
    }

    /**
     * @see \Components\Map::valueSet() valueSet
     */
    public function valueSet()
    {
      return Collection_Set::of($this->values());
    }

    /**
     * @see \Components\Map::__isset() __isset
     */
    public function __isset($key_)
    {
      return array_key_exists($key_, $this->m_value);
    }

    /**
     * @see \Components\Map::__unset() __unset
     */
    public function __unset($key_)
    {
      unset($tihs->m_value[$key_]);
    }

    /**
     * @see \Components\Map::__get() __get
     */
    public function __get($key_)
    {
      return $this->m_value[$key_];
    }

    /**
     * @see \Components\Map::__set() __set
     */
    public function __set($key_, $value_)
    {
      $this->m_value[$key_]=$value_;
    }

    /**
     * @see \Components\Map::offsetExists() offsetExists
     */
    public function offsetExists($offset_)
    {
      return array_key_exists($offset_, $this->m_value);
    }

    /**
     * @see \Components\Map::offsetGet() offsetGet
     */
    public function offsetGet($offset_)
    {
      return $this->m_value[$offset_];
    }

    /**
     * @see \Components\Map::offsetSet() offsetSet
     */
    public function offsetSet($offset_, $value_)
    {
      $this->m_value[$offset_]=$value_;
    }

    /**
     * @see \Components\Map::offsetUnset() offsetUnset
     */
    public function offsetUnset($offset_)
    {
      // TODO Benchmark set null / unset / copy to new array.
      $this->m_value[$offset_]=null;
    }

    /**
     * @see \Components\Cloneable::__clone() __clone
     */
    public function __clone()
    {
      return new self($this->m_value);
    }

    /**
     * @see \Components\Object::hashCode() hashCode
     */
    public function hashCode()
    {
      // TODO Implement
      return \math\hasho($this);
    }

    /**
     * @see \Components\Object::equals() equals
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return $this->hashCode()===$object_->hashCode();

      return false;
    }

    /**
     * @see \Components\Object::__toString() __toString
     */
    public function __toString()
    {
      return Arrays::toString($this->m_value);
    }

    /**
     * @see \Components\Serializable::serialVersionUid() serialVersionUid
     */
    public function serialVersionUid()
    {
      return 1;
    }
    //--------------------------------------------------------------------------
  }
?>
