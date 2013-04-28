<?php


namespace Components;


  /**
   * Integer
   *
   * <p>
   *   Boxed implementation for native PHP integer.
   * </p>
   *
   * @package net.evalcode.components
   * @subpackage type
   *
   * @author evalcode.net
   */
  class Integer extends Primitive implements Number
  {
    // PREDEFINED PROPERTIES
    const TYPE=__CLASS__;
    const TYPE_NATIVE='integer';
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
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
     * @return int
     */
    public static function hash($integer0_/*, $integer1_, $integer2_, ...*/)
    {
      return integer_hash(func_get_args());
    }

    /**
     * (non-PHPdoc)
     * @see Components.Primitive::cast()
     *
     * @return string
     */
    public static function native()
    {
      return self::TYPE_NATIVE;
    }

    /**
     * (non-PHPdoc)
     * @see Components.Primitive::cast()
     *
     * @return int
     */
    public static function cast($value_)
    {
      return (int)$value_;
    }

    /**
     * (non-PHPdoc)
     * @see Components.Primitive::valueOf()
     *
     * @return \Components\Integer
     */
    public static function valueOf($value_)
    {
      return new static(static::cast($value_));
    }
    //--------------------------------------------------------------------------


    // OVERRIDES/IMPLEMENTS
    /**
     * (non-PHPdoc)
     * @see Components.Number::intValue()
     */
    public function intValue()
    {
      return $this->m_value;
    }

    /**
     * (non-PHPdoc)
     * @see Components.Number::doubleValue()
     */
    public function doubleValue()
    {
      return (double)$this->m_value;
    }

    /**
     * (non-PHPdoc)
     * @see Components.Number::floatValue()
     */
    public function floatValue()
    {
      return (float)$this->m_value;
    }

    /**
     * (non-PHPdoc)
     * @see Components.Comparable::compareTo()
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

      throw new Exception_IllegalCast('components/type/integer', sprintf(
        'Can not compare to given parameter [%s].', $object_
      ));
    }

    /**
     * (non-PHPdoc)
     * @see Components.Serializable_Php::serialize()
     */
    public function serialize()
    {
      return serialize($this->m_value);
    }

    /**
     * (non-PHPdoc)
     * @see Components.Serializable_Php::unserialize()
     *
     * @return \Components\Integer
     */
    public function unserialize($data_)
    {
      $this->m_value=unserialize($data_);

      return $this;
    }

    /**
     * (non-PHPdoc)
     * @see Components.Serializable::serialVersionUid()
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
     * @see Components.Cloneable::__clone()
     */
    public function __clone()
    {
      return new static($this->m_value);
    }

    /**
     * @see Components.Object::hashCode()
     */
    public function hashCode()
    {
      return integer_hash($this->m_value);
    }

    /**
     * @see Components.Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof static)
        return $this->m_value===$object_->m_value;

      return false;
    }

    /**
     * @see Components.Object::__toString()
     */
    public function __toString()
    {
      return (string)$this->m_value;
    }
    //--------------------------------------------------------------------------
  }
?>
