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
  final class Integer extends Primitive implements Number
  {
    // CONSTANTS
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
     * @see Primitive::native()
     */
    public static function native()
    {
      return self::TYPE_NATIVE;
    }

    /**
     * @see Primitive::cast()
     */
    public static function cast($value_)
    {
      return (int)$value_;
    }

    /**
     * @see Primitive::valueOf()
     */
    public static function valueOf($value_)
    {
      return new self(self::cast($value_));
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTS
    /**
     * @see Number::intValue()
     */
    public function intValue()
    {
      return $this->m_value;
    }

    /**
     * @see Number::doubleValue()
     */
    public function doubleValue()
    {
      return (double)$this->m_value;
    }

    /**
     * @see Number::floatValue()
     */
    public function floatValue()
    {
      return (float)$this->m_value;
    }

    /**
     * @see Comparable::compareTo()
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

      throw new Exception_IllegalArgument('type/integer', sprintf(
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
      return $this->m_value;
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
