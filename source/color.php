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
  // TODO (CSH) Add alpha ...
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
     * @param string $string_
     *
     * @return \Components\Color
     *
     * @throws \Components\Exception_IllegalArgument
     */
    public static function forHexString($string_)
    {
      // TODO Optimize ...
      $matches=array();
      if(0===preg_match('/^[#]*(?:([a-f0-9]{6})|([a-f0-9]{3}))+$/i', $string_, $matches))
      {
        throw new Exception_IllegalArgument('components/type/color', sprintf(
          'Argument does not match expected format [expected value between: #000000 - #ffffff, given: %s].',
            $string_
        ));
      }

      $values=array();
      if(isset($matches[2]))
      {
        for($i=0; $i<3; $i++)
          $values[]=hexdec($matches[2][$i].$matches[2][$i]);
      }
      else
      {
        foreach(str_split($matches[1], 2) as $chunk)
          $values[]=hexdec($chunk);
      }

      list($r, $g, $b)=$values;

      return new static($r, $g, $b);
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
      // TODO Optimize (currently twice as fast as forHexString, but looks slow as well).
      $matches=array();
      if(0===preg_match('/^[rgb \(]*([\d, ]+)*[\)]*$/i', $string_, $matches))
      {
        throw new Exception_IllegalArgument('components/type/color', sprintf(
          'Argument does not match expected format [given: %s, expected: rgb(255, 255, 255)].',
            $string_
        ));
      }

      $values=array();
      foreach(explode(' ', strtr($matches[1], ',', ' ')) as $value)
      {
        if(is_numeric($value))
          $values[]=min((int)$value, 255);
      }

      list($r, $g, $b)=$values;

      return new static($r, $g, $b);
    }

    /**
     * @param integer $r_
     * @param integer $g_
     * @param integer $b_
     *
     * @return \Components\Color
     */
    public static function forRgb($r_, $g_, $b_)
    {
      return new static($r_, $g_, $b_);
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

      list($r, $g, $b)=self::$m_named[$name_];

      return new static($r, $g, $b);
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

    /**
     * @param string $string_ CSS-like RGB color value / hex value
     *
     * @return \Components\Color
     */
    public static function valueOf($value_)
    {
      return static::forRgbString($value_);
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

    /**
     * @return string
     */
    public function toRgbString()
    {
      return sprintf('rgb(%d, %d, %d)',
        $this->r,
        $this->g,
        $this->b
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
      return new self($this->r, $this->g, $this->b);
    }

    /**
     * @see \Components\Object::hashCode() \Components\Object::hashCode()
     */
    public function hashCode()
    {
      return integer_hash_m($this->r, $this->g, $this->b);
    }

    /**
     * @see \Components\Object::equals() \Components\Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return $this->r===$object_->r && $this->g===$object_->g && $this->b===$object_->b;

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
      self::BLACK=>array(0, 0, 0),
      self::WHITE=>array(255, 255, 255)
    );
    //--------------------------------------------------------------------------
  }
?>
