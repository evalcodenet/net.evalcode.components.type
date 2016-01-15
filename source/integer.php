<?php


namespace Components;


  /**
   * Integer
   *
   * <p>
   *   Boxed implementation for native PHP integer.
   * </p>
   *
   * @api
   * @package net.evalcode.components.type
   *
   * @author evalcode.net
   */
  class Integer extends Primitive implements Number, Value_Integer, Serializable_Php
  {
    // PREDEFINED PROPERTIES
    const TYPE=__CLASS__;
    const TYPE_NATIVE='integer';
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * @see \Components\Primitive::cast() \Components\Primitive::cast()
     *
     * @return string
     */
    public static function native()
    {
      return self::TYPE_NATIVE;
    }

    /**
     * @see \Components\Primitive::cast() \Components\Primitive::cast()
     *
     * @return integer
     */
    public static function cast($value_)
    {
      return (int)$value_;
    }

    /**
     * @see \Components\Primitive::valueOf() \Components\Primitive::valueOf()
     *
     * @return \Components\Integer
     */
    public static function valueOf($value_)
    {
      return new static((int)$value_);
    }

    /**
     * Returns passed integer as string in base 2.
     *
     * @param integer $integer_
     *
     * @return string
     */
    public static function toBinaryString($integer_)
    {
      return decbin($integer_);
    }

    /**
     * Returns passed integer as string in base 16.
     *
     * @param integer $integer_
     *
     * @return string
     */
    public static function toHexString($integer_)
    {
      return dechex($integer_);
    }

    /**
     * Returns passed integer as string in base 8.
     *
     * @param integer $integer_
     *
     * @return string
     */
    public static function toOctalString($integer_)
    {
      return decoct($integer_);
    }

    /**
     * @return integer
     */
    public static function hash($integer0_/*, $integer1_, $integer2_, ...*/)
    {
      return \math\hashia(func_get_args());
    }

    /**
     * @return \Components\Integer
     */
    public static function max()
    {
      return new static(PHP_INT_MAX);
    }

    /**
     * @return \Components\Integer
     */
    public static function zero()
    {
      return new static(0);
    }

    /**
     * @param integer $min_
     * @param integer $max_
     *
     * @return \Components\Integer
     */
    public static function random($min_=0, $max_=PHP_INT_MAX)
    {
      return new static(rand($min_, $max_));
    }
    //--------------------------------------------------------------------------


    // OVERRIDES
    /**
     * @see \Components\Number::intValue() intValue
     */
    public function intValue()
    {
      return $this->m_value;
    }

    /**
     * @see \Components\Number::doubleValue() doubleValue
     */
    public function doubleValue()
    {
      return (double)$this->m_value;
    }

    /**
     * @see \Components\Number::floatValue() floatValue
     */
    public function floatValue()
    {
      return (float)$this->m_value;
    }

    /**
     * @see \Components\Comparable::compareTo() compareTo
     */
    public function compareTo($object_)
    {
      if($object_ instanceof self)
      {
        if($this->m_value==$object_->m_value)
          return 0;

        if($this->m_value>$object_->m_value)
          return 1;

        return -1;
      }

      if(is_numeric($object_))
      {
        if($this->m_value==$object_)
          return 0;

        if($this->m_value>$object_)
          return 1;

        return -1;
      }

      throw new Exception_IllegalCast('integer', sprintf(
        'Can not compare to given parameter [%s].', $object_
      ));
    }

    /**
     * @see \Components\Serializable_Php::__wakeup() __wakeup
     */
    public function __wakeup()
    {
      // Do nothing.
    }

    /**
     * @see \Components\Serializable_Php::__sleep() __sleep
     */
    public function __sleep()
    {
      return ['m_value'];
    }

    /**
     * @see \Components\Serializable::serialVersionUid() serialVersionUid
     */
    public function serialVersionUid()
    {
      return 1;
    }

    /**
     * @see \Components\Cloneable::__clone() __clone
     */
    public function __clone()
    {
      return new static($this->m_value);
    }

    /**
     * @see \Components\Object::hashCode() hashCode
     */
    public function hashCode()
    {
      return \math\hashi($this->m_value);
    }

    /**
     * @see \Components\Object::equals() equals
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return $this->m_value===$object_->m_value;

      return false;
    }

    /**
     * @see \Components\Object::__toString() __toString
     */
    public function __toString()
    {
      return (string)$this->m_value;
    }
    //--------------------------------------------------------------------------
  }
?>
