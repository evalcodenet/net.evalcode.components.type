<?php


namespace Components;


  /**
   * Color
   *
   * @package net.evalcode.components
   * @subpackage type
   *
   * @author evalcode.net
   */
  class Color implements Object, Cloneable
  {
    // PROPERTIES
    /**
     * @var int
     */
    public $r;
    /**
     * @var int
     */
    public $g;
    /**
     * @var int
     */
    public $b;
    //--------------------------------------------------------------------------


    // CONSTRUCTION
    public function __construct($r_, $g_, $b_)
    {
      $this->r=$r_;
      $this->g=$g_;
      $this->b=$b_;
    }
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * @return Color
     */
    public static function valueOf($string_)
    {
      // TODO Implement
    }

    /**
     * @return Color
     */
    public static function white()
    {
      return new self(255, 255, 255);
    }

    /**
     * @return Color
     */
    public static function black()
    {
      return new self(0, 0, 0);
    }
    //--------------------------------------------------------------------------


    // ACCESSORS/MUTATORS
    public function toHexString()
    {
      return dechex($this->r).dechex($this->g).dechex($this->b);
    }
    //--------------------------------------------------------------------------


    // OVERRIDES/IMPLEMENTS
    /**
     * (non-PHPdoc)
     * @see Cloneable::__clone()
     */
    public function __clone()
    {
      return new self($this->r, $this->g, $this->b);
    }

    /**
     * (non-PHPdoc)
     * @see Components.Object::hashCode()
     */
    public function hashCode()
    {
      $hash=31*$this->r+$this->g;
      $hash+=31*$hash+$this->b;

      return $hash;
    }

    /**
     * (non-PHPdoc)
     * @see Components.Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
      {
        return (int)$this->r===(int)$object_->r
          && (int)$this->g===(int)$object_->g
          && (int)$this->b===(int)$object_->b;
      }

      return false;
    }

    /**
     * (non-PHPdoc)
     * @see Components.Object::__toString()
     */
    public function __toString()
    {
      return sprintf('rgb(%d, %d, %d)',
        $this->r,
        $this->g,
        $this->b
      );
    }
    //--------------------------------------------------------------------------
  }
?>
