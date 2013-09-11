<?php


namespace Components;


  /**
   * Double
   *
   * <p>
   *   Boxed implementation for native PHP double.
   * </p>
   *
   * @package net.evalcode.components
   * @subpackage type
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
      /**     * @see Components\Primitive::native() Components\Primitive::native()
     */
    public static function native()
    {
      return self::TYPE_NATIVE;
    }

    /**     * @see Components\Primitive::cast() Components\Primitive::cast()
     *
     * @return float
     */
    public static function cast($value_)
    {
      return (double)$value_;
    }

    /**     * @see Components\Primitive::valueOf() Components\Primitive::valueOf()
     *
     * @return \Components\Float
     */
    public static function valueOf($value_)
    {
      return new static((double)$value_);
    }
    //--------------------------------------------------------------------------


    // OVERRIDES
    /**     * @see Components\Primitive::value() Components\Primitive::value()
     *
     * @return double
     */
    public function value()
    {
      return $this->m_value;
    }

    /**     * @see Components\Number::intValue() Components\Number::intValue()
     */
    public function intValue()
    {
      return (int)$this->m_value;
    }

    /**     * @see Components\Number::doubleValue() Components\Number::doubleValue()
     */
    public function doubleValue()
    {
      return $this->m_value;
    }

    /**     * @see Components\Number::floatValue() Components\Number::floatValue()
     */
    public function floatValue()
    {
      return $this->m_value;
    }

    /**     * @see Components\Comparable::compareTo() Components\Comparable::compareTo()
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

      throw new Exception_IllegalCast('components/type/double', sprintf(
        'Can not compare to given parameter [%s].', $object_
      ));
    }

    /**     * @see Components\Serializable::serialVersionUid() Components\Serializable::serialVersionUid()
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

    /**     * @see Components\Cloneable::__clone() Components\Cloneable::__clone()
     */
    public function __clone()
    {
      return new self($this->m_value);
    }

    /**     * @see Components\Object::hashCode() Components\Object::hashCode()
     */
    public function hashCode()
    {
      return $this->m_value;
    }

    /**     * @see Components\Object::equals() Components\Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return $this->m_value===$object_->m_value;

      return false;
    }

    /**     * @see Components\Object::__toString() Components\Object::__toString()
     */
    public function __toString()
    {
      return (string)$this->m_value;
    }
    //--------------------------------------------------------------------------
  }
?>
