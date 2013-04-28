<?php


namespace Components;


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
   * @author evalcode.net
   */
  class Float extends Primitive implements Number
  {
    // PREDEFINED PROPERTIES
    const TYPE=__CLASS__;
    const TYPE_NATIVE='float';
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
      /**
     * (non-PHPdoc)
     * @see Components.Primitive::native()
     */
    public static function native()
    {
      return self::TYPE_NATIVE;
    }

    /**
     * (non-PHPdoc)
     * @see Components.Primitive::cast()
     *
     * @return float
     */
    public static function cast($value_)
    {
      return (float)$value_;
    }

    /**
     * (non-PHPdoc)
     * @see Components.Primitive::valueOf()
     *
     * @return \Components\Float
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
      return (int)$this->m_value;
    }

    /**
     * (non-PHPdoc)
     * @see Components.Number::doubleValue()
     */
    public function doubleValue()
    {
      return $this->m_value;
    }

    /**
     * (non-PHPdoc)
     * @see Components.Number::floatValue()
     */
    public function floatValue()
    {
      return $this->m_value;
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

      throw new Exception_IllegalCast('components/type/float', sprintf(
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
     * @return \Components\Float
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
     * @see Components.Object::hashCode()
     */
    public function hashCode()
    {
      return $this->m_value;
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
      return (string)$this->m_value;
    }
    //--------------------------------------------------------------------------
  }
?>
