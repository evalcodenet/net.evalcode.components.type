<?php


namespace Components;


  /**
   * Misc_Time
   *
   * @package tncMiscPlugin
   * @subpackage lib
   *
   * @author evalcode.net
   */
  class Misc_Time implements Core_Class_Serializable, Core_Class_Comparable
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
    /*protected*/ function __construct($value_=null, $timeUnit_=null)
    {
      $this->m_value=$value_;
      $this->m_timeUnit=$timeUnit_;
    }
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * @param int $value_
     * @param Misc_Time::TIMEUNIT $timeUnit_
     *
     * @return Misc_Time
     */
    public static function get($value_, $timeUnit_=self::TIMEUNIT_SECONDS)
    {
      return new self($value_, $timeUnit_);
    }

    /**
     * @param int $value_
     *
     * @return Misc_Time
     */
    public static function forSeconds($value_)
    {
      return new self($value_, self::TIMEUNIT_SECONDS);
    }

    /**
     * @param int $value_
     *
     * @return Misc_Time
     */
    public static function forMinutes($value_)
    {
      return new self($value_, self::TIMEUNIT_MINUTES);
    }

    /**
     * @param int $value_
     *
     * @return Misc_Time
     */
    public static function forHours($value_)
    {
      return new self($value_, self::TIMEUNIT_HOURS);
    }

    /**
     * @param int $value_
     *
     * @return Misc_Time
     */
    public static function forDays($value_)
    {
      return new self($value_, self::TIMEUNIT_DAYS);
    }

    /**
     * @param int $value_
     *
     * @return Misc_Time
     */
    public static function forWeeks($value_)
    {
      return new self($value_, self::TIMEUNIT_WEEKS);
    }
    //--------------------------------------------------------------------------


    // ACCESSORS/MUTATORS
    /**
     * Convert to given time unit.
     *
     * @param Misc_Time::TIMEUNIT $timeUnit_
     *
     * @return int
     */
    public function to($timeUnit_=self::TIMEUNIT_SECONDS)
    {
      if($this->m_timeUnit>=$timeUnit_)
        return $this->m_value*self::$m_conversions[$this->m_timeUnit][$timeUnit_];

      return $this->m_value/self::$m_conversions[$this->m_timeUnit][$timeUnit_];
    }

    /**
     * @return int
     */
    public function toSeconds()
    {
      return $this->to(self::TIMEUNIT_SECONDS);
    }

    /**
     * @return int
     */
    public function toMinutes()
    {
      return $this->to(self::TIMEUNIT_MINUTES);
    }

    /**
     * @return int
     */
    public function toHours()
    {
      return $this->to(self::TIMEUNIT_HOURS);
    }

    /**
     * @return int
     */
    public function toDays()
    {
      return $this->to(self::TIMEUNIT_DAYS);
    }

    /**
     * @return int
     */
    public function toWeeks()
    {
      return $this->to(self::TIMEUNIT_WEEKS);
    }
    //--------------------------------------------------------------------------


    // OVERRIDES/IMPLEMENTS
    /**
     * @see Core_Class_Comparable::compareTo()
     */
    public function compareTo(Core_Class_Comparable $object_)
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
     * @see Core_Class::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return $this->toSeconds()==$object_->toSeconds();

      return false;
    }

    /**
     * @see Core_Class::hashCode()
     */
    public function hashCode()
    {
      return spl_object_hash($this);
    }

    /**
     * @see Core_Class_Serializable::serialize()
     */
    public function serialize()
    {
      return (string)$this;
    }

    /**
     * @see Core_Class_Serializable::unserialize()
     */
    public function unserialize($seconds_)
    {
      $this->m_value=(int)$seconds_;
      $this->m_timeUnit=self::TIMEUNIT_SECONDS;

      return $this;
    }

    /**
     * @see Core_Class_Serializable::serialVersionUid()
     */
    public function serialVersionUid()
    {
      return 1;
    }

    public function __toString()
    {
      return (string)$this->toSeconds();
    }

    public function __clone()
    {
      return new self($this->m_value, $this->m_timeUnit);
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    protected static $m_conversions=array(
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
    protected $m_value;
    //--------------------------------------------------------------------------
  }
?>
