<?php


namespace Components;


  /**
   * Bitmask
   *
   * @package net.evalcode.components
   * @subpackage type
   *
   * @author evalcode.net
   */
  class Bitmask implements Number
  {
    // CONSTANTS
    const TYPE=__CLASS__;
    //--------------------------------------------------------------------------


    // CONSTRUCTION
    private function __construct($value_)
    {
      $this->m_value=$value_;
    }
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * Returns instance for given bitmask.
     *
     * @param int $bitmask_
     *
     * @return Bitmask
     */
    public static function forBitmask($bitmask_)
    {
      return new self($bitmask_);
    }

    /**
     * Returns instance for given bits.
     *
     * @param array $bits_
     *
     * @return Bitmask
     */
    public static function forBits(array $bits_)
    {
      return new self(self::getBitmaskForBits($bits_));
    }

    /**
     * Returns instance for given bitset.
     *
     * @param Bitset $bitset_
     *
     * @return Bitmask
     */
    public static function forBitset(Bitset $bitset_)
    {
      // TODO Implement
    }

    /**
     * @return Bitmask
     */
    public static function createEmpty()
    {
      return new self(0);
    }

    /**
     * Returns bits for given bitmask.
     *
     * @param int $bitmask_
     *
     * @return int|array
     */
    public static function getBitsForBitmask($bitmask_)
    {
      $bitset=array();

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
     * @param int|array $bits_
     *
     * @return int
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
     * @param int $bitmask_
     * @param int $bit_
     *
     * @return int
     */
    public static function addBitToBitmask($bitmask_, $bit_)
    {
      return $bitmask_|$bit_;
    }

    /**
     * Remove given bit from given bitmask.
     *
     * @param int $bitmask_
     * @param int $bit_
     *
     * @return int
     */
    public static function removeBitFromBitmask($bitmask_, $bit_)
    {
      return $bitmask_-($bitmask_&$bit_);
    }

    /**
     * Checks if given bitmask contains given bit.
     *
     * @param int $bitmask_
     * @param int $bit_
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
     * @param int $bit_
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
     * @param int $bit_
     *
     * @return Bitmask
     */
    public function add($bit_)
    {
      $this->m_value|=$bit_;

      return $this;
    }

    /**
     * Removes given bit.
     *
     * @param int $bit_
     *
     * @return Bitset
     */
    public function remove($bit_)
    {
      $this->m_value-=$this->m_value&$bit_;

      return $this;
    }

    /**
     * @return int
     */
    public function toBitmask()
    {
      return $this->m_value;
    }

    /**
     * @return int|array
     */
    public function toBits()
    {
      return self::getBitsForBitmask($this->m_value);
    }

    /**
     * @return Bitset
     */
    public function toBitset()
    {
      // TODO Implement
    }
    //--------------------------------------------------------------------------


    // OVERRIDES
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

      throw new Exception_IllegalArgument('components/type/bitmask', sprintf(
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
      return String::hash($this->m_value);
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


    // IMPLEMENTATION
    /**
     * @var int
     */
    private $m_value;
    //--------------------------------------------------------------------------
  }
?>
