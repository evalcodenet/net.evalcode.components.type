<?php


namespace Components;


  /**
   * Time
   *
   * @api
   * @package net.evalcode.components.type
   *
   * @author evalcode.net
   */
  class Time extends Integer
  {
    // PREDEFINED PROPERTIES
    const TIMEUNIT_SECONDS=1;
    const TIMEUNIT_MINUTES=2;
    const TIMEUNIT_HOURS=3;
    const TIMEUNIT_DAYS=4;
    const TIMEUNIT_WEEKS=5;

    const SECONDS_MINUTE=60;
    const SECONDS_HOUR=3600;
    const SECONDS_DAY=86400;
    const SECONDS_WEEK=604800;
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * @param integer $value_
     *
     * @return \Components\Time
     */
    public static function forUnit($value_, $timeUnit_=self::TIMEUNIT_SECONDS)
    {
      return new static($value_*self::$m_conversionTable[$timeUnit_]);
    }

    /**
     * @param string $value_
     *
     * @return \Components\Time
     */
    public static function parse($value_)
    {
      $date=date_parse($value_);

      $seconds=$date['second'];
      $seconds+=self::SECONDS_MINUTE*$date['minute'];
      $seconds+=self::SECONDS_HOUR*$date['hour'];
      $seconds+=self::SECONDS_DAY*$date['day'];

      return static::forSeconds($seconds);
    }

    /**
     * @param integer $value_
     *
     * @return \Components\Time
     */
    public static function forSeconds($value_)
    {
      return new static($value_);
    }

    /**
     * @param integer $value_
     *
     * @return \Components\Time
     */
    public static function forMinutes($value_)
    {
      return new static($value_*self::SECONDS_MINUTE);
    }

    /**
     * @param integer $value_
     *
     * @return \Components\Time
     */
    public static function forHours($value_)
    {
      return new static($value_*self::SECONDS_HOUR);
    }

    /**
     * @param integer $value_
     *
     * @return \Components\Time
     */
    public static function forDays($value_)
    {
      return new static($value_*self::SECONDS_DAY);
    }

    /**
     * @param integer $value_
     *
     * @return \Components\Time
     */
    public static function forWeeks($value_)
    {
      return new static($value_*self::SECONDS_WEEK);
    }

    /**
     * Expects value in seconds.
     *
     * @param integer $value_
     *
     * @return \Components\Time
     */
    public static function valueOf($value_)
    {
      return new static($value_);
    }
    //--------------------------------------------------------------------------


    // ACCESSORS
    /**
     * Convert to given time unit.
     *
     * @param integer $timeUnit_
     *
     * @return integer
     */
    public function to($timeUnit_=self::TIMEUNIT_SECONDS)
    {
      return $this->m_value/self::$m_conversionTable[$timeUnit_];
    }

    /**
     * @return integer
     */
    public function toSeconds()
    {
      return $this->m_value;
    }

    /**
     * @return integer
     */
    public function toMinutes()
    {
      return $this->m_value/self::SECONDS_MINUTE;
    }

    /**
     * @return integer
     */
    public function toHours()
    {
      return $this->m_value/self::SECONDS_HOUR;
    }

    /**
     * @return integer
     */
    public function toDays()
    {
      return $this->m_value/self::SECONDS_DAY;
    }

    /**
     * @return integer
     */
    public function toWeeks()
    {
      return $this->m_value/self::SECONDS_WEEK;
    }
    //--------------------------------------------------------------------------


    // OVERRIDES
    /**
     * @see \Components\Cloneable::__clone() \Components\Cloneable::__clone()
     */
    public function __clone()
    {
      return new self($this->m_value);
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    protected static $m_conversionTable=[
      self::TIMEUNIT_SECONDS=>1,
      self::TIMEUNIT_MINUTES=>self::SECONDS_MINUTE,
      self::TIMEUNIT_HOURS=>self::SECONDS_HOUR,
      self::TIMEUNIT_DAYS=>self::SECONDS_DAY,
      self::TIMEUNIT_WEEKS=>self::SECONDS_WEEK
    ];
    //--------------------------------------------------------------------------
  }
?>
