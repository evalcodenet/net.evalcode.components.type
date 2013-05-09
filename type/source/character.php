<?php


namespace Components;


  /**
   * Character
   *
   * <p>
   *   Abstraction and utilities for character handling.
   * </p>
   *
   * @package net.evalcode.components
   * @subpackage type
   *
   * @author evalcode.net
   */
  class Character extends Primitive implements Number
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
     * For performance reasons prefer to use member method {@code compareTo}
     * when comparing instances of {@code Character} and use
     * the static accessor {@code compare} for integers exclusively.
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
     * @see Components.Primitive::native()
     */
    public static function native()
    {
      return self::TYPE_NATIVE;
    }

    /**
     * @see Components.Primitive::cast()
     *
     * @return integer
     */
    public static function cast($value_)
    {
      if(false===String::isTypeCompatible($value_))
      {
        throw new Exception_IllegalCast('components/type/character', sprintf(
          'Can not cast given parameter to %s [%s].', __CLASS__, $value_
        ));
      }

      // FIXME (CSH) Handle character arrays or only respect first character (if multiple given)?
      return ord((string)$value_);
    }

    /**
     * @see Components.Primitive::valueOf()
     *
     * @return Components\Character
     */
    public static function valueOf($value_)
    {
      return new static(static::cast($value_));
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
     * @return Components\Character
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
     * (non-PHPdoc)
     * @see Components.Cloneable::__clone()
     */
    public function __clone()
    {
      return new static($this->m_value);
    }

    /**
     * (non-PHPdoc)
     * @see Components.Comparable::compareTo()
     */
    public function compareTo($object_)
    {
      if($object_ instanceof static)
        return $this->m_value-$object_->m_value;

      return $this->m_value-static::cast($object_);
    }

    /**
     * (non-PHPdoc)
     * @see Components.Object::hashCode()
     */
    public function hashCode()
    {
      return Integer::hash($this->m_value);
    }

    /**
     * (non-PHPdoc)
     * @see Components.Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof static)
        return $this->m_value===$object_->m_value;

      return false;
    }

    /**
     * (non-PHPdoc)
     * @see Components.Object::__toString()
     */
    public function __toString()
    {
      return chr($this->m_value);
    }
    //--------------------------------------------------------------------------
  }
?>
