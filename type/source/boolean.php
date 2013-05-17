<?php


namespace Components;


  /**
   * Boolean
   *
   * <p>
   *   Boxed implementation for native PHP boolean.
   * </p>
   *
   * @package net.evalcode.components
   * @subpackage type
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
     * For performance reasons prefer to use member method {@code compareTo}
     * when comparing instances of {@code Boolean} and use
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
     * @see Components\Primitive::native()
     */
    public static function native()
    {
      return self::TYPE_NATIVE;
    }

    /**
     * @see Components\Primitive::cast()
     *
     * @return boolean
     */
    public static function cast($value_)
    {
      if(true===$value_ || false===$value_)
        return $value_;

      if(1===(int)$value_ || 'true'===(string)$value_ || 'true'===trim(strtolower((string)$value_)))
        return true;

      return false;
    }

    /**
     * (non-PHPdoc)
     * @see Components\Primitive::valueOf()
     *
     * @return \Components\Boolean
     */
    public static function valueOf($value_)
    {
      return new static(static::cast($value_));
    }

    /**
     * @return \Components\Boolean
     */
    public static function TRUE()
    {
      return new static(true);
    }

    /**
     * @return \Components\Boolean
     */
    public static function FALSE()
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
     * (non-PHPdoc)
     * @see Components\Comparable::compareTo()
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

      $objectAsBoolean=static::cast($object_);

      if($this->m_value===$objectAsBoolean)
        return 0;

      if(true===$this->m_value)
        return 1;

      return -1;
    }

    /**
     * (non-PHPdoc)
     * @see Components\Object::hashCode()
     */
    public function hashCode()
    {
      return $this->m_value?1231:1237;
    }

    /**
     * (non-PHPdoc)
     * @see Components\Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return $this->m_value===$object_->m_value;

      return false;
    }

    /**
     * (non-PHPdoc)
     * @see Components\Object::__toString()
     */
    public function __toString()
    {
      if(true===$this->m_value)
        return self::TRUE_AS_STRING;

      return self::FALSE_AS_STRING;
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
     * @see Components\Serializable::serialVersionUid()
     */
    public function serialVersionUid()
    {
      return 1;
    }
    //--------------------------------------------------------------------------
  }
?>
