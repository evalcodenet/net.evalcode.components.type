<?php


namespace Components;


  /**
   * Bitset
   *
   * @package net.evalcode.components
   * @subpackage type
   *
   * @author evalcode.net
   */
  class Bitset implements Object
  {
    // CONSTANTS
    const TYPE=__CLASS__;
    //--------------------------------------------------------------------------


    // CONSTRUCTION
    private function __construct(array $value_)
    {
      $this->m_value=$value_;
    }
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * @param Bitmask $bitmask_
     *
     * @return Bitset
     */
    public static function forBitmask(Bitmask $bitmask_)
    {
      $bitset=array(); /* TODO Implement self::internalConvertImpl($bitmask_->toBits())*/

      return new self($bitset);
    }
    //--------------------------------------------------------------------------


    // ACCESSORS
    //--------------------------------------------------------------------------


    // IMPLEMENTS
    /**
     * (non-PHPdoc)
     * @see Components.Object::hashCode()
     */
    public function hashCode()
    {
      $hash=1234;

      foreach($this->m_value as $bit=>$set)
      {
        if($set)
          $hash=31*$hash+$bit;
      }

      return $hash;
    }

    /**
     * (non-PHPdoc)
     * @see Components.Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return $this->hashCode()===$object_->hashCode();

      return false;
    }

    /**
     * (non-PHPdoc)
     * @see Components.Object::__toString()
     */
    public function __toString()
    {
      $bits='';
      foreach($this->m_value as $bit=>$set)
        $bits.=$set?'1':'0';

      return sprintf('%s@%s{bitset: %s%s}',
        __CLASS__,
        $this->hashCode(),
        $bits,
        str_repeat('0', 64-count($this->m_value))
      );
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    /**
     * @var int|array
     */
    private $m_value=array();
    //--------------------------------------------------------------------------
  }
?>
