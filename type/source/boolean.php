<?php


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
   * @since 1.0
   * @access public
   *
   * @author Carsten Schipke <carsten.schipke@evalcode.net>
   * @copyright Copyright (C) 2012 evalcode.net
   * @license GNU General Public License 3
   */
  final class Boolean extends Primitive implements Comparable, Cloneable
  {
    // CONSTANTS
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
     * @param Boolean|boolean $boolean0_
     * @param Boolean|boolean $boolean1_
     *
     * @throws Exception_IllegalArgument
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

      throw new Exception_IllegalArgument('type/boolean', sprintf(
        'Can not compare given parameters [0: %s, 1: %s].',
          $boolean0_, $boolean1_
      ));
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
      if(true===$value_ || false===$value_)
        return $value_;

      if(1===(int)$value_ || 'true'===(string)$value_ || 'true'===trim(strtolower((string)$value_)))
        return true;

      return false;
    }

    /**
     * @see Primitive::valueOf()
     *
     * @return Boolean
     */
    public static function valueOf($value_)
    {
      return new self(self::cast($value_));
    }
    //--------------------------------------------------------------------------


    // ACCESSORS
    public function booleanValue()
    {
      return $this->m_value;
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTS
    /**
     * @see Comparable::compareTo()
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

      try
      {
        $objectAsBoolean=self::cast($object_);
      }
      catch(Exception_IllegalCast $e)
      {
        throw new Exception_IllegalArgument('type/boolean', sprintf(
          'Can not compare to given parameter [%s].', $object_
        ));
      }

      if($this->m_value===$objectAsBoolean)
        return 0;

      if(true===$this->m_value)
        return 1;

      return -1;
    }

    /**
     * @see Object::hashCode()
     */
    public function hashCode()
    {
      return $this->m_value?1231:1237;
    }

    /**
     * @see Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return $this->m_value===$object_->m_value;

      return false;
    }

    /**
     * @see Object::__toString()
     */
    public function __toString()
    {
      if(true===$this->m_value)
        return self::TRUE_AS_STRING;

      return self::FALSE_AS_STRING;
    }

    public function __clone()
    {
      return new self($this->m_value);
    }
    //--------------------------------------------------------------------------
  }
?>
