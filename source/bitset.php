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
    // CONSTRUCTION
    private function __construct(array $value_)
    {
      $this->m_value=$value_;
    }
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * @param \Components\Bitmask $bitmask_
     *
     * @return \Components\Bitset
     */
    public static function forBitmask(Bitmask $bitmask_)
    {
      $bitset=array(); /* TODO Implement self::internalConvertImpl($bitmask_->toBits())*/

      return new static($bitset);
    }
    //--------------------------------------------------------------------------


    // OVERRIDES
    /**
     * (non-PHPdoc)
     * @see Components\Object::hashCode()
     */
    public function hashCode()
    {
      return integer_hash($this->m_value);
    }

    /**
     * (non-PHPdoc)
     * @see Components\Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return $this->hashCode()===$object_->hashCode();

      return false;
    }

    /**
     * (non-PHPdoc)
     * @see Components\Object::__toString()
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
     * @var array|int
     */
    private $m_value=array();
    //--------------------------------------------------------------------------
  }
?>