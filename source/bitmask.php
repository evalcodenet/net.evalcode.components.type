<?php


namespace Components;


  /**
   * Bitmask
   *
   * @api
   * @package net.evalcode.components.type
   *
   * @author evalcode.net
   */
  class Bitmask extends Integer
  {
    // CONSTRUCTION
    public function __construct($value_)
    {
      $this->m_value=$value_;
    }
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * Returns instance for given bitmask.
     *
     * @param integer $bitmask_
     *
     * @return \Components\Bitmask
     */
    public static function forBitmask($bitmask_)
    {
      return new static($bitmask_);
    }

    /**
     * Returns instance for given bits.
     *
     * @param array $bits_
     *
     * @return \Components\Bitmask
     */
    public static function forBits(array $bits_)
    {
      return new static(self::getBitmaskForBits($bits_));
    }

    /**
     * Returns instance for given bitset.
     *
     * @param \Components\Bitset $bitset_
     *
     * @return \Components\Bitmask
     */
    public static function forBitset(Bitset $bitset_)
    {
      // TODO Implement
    }

    /**
     * @return \Components\Bitmask
     */
    public static function createEmpty()
    {
      return new static(0);
    }

    /**
     * Returns bits for given bitmask.
     *
     * @param integer $bitmask_
     *
     * @return integer|array
     */
    public static function getBitsForBitmask($bitmask_)
    {
      $bitset=[];

      $bit=PHP_INT_MAX;
      while(1<$bit)
      {
        if(-1<($bitmask_-$bit))
        {
          $bitmask_-=$bit;
          $bitset[]=$bit;
        }

        $bit/=2;
      }

      return $bitset;
    }

    /**
     * Returns bitmask for given bits.
     *
     * @param integer|array $bits_
     *
     * @return integer
     */
    public static function getBitmaskForBits(array $bits_)
    {
      $bitmask=0;
      foreach($bits_ as $bit)
        $bitmask+=$bit;

      return $bitmask;
    }

    /**
     * Adds given bit to given bitmask.
     *
     * @param integer $bitmask_
     * @param integer $bit_
     *
     * @return integer
     */
    public static function addBitToBitmask($bitmask_, $bit_)
    {
      return $bitmask_|$bit_;
    }

    /**
     * Remove given bit from given bitmask.
     *
     * @param integer $bitmask_
     * @param integer $bit_
     *
     * @return integer
     */
    public static function removeBitFromBitmask($bitmask_, $bit_)
    {
      return $bitmask_-($bitmask_&$bit_);
    }

    /**
     * Checks if given bitmask contains given bit.
     *
     * @param integer $bitmask_
     * @param integer $bit_
     *
     * @return boolean
     */
    public static function hasBitForBitmask($bitmask_, $bit_)
    {
      return 0<($bitmask_&$bit_);
    }
    //--------------------------------------------------------------------------


    // ACCESSORS
    /**
     * Checks if given bit is set.
     *
     * @param integer $bit_
     *
     * @return boolean
     */
    public function has($bit_)
    {
      return 0<($this->m_value&$bit_);
    }

    /**
     * Adds given bit.
     *
     * @param integer $bit_
     *
     * @return \Components\Bitmask
     */
    public function add($bit_)
    {
      $this->m_value|=$bit_;

      return $this;
    }

    /**
     * Removes given bit.
     *
     * @param integer $bit_
     *
     * @return \Components\Bitmask
     */
    public function remove($bit_)
    {
      $this->m_value-=$this->m_value&$bit_;

      return $this;
    }

    /**
     * @return integer
     */
    public function toBitmask()
    {
      return $this->m_value;
    }

    /**
     * @return integer|array
     */
    public function toBits()
    {
      return self::getBitsForBitmask($this->m_value);
    }

    /**
     * @return \Components\Bitset
     */
    public function toBitset()
    {
      return Bitset::forBitmask($this->m_value);
    }
    //--------------------------------------------------------------------------


    // OVERRIDES
    /**
     * @see Components\Number::intValue() Components\Number::intValue()
     */
    public function intValue()
    {
      return (int)$this->m_value;
    }

    /**
     * @see Components\Number::doubleValue() Components\Number::doubleValue()
     */
    public function doubleValue()
    {
      return (double)$this->m_value;
    }

    /**
     * @see Components\Number::floatValue() Components\Number::floatValue()
     */
    public function floatValue()
    {
      return (float)$this->m_value;
    }

    /**
     * @see Components\Comparable::compareTo() Components\Comparable::compareTo()
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

      throw new Exception_IllegalCast('components/type/bitmask', sprintf(
        'Can not compare to given parameter [%s].', $object_
      ));
    }

    /**
     * @see Components\Serializable::serialVersionUid() Components\Serializable::serialVersionUid()
     */
    public function serialVersionUid()
    {
      return 1;
    }

    /**
     * @see Components\Cloneable::__clone() Components\Cloneable::__clone()
     */
    public function __clone()
    {
      return new self($this->m_value);
    }

    /**
     * @see Components\Object::hashCode() Components\Object::hashCode()
     */
    public function hashCode()
    {
      return string_hash($this->m_value);
    }

    /**
     * @see Components\Object::equals() Components\Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return $this->m_value===$object_->m_value;

      return false;
    }

    /**
     * @see Components\Object::__toString() Components\Object::__toString()
     */
    public function __toString()
    {
      return (string)$this->m_value;
    }
    //--------------------------------------------------------------------------
  }
?>
