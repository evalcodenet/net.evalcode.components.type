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
  class Color implements Object, Cloneable, Value_String
  {
    // PROPERTIES
    /**
     * @var integer
     */
    public $r;
    /**
     * @var integer
     */
    public $g;
    /**
     * @var integer
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
     * @param string $string_ CSS-like RGB color value / hex value
     *
     * @return Components\Color
     */
    public static function valueOf($string_)
    {
      // TODO Parse rgb(255, 255, 255) / #ffffff
      return new static();
    }

    /**
     * @return Components\Color
     */
    public static function white()
    {
      return new static(255, 255, 255);
    }

    /**
     * @return Components\Color
     */
    public static function black()
    {
      return new static(0, 0, 0);
    }
    //--------------------------------------------------------------------------


    // ACCESSORS
    /**
     * @return string
     */
    public function toHexString()
    {
      return dechex($this->r).dechex($this->g).dechex($this->b);
    }
    //--------------------------------------------------------------------------


    // OVERRIDES
    /**
     * (non-PHPdoc)
     * @see Components.Cloneable::__clone()
     */
    public function __clone()
    {
      return new static($this->r, $this->g, $this->b);
    }

    /**
     * (non-PHPdoc)
     * @see Components.Object::hashCode()
     */
    public function hashCode()
    {
      return integer_hash($this->r, $this->g, $this->b);
    }

    /**
     * (non-PHPdoc)
     * @see Components.Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof static)
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

    public function value()
    {
      return (string)$this;
    }
    //--------------------------------------------------------------------------
  }
?>
