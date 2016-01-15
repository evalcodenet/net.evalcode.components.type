<?php


namespace Components;


  /**
   * Double
   *
   * <p>
   *   Boxed implementation for native PHP double.
   * </p>
   *
   * @api
   * @package net.evalcode.components.type
   *
   * @author evalcode.net
   */
  class Double extends Primitive implements Number, Value_Double, Serializable_Php
  {
    // PREDEFINED PROPERTIES
    const TYPE=__CLASS__;
    const TYPE_NATIVE='double';
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
      /**
     * @see \Components\Primitive::native() native
     */
    public static function native()
    {
      return self::TYPE_NATIVE;
    }

    /**
     * @see \Components\Primitive::cast() cast
     *
     * @return float
     */
    public static function cast($value_)
    {
      return (double)$value_;
    }

    /**
     * @see \Components\Primitive::valueOf() valueOf
     *
     * @return \Components\Float
     */
    public static function valueOf($value_)
    {
      return new static((double)$value_);
    }
    //--------------------------------------------------------------------------


    // OVERRIDES
    /**
     * @see \Components\Primitive::value() value
     *
     * @return double
     */
    public function value()
    {
      return $this->m_value;
    }

    /**
     * @see \Components\Number::intValue() intValue
     */
    public function intValue()
    {
      return (int)$this->m_value;
    }

    /**
     * @see \Components\Number::doubleValue() doubleValue
     */
    public function doubleValue()
    {
      return $this->m_value;
    }

    /**
     * @see \Components\Number::floatValue() floatValue
     */
    public function floatValue()
    {
      return $this->m_value;
    }

    /**
     * @see \Components\Comparable::compareTo() compareTo
     */
    public function compareTo($object_)
    {
      if($object_ instanceof static)
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

      throw new Exception_IllegalCast('components/double', sprintf(
        'Can not compare to given parameter [%s].', $object_
      ));
    }

    /**
     * @see \Components\Serializable::serialVersionUid() serialVersionUid
     */
    public function serialVersionUid()
    {
      return 1;
    }

    public function __sleep()
    {
      return ['m_value'];
    }

    public function __wakeup()
    {

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
      return $this->m_value;
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
