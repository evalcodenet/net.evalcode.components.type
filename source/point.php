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
  class Point implements Object, Cloneable, Comparable, Value_String
  {
    // PROPERTIES
    /**
     * @var float
     */
    public $x;
    /**
     * @var float
     */
    public $y;
    //--------------------------------------------------------------------------


    // CONSTRUCTION
    /**
     * @param float $x_
     * @param float $y_
     */
    public function __construct($x_, $y_)
    {
      $this->x=$x_;
      $this->y=$y_;
    }
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * @param float $x_
     * @param float $y_
     *
     * @return \Components\Point
     */
    public static function of($x_, $y_)
    {
      return new static($x_, $y_);
    }

    /**
     * @param string $value_
     *
     * @return \Components\Point
     */
    public static function valueOf($value_)
    {
      $points=json_decode($value_);

      return new static((float)$points[0], (float)$points[1]);
    }
    //--------------------------------------------------------------------------


    // ACCESSORS/MUTATORS
    public function distanceTo(Point $point_)
    {

    }
    //--------------------------------------------------------------------------


    // OVERRIDES/IMPLEMENTS
    /**     * @see Components\Cloneable::__clone() Components\Cloneable::__clone()
     */
    public function __clone()
    {
      return new self($this->x, $this->y);
    }

    /**     * @see Components\Comparable::compareTo() Components\Comparable::compareTo()
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

    /**     * @see Components\Object::hashCode() Components\Object::hashCode()
     */
    public function hashCode()
    {
      return float_hash($this->x, $this->y);
    }

    /**     * @see Components\Object::equals() Components\Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return $this->x===$object_->x && $this->y===$object_->y;

      return false;
    }

    /**     * @see Components\Object::__toString() Components\Object::__toString()
     */
    public function __toString()
    {
      return sprintf('%s@%s{x: %f, y: %f}',
        __CLASS__,
        $this->hashCode(),
        $this->x,
        $this->y
      );
    }

    /**     * @see Components\Value_String::value() Components\Value_String::value()
     */
    public function value()
    {
      return json_encode(array($this->x, $this->y));
    }
    //--------------------------------------------------------------------------
  }
?>
