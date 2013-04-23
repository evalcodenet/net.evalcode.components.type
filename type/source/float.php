<?php


  /**
   * Float
   *
   * <p>
   *   Boxed implementation for native PHP float.
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
  final class Float extends Primitive implements Number
  {
    // CONSTANTS
    const TYPE=__CLASS__;
    const TYPE_NATIVE='float';
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
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
      return (float)$value_;
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
      return (int)$this->m_value;
    }

    /**
     * @see Number::doubleValue()
     */
    public function doubleValue()
    {
      return $this->m_value;
    }

    /**
     * @see Number::floatValue()
     */
    public function floatValue()
    {
      return $this->m_value;
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

      throw new Exception_IllegalArgument('type/float', sprintf(
        'Can not compare to given parameter [%s].', $object_
      ));
    }

    /**
     * @see Serializable::serialize()
     */
    public function serialize()
    {
      return serialize($this->m_value);
    }

    /**
     * @see Serializable::unserialize()
     */
    public function unserialize($serialized_)
    {
      $this->m_value=unserialize($serialized_);
    }

    public function __sleep()
    {
      return array('m_value');
    }

    public function __wakeup()
    {

    }

    /**
     * @see Cloneable::__clone()
     */
    public function __clone()
    {
      return new static($this->m_value);
    }

    /**
     * @see Object::hashCode()
     */
    public function hashCode()
    {
      return $this->m_value;
    }

    /**
     * @see Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof static)
        return $this->m_value===$object_->m_value;

      return false;
    }

    /**
     * @see Object::__toString()
     */
    public function __toString()
    {
      return (string)$this->m_value;
    }
    //--------------------------------------------------------------------------
  }
?>
