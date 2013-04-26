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
  final class Character extends Primitive implements Number
  {
    // CONSTANTS
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
      if($character0_ instanceof self)
        $a->$character0_->m_value;
      else if(is_integer($character0_))
        $a=$character0_;

      if($character1_ instanceof self)
        $b->$character1_->m_value;
      else if(is_integer($character1_))
        $b=$character1_;

      try
      {
        if(null===$a)
          $a=self::cast($character0_);
        if(null===$b)
          $b=self::cast($character1_);
      }
      catch(Exception_IllegalCast $e)
      {
        throw new Exception_IllegalArgument('type/character', sprintf(
          'Can not compare given parameters [0: %s, 1: %s].',
            $character0_, $character1_
        ));
      }

      return $a-$b;
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
      if(false===Types::canBeString($value_))
      {
        throw new Exception_IllegalCast('type/character', sprintf(
          'Can not cast given parameter to %s [%s].', __CLASS__, $value_
        ));
      }

      // TODO Handle character arrays or only respect first character (if multiple given)?
      if(Types::isString($value_))
        return ord($value_);

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
     * @return int
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
     * @return \Components\Character
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
      return new self($this->m_value);
    }

    /**
     * (non-PHPdoc)
     * @see Components.Comparable::compareTo()
     */
    public function compareTo($object_)
    {
      if($object_ instanceof self)
        return $this->m_value-$object_->m_value;

      try
      {
        return $this->m_value-self::cast($object_);
      }
      catch(Exception_IllegalCast $e)
      {
        throw new Exception_IllegalArgument('type/character', sprintf(
          'Can not compare to given parameter [%s].', $object_
        ));
      }
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
      if($object_ instanceof self)
        return $this->m_value===$object_->m_value;

      return false;
    }

    /**
     * @see Components.Object::__toString()
     */
    public function __toString()
    {
      return chr($this->m_value);
    }
    //--------------------------------------------------------------------------
  }
?>
