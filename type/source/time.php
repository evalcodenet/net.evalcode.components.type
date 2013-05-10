<?php


namespace Components;


  /**
   * Time
   *
   * @package net.evalcode.components
   * @subpackage type
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

    const MINUTES_HOUR=60;
    const MINUTES_DAY=1440;
    const MINUTES_WEEK=10080;

    const HOURS_DAY=24;
    const HOURS_WEEK=168;

    const DAYS_WEEK=7;
    //--------------------------------------------------------------------------


    // CONSTRUCTION
    public function __construct($value_=null, $timeUnit_=null)
    {
      parent::__construct($value_);

      $this->m_timeUnit=$timeUnit_;
    }
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * @param integer $value_
     * @param integer $timeUnit_
     *
     * @return Components\Time
     */
    public static function get($value_, $timeUnit_=self::TIMEUNIT_SECONDS)
    {
      return new static($value_, $timeUnit_);
    }

    /**
     * @param integer $value_
     *
     * @return Components\Time
     */
    public static function forSeconds($value_)
    {
      return new static($value_, self::TIMEUNIT_SECONDS);
    }

    /**
     * @param integer $value_
     *
     * @return Components\Time
     */
    public static function forMinutes($value_)
    {
      return new static($value_, self::TIMEUNIT_MINUTES);
    }

    /**
     * @param integer $value_
     *
     * @return Components\Time
     */
    public static function forHours($value_)
    {
      return new static($value_, self::TIMEUNIT_HOURS);
    }

    /**
     * @param integer $value_
     *
     * @return Components\Time
     */
    public static function forDays($value_)
    {
      return new static($value_, self::TIMEUNIT_DAYS);
    }

    /**
     * @param integer $value_
     *
     * @return Components\Time
     */
    public static function forWeeks($value_)
    {
      return new static($value_, self::TIMEUNIT_WEEKS);
    }

    /**
     * @param integer $value_
     *
     * @return Components\Time
     */
    public static function valueOf($value_)
    {
      return new static($value_, self::TIMEUNIT_SECONDS);
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
      if($this->m_timeUnit>=$timeUnit_)
        return $this->m_value*self::$m_conversionTable[$this->m_timeUnit][$timeUnit_];

      return $this->m_value/self::$m_conversionTable[$this->m_timeUnit][$timeUnit_];
    }

    /**
     * @return integer
     */
    public function toSeconds()
    {
      return $this->to(self::TIMEUNIT_SECONDS);
    }

    /**
     * @return integer
     */
    public function toMinutes()
    {
      return $this->to(self::TIMEUNIT_MINUTES);
    }

    /**
     * @return integer
     */
    public function toHours()
    {
      return $this->to(self::TIMEUNIT_HOURS);
    }

    /**
     * @return integer
     */
    public function toDays()
    {
      return $this->to(self::TIMEUNIT_DAYS);
    }

    /**
     * @return integer
     */
    public function toWeeks()
    {
      return $this->to(self::TIMEUNIT_WEEKS);
    }
    //--------------------------------------------------------------------------


    // OVERRIDES
    /**
     * (non-PHPdoc)
     * @see Components.Number::intValue()
     */
    public function intValue()
    {
      return $this->toSeconds();
    }

    /**
     * (non-PHPdoc)
     * @see Components.Number::doubleValue()
     */
    public function doubleValue()
    {
      return (double)$this->toSeconds();
    }

    /**
     * (non-PHPdoc)
     * @see Components.Number::floatValue()
     */
    public function floatValue()
    {
      return (float)$this->toSeconds();
    }

    /**
     * (non-PHPdoc)
     * @see Components.Comparable::compareTo()
     */
    public function compareTo($object_)
    {
      if($object_ instanceof self)
      {
        if($this->toSeconds()==$object_->toSeconds())
          return 0;

        if($this->toSeconds()>$object_->toSeconds())
          return 1;
      }

      return -1;
    }

    /**
     * (non-PHPdoc)
     * @see Components.Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return $this->toSeconds()===$object_->toSeconds();

      return false;
    }

    /**
     * (non-PHPdoc)
     * @see Components.Object::hashCode()
     */
    public function hashCode()
    {
      return integer_hash($this->toSeconds());
    }

    /**
     * (non-PHPdoc)
     * @see Components.Serializable_Php::serialize()
     */
    public function serialize()
    {
      return serialize($this->toSeconds());
    }

    /**
     * (non-PHPdoc)
     * @see Components.Serializable_Php::unserialize()
     *
     * @return Components\Time
     */
    public function unserialize($data_)
    {
      $this->m_value=unserialize($data_);
      $this->m_timeUnit=self::TIMEUNIT_SECONDS;

      return $this;
    }

    /**
     * (non-PHPdoc)
     * @see Components.Serializable::serialVersionUid()
     */
    public function serialVersionUid()
    {
      return 1;
    }

    /**
     * (non-PHPdoc)
     * @see Components.Object::__toString()
     */
    public function __toString()
    {
      return (string)$this->toSeconds();
    }

    /**
     * (non-PHPdoc)
     * @see Components.Cloneable::__clone()
     */
    public function __clone()
    {
      return new static($this->m_value, $this->m_timeUnit);
    }

    /**
     * (non-PHPdoc)
     * @see Components.Value_Integer::value()
     */
    public function value()
    {
      return $this->to(self::TIMEUNIT_SECONDS);
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    protected static $m_conversionTable=array(
      self::TIMEUNIT_SECONDS=>array(
        self::TIMEUNIT_SECONDS=>1,
        self::TIMEUNIT_MINUTES=>self::SECONDS_MINUTE,
        self::TIMEUNIT_HOURS=>self::SECONDS_HOUR,
        self::TIMEUNIT_DAYS=>self::SECONDS_DAY,
        self::TIMEUNIT_WEEKS=>self::SECONDS_WEEK
      ),
      self::TIMEUNIT_MINUTES=>array(
        self::TIMEUNIT_SECONDS=>self::SECONDS_MINUTE,
        self::TIMEUNIT_MINUTES=>1,
        self::TIMEUNIT_HOURS=>self::MINUTES_HOUR,
        self::TIMEUNIT_DAYS=>self::MINUTES_DAY,
        self::TIMEUNIT_WEEKS=>self::MINUTES_WEEK
      ),
      self::TIMEUNIT_HOURS=>array(
        self::TIMEUNIT_SECONDS=>self::SECONDS_HOUR,
        self::TIMEUNIT_MINUTES=>self::MINUTES_HOUR,
        self::TIMEUNIT_HOURS=>1,
        self::TIMEUNIT_DAYS=>self::HOURS_DAY,
        self::TIMEUNIT_WEEKS=>self::HOURS_WEEK
      ),
      self::TIMEUNIT_DAYS=>array(
        self::TIMEUNIT_SECONDS=>self::SECONDS_DAY,
        self::TIMEUNIT_MINUTES=>self::MINUTES_DAY,
        self::TIMEUNIT_HOURS=>self::HOURS_DAY,
        self::TIMEUNIT_DAYS=>1,
        self::TIMEUNIT_WEEKS=>self::DAYS_WEEK
      ),
      self::TIMEUNIT_WEEKS=>array(
        self::TIMEUNIT_SECONDS=>self::SECONDS_WEEK,
        self::TIMEUNIT_MINUTES=>self::MINUTES_WEEK,
        self::TIMEUNIT_HOURS=>self::HOURS_WEEK,
        self::TIMEUNIT_DAYS=>self::DAYS_WEEK,
        self::TIMEUNIT_WEEKS=>1
      )
    );

    protected $m_timeUnit;
    //--------------------------------------------------------------------------
  }
?>
