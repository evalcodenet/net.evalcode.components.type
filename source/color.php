<?php


namespace Components;


  /**
   * Color
   *
   * @api
   * @package net.evalcode.components.type
   *
   * @author evalcode.net
   */
  class Color implements Object, Cloneable, Value_String
  {
    // PREDEFINED PROPERTIES
    const BLACK='black';
    const WHITE='white';
    //--------------------------------------------------------------------------


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
    /**
     * @var integer
     */
    public $a;
    //--------------------------------------------------------------------------


    // CONSTRUCTION
    public function __construct($r_, $g_, $b_, $a_=null)
    {
      $this->r=$r_;
      $this->g=$g_;
      $this->b=$b_;
      $this->a=$a_;
    }
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * Does not support alpha channel, for CSS compatibility.
     *
     * @param string $string_
     *
     * @return \Components\Color
     *
     * @throws \Components\Exception_IllegalArgument
     */
    public static function forHexString($string_)
    {
      $string_=trim(ltrim($string_, '#'));
      $length=strlen($string_);

      if(0!==$length%3)
      {
        throw new Exception_IllegalArgument('components/type/color', sprintf(
          'Unable to parse color for given string [%s].', $string_
        ));
      }

      $channels=str_split($string_, $length/3);
      foreach($channels as $idx=>$channel)
        $channels[$idx]=min(hexdec($channel), 255);

      return new static($channels[0], $channels[1], $channels[2]);
    }

    /**
     * @param string $string_
     *
     * @return \Components\Color
     *
     * @throws \Components\Exception_IllegalArgument
     */
    public static function forRgbString($string_)
    {
      $channels=array();
      $count=preg_match_all('/[\d]+/', $string_, $channels);

      if(4===$count)
        return new static($channels[0], $channels[1], $channels[2], $channels[3]);

      if(3===$count)
        return new static($channels[0], $channels[1], $channels[2]);

      throw new Exception_IllegalArgument('components/type/color', sprintf(
        'Unable to parse color for given string [%s].', $string_
      ));
    }

    /**
     * @param integer $r_
     * @param integer $g_
     * @param integer $b_
     * @param integer $a_
     *
     * @return \Components\Color
     */
    public static function forRgb($r_, $g_, $b_, $a_=null)
    {
      return new static($r_, $g_, $b_, $a_);
    }

    /**
     * @param string $name_
     *
     * @return \Components\Color
     */
    public static function forName($name_)
    {
      if(false===isset(self::$m_named[$name_]))
      {
        throw new Exception_IllegalArgument('components/type/color',
          'Given argument is not a valid color value.'
        );
      }

      list($r, $g, $b, $a)=self::$m_named[$name_];

      return new static($r, $g, $b, $a);
    }

    /**
     * @param string $value_ CSS-like RGB color value / hex value
     *
     * @return \Components\Color
     */
    public static function valueOf($value_)
    {
      return static::forRgbString($value_);
    }

    /**
     * @return \Components\Color
     */
    public static function black()
    {
      return static::forName(self::BLACK);
    }

    /**
     * @return \Components\Color
     */
    public static function white()
    {
      return static::forName(self::WHITE);
    }
    //--------------------------------------------------------------------------


    // ACCESSORS
    /**
     * Does not support alpha channel, for CSS compatibility.
     *
     * @return string
     */
    public function toHexString()
    {
      $r=dechex($this->r);
      $g=dechex($this->g);
      $b=dechex($this->b);

      return str_pad($r, 2, 0, STR_PAD_LEFT)
        .str_pad($g, 2, 0, STR_PAD_LEFT)
        .str_pad($b, 2, 0, STR_PAD_LEFT);
    }

    /**
     * @return string
     */
    public function toRgbString()
    {
      if(null===$this->a)
      {
        return sprintf('rgb(%d, %d, %d)',
          $this->r,
          $this->g,
          $this->b
        );
      }

      return sprintf('rgba(%d, %d, %d, %g)',
        $this->r,
        $this->g,
        $this->b,
        1<$this->a?round(1/255*$this->a, 3, PHP_ROUND_HALF_UP):$this->a
      );
    }
    //--------------------------------------------------------------------------


    // OVERRIDES
    /**
     * @see \Components\Enumeration::value() \Components\Enumeration::value()
     */
    public function value()
    {
      return $this->toRgbString();
    }

    /**
     * @see \Components\Cloneable::__clone() \Components\Cloneable::__clone()
     */
    public function __clone()
    {
      return new self($this->r, $this->g, $this->b, $this->a);
    }

    /**
     * @see \Components\Object::hashCode() \Components\Object::hashCode()
     */
    public function hashCode()
    {
      return integer_hash_m($this->r, $this->g, $this->b, $this->a);
    }

    /**
     * @see \Components\Object::equals() \Components\Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return $this->r===$object_->r && $this->g===$object_->g && $this->b===$object_->b && $this->a===$object_->a;

      return false;
    }

    /**
     * @see \Components\Object::__toString() \Components\Object::__toString()
     */
    public function __toString()
    {
      return $this->toRgbString();
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    private static $m_named=array(
      self::BLACK=>array(0, 0, 0, 255),
      self::WHITE=>array(255, 255, 255, 255)
    );
    //--------------------------------------------------------------------------
  }
?>
