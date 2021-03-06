<?php


namespace Components;


  /**
   * Boolean
   *
   * <p>
   *   Boxed implementation for native PHP boolean.
   * </p>
   *
   * @api
   * @package net.evalcode.components.type
   *
   * @author evalcode.net
   */
  class Boolean extends Primitive implements Comparable, Cloneable, Value_Boolean
  {
    // PREDEFINED PROPERTIES
    const TYPE=__CLASS__;
    const TYPE_NATIVE='boolean';

    const TRUE_AS_STRING='true';
    const FALSE_AS_STRING='false';
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * Returns a negative integer, zero, or a positive integer as first
     * argument is less than, equal to, or greater than the second argument.
     *
     * For performance reasons prefer to use member method *\/
     * when comparing instances of *\/ and use
     * this static accessor for native booleans exclusively.
     *
     * @param \Components\Boolean|boolean $boolean0_
     * @param \Components\Boolean|boolean $boolean1_
     *
     * @throws \Components\Exception_IllegalCast
     */
    public static function compare($boolean0_, $boolean1_)
    {
      if($boolean0_===$boolean1_)
        return 0;

      if(true===$boolean0_)
        return 1;

      if(true===$boolean1_)
        return -1;

      if($boolean0_ instanceof self)
        $boolean0=$boolean0_->m_value;
      else
        $boolean0=$boolean0_;

      if($boolean1_ instanceof self)
        $boolean1=$boolean1_->m_value;
      else
        $boolean1=$boolean1_;

      if($boolean0===$boolean1)
        return 0;

      if(true===$boolean0)
        return 1;

      if(true===$boolean1)
        return -1;

      throw new Exception_IllegalCast('components/type/boolean', sprintf(
        'Can not compare given parameters [0: %s, 1: %s].',
          $boolean0_, $boolean1_
      ));
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
     * @return boolean
     */
    public static function cast($value_)
    {
      if(true===$value_ || false===$value_)
        return $value_;

      if(1===(int)$value_ || false!==stripos($value_, 'true'))
        return true;

      return false;
    }

    /**
     * @return boolean
     */
    public static function valueIsFalse($value_)
    {
      if(false===$value_ || 1!==(int)$value_ || false===stripos($value_, 'true'))
        return true;

      return false;
    }

    /**
     * @return boolean
     */
    public static function valueIsTrue($value_)
    {
      if(true===$value_ || 1===(int)$value_ || false!==stripos($value_, 'true'))
        return true;

      return false;
    }

    /**
     * @param mixed $value_
     *
     * @return string
     */
    public static function valueAsString($value_)
    {
      if(true===$value_ || 1===(int)$value_ || false!==stripos($value_, 'true'))
        return self::TRUE_AS_STRING;

      return self::FALSE_AS_STRING;
    }


    /**
     * @see \Components\Primitive::valueOf() \Components\Primitive::valueOf()
     *
     * @return \Components\Boolean
     */
    public static function valueOf($value_)
    {
      if(true===$value_ || 1===(int)$value_ || false!==stripos($value_, 'true'))
        return new static(true);

      return new static(false);
    }

    /**
     * @return \Components\Boolean
     */
    public static function true()
    {
      return new static(true);
    }

    /**
     * @return \Components\Boolean
     */
    public static function false()
    {
      return new static(false);
    }
    //--------------------------------------------------------------------------


    // ACCESSORS
    /**
     * @return boolean
     */
    public function booleanValue()
    {
      return $this->m_value;
    }

    /**
     * @return boolean
     */
    public function isTrue()
    {
      return true===$this->m_value;
    }

    /**
     * @return boolean
     */
    public function isFalse()
    {
      return true!==$this->m_value;
    }
    //--------------------------------------------------------------------------


    // OVERRIDES
    /**
     * @see \Components\Comparable::compareTo() \Components\Comparable::compareTo()
     */
    public function compareTo($object_)
    {
      if($object_ instanceof self)
      {
        if($this->m_value===$object_->m_value)
          return 0;

        if(true===$this->m_value)
          return 1;

        return -1;
      }

      if(true===$object_)
      {
        if(true===$this->m_value)
          return 0;

        return -1;
      }

      if(false===$object_)
      {
        if(false===$this->m_value)
          return 0;

        return 1;
      }

      $objectAsBoolean=true===$value_ || 1===(int)$value_ || false!==stripos($value_, 'true');

      if($this->m_value===$objectAsBoolean)
        return 0;

      if(true===$this->m_value)
        return 1;

      return -1;
    }

    /**
     * @see \Components\Object::hashCode() \Components\Object::hashCode()
     */
    public function hashCode()
    {
      return $this->m_value?1231:1237;
    }

    /**
     * @see \Components\Object::equals() \Components\Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return $this->m_value===$object_->m_value;

      return false;
    }

    /**
     * @see \Components\Object::__toString() \Components\Object::__toString()
     */
    public function __toString()
    {
      if(true===$this->m_value)
        return 'true';

      return 'false';
    }

    /**
     * @see \Components\Cloneable::__clone() \Components\Cloneable::__clone()
     */
    public function __clone()
    {
      return new self($this->m_value);
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
