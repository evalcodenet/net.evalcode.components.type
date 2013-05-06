<?php


namespace Components;


  /**
   * Point
   *
   * @package net.evalcode.components
   * @subpackage type
   *
   * @author evalcode.net
   */
  class Point implements Object, Cloneable, Comparable
  {
    // PROPERTIES
    /**
     * @var integer
     */
    public $x;
    /**
     * @var integer
     */
    public $y;
    //--------------------------------------------------------------------------


    // CONSTRUCTION
    /**
     * @param integer $x_
     * @param integer $y_
     */
    public function __construct($x_, $y_)
    {
      $this->x=$x_;
      $this->y=$y_;
    }
    //--------------------------------------------------------------------------


    // OVERRIDES
    /**
     * (non-PHPdoc)
     * @see Components.Cloneable::__clone()
     */
    public function __clone()
    {
      return new self($this->x, $this->y);
    }

    /**
     * (non-PHPdoc)
     * @see Components.Comparable::compareTo()
     */
    public function compareTo($object_)
    {
      if($object_ instanceof self)
      {
        $a=$this->x+$this->y;
        $b=$object_->x+$object_->y;

        if($a===$b)
          return 0;

        return $a<$b?-1:1;
      }

      return false;
    }

    /**
     * (non-PHPdoc)
     * @see Components.Object::hashCode()
     */
    public function hashCode()
    {
      return integer_hash($this->x, $this->y);
    }

    /**
     * (non-PHPdoc)
     * @see Components.Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return $this->x===$object_->x && $this->y===$object_->y;

      return false;
    }

    /**
     * (non-PHPdoc)
     * @see Components.Object::__toString()
     */
    public function __toString()
    {
      return sprintf('%1$s@%2$s{x: %3$d, y: %4$d}',
        __CLASS__,
        $this->hashCode(),
        $this->x,
        $this->y
      );
    }
    //--------------------------------------------------------------------------
  }
?>
