<?php


namespace Components;


  /**
   * Character
   *
   * <p>
   *   Abstraction and utilities for character handling.
   * </p>
   *
   * @api
   * @package net.evalcode.components.type
   *
   * @author evalcode.net
   */
  class Character extends Primitive implements Number, Value_Integer
  {
    // PREDEFINED PROPERTIES
    const TYPE=__CLASS__;
    const TYPE_NATIVE=Integer::TYPE_NATIVE; // Emulate native type.
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * Returns a negative integer, zero, or a positive integer as first
     * argument is less than, equal to, or greater than the second argument.
     *
     * For performance reasons prefer to use member method *\/
     * when comparing instances of *\/ and use
     * the static accessor *\/ for integers exclusively.
     *
     * @param Character|int $character0_
     * @param Character|int $character1_
     *
     * @throws Exception_IllegalArgument
     */
    public static function compare($character0_, $character1_)
    {
      if(is_integer($character0_) && is_integer($character1_))
        return $character0_-$character1_;

      $a. $b=null;
      if($character0_ instanceof static)
        $a->$character0_->m_value;
      else if(is_integer($character0_))
        $a=$character0_;

      if($character1_ instanceof static)
        $b->$character1_->m_value;
      else if(is_integer($character1_))
        $b=$character1_;

      if(null===$a)
        $a=static::cast($character0_);
      if(null===$b)
        $b=static::cast($character1_);

      return $a-$b;
    }

    /**
     * @see \Components\Primitive::native() \Components\Primitive::native()
     */
    public static function native()
    {
      return self::TYPE_NATIVE;
    }

    /**
     * @see \Components\Primitive::cast() \Components\Primitive::cast()
     *
     * @param string|character $value_
     *
     * @return integer
     */
    public static function cast($value_)
    {
      return ord((string)$value_);
    }

    /**
     * @see \Components\Primitive::valueOf() \Components\Primitive::valueOf()
     *
     * @param integer $value_
     *
     * @return \Components\Character
     */
    public static function valueOf($value_)
    {
      return new static($value_);
    }

    /**
     * @param string $string_
     * @param integer $index_
     *
     * @return \Components\Character
     */
    public static function at($string_, $index_=0)
    {
      return new static(ord(mb_substr($string_, $index_, 1)));
    }

    public static function unicodeDecimal($char_)
    {
      $dec=ord($char_{0});

      if($dec&128)
      {
        $length=0;

        while($dec&128)
        {
          $length++;

          $dec<<=1;
        }
      }
      else
      {
        $length=1;
      }

      if(1===$length)
        return ord($char_);

      if($length!==strlen($char_))
        return false;

      $dec&=0xff;
      $dec>>=$length;

      for($i=1; $i<$length; $i++)
      {
        $dec<<=6;
        $dec|=ord($char_{$i})&0x3f;
      }

      return $dec;
    }

    public static function unicodeHex($char_)
    {
      return dechex(static::unicodeDecimal($char_));
    }
    //--------------------------------------------------------------------------


    // OVERRIDES
    /**
     * @return integer
     */
    function intValue()
    {
      return (int)$this->m_value;
    }

    /**
     * @return double
     */
    function doubleValue()
    {
      return (double)$this->m_value;
    }

    /**
     * @return float
     */
    function floatValue()
    {
      return (float)$this->m_value;
    }

    /**
     * @see \Components\Serializable_Php::serialize() \Components\Serializable_Php::serialize()
     */
    public function serialize()
    {
      return serialize($this->m_value);
    }

    /**
     * @see \Components\Serializable_Php::unserialize() \Components\Serializable_Php::unserialize()
     *
     * @return \Components\Character
     */
    public function unserialize($data_)
    {
      $this->m_value=unserialize($data_);

      return $this;
    }

    /**
     * @see \Components\Serializable::serialVersionUid() \Components\Serializable::serialVersionUid()
     */
    public function serialVersionUid()
    {
      return 1;
    }

    public function __sleep()
    {
      return array('m_value');
    }

    public function __wakeup()
    {

    }

    /**
     * @see \Components\Cloneable::__clone() \Components\Cloneable::__clone()
     */
    public function __clone()
    {
      return new static($this->m_value);
    }

    /**
     * @see \Components\Comparable::compareTo() \Components\Comparable::compareTo()
     */
    public function compareTo($object_)
    {
      if($object_ instanceof static)
        return $this->m_value-$object_->m_value;

      return $this->m_value-static::cast($object_);
    }

    /**
     * @see \Components\Object::hashCode() \Components\Object::hashCode()
     */
    public function hashCode()
    {
      return Integer::hash($this->m_value);
    }

    /**
     * @see \Components\Object::equals() \Components\Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof static)
        return $this->m_value===$object_->m_value;

      return false;
    }

    /**
     * @see \Components\Object::__toString() \Components\Object::__toString()
     */
    public function __toString()
    {
      return chr($this->m_value);
    }
    //--------------------------------------------------------------------------
  }
?>
