<?php


namespace Components;


  /**
   * Misc_Date
   *
   * @package tncMiscPlugin
   * @subpackage lib
   *
   * @author evalcode.net
   */
  class Misc_Date implements Core_Class_Serializable, Core_Class_Comparable
  {
    // PREDEFINED PROPERTIES
    const ANTE_MERIDIEM='am';
    const POST_MERIDIEM='pm';

    const FORMAT_ISO8601='Y-m-d H:i:s';
    const FORMAT_ATOM=self::FORMAT_ISO8601;
    const FORMAT_COOKIE='l, d-M-y H:i:s T';
    const FORMAT_RSS='D, d M Y H:i:s O';
    const FORMAT_UTC='Y-m-d H:i:s \U\T\C';
    const FORMAT_W3C=self::FORMAT_ISO8601;

    const FORMAT_DEFAULT=self::FORMAT_ISO8601;
    //--------------------------------------------------------------------------


    // CONSTRUCTION
    /*protected*/ function __construct(\DateTime $date_=null)
    {
      $this->m_date=$date_;
    }
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * Returns current time for UTC.
     *
     * @param Misc_TimeZone $timezone_
     *
     * @return Misc_Date
     */
    public static function now()
    {
      $date=new \DateTime();
      $date->setTimezone(Misc_TimeZone::utc()->get());

      return new self($date);
    }

    /**
     * Parses given date/time of given timezone and converts to UTC.
     * If no timezone is given, a UTC date is expected.
     *
     * @param string $date_
     * @param string $expectedFormat_
     * @param Misc_TimeZone $timezone_
     *
     * @return Misc_Date
     */
    public static function parse($date_, Misc_TimeZone $timezone_=null, $expectedFormat_=null)
    {
      extract(date_parse($date_));

      if(null===$timezone_ && isset($zone))
        $timezone_=Misc_TimeZone::forOffset($zone/60);

      if(null===$timezone_)
        $timezone_=Misc_TimeZone::utc();

      // TODO Validate input against expected format.

      $date=new \DateTime(
        sprintf('%1$d-%2$d-%3$d %4$d:%5$d:%6$d', $year, $month, $day, $hour, $minute, $second),
        $timezone_->get()
      );

      $date->setTimezone(Misc_TimeZone::utc()->get());

      return new self($date);
    }

    /**
     * Converts given unix timestamp to UTC.
     *
     * Pass optional timezone parameter if given timestamp is of another
     * timezone than the current system's one.
     *
     * @param int $timestamp_
     * @param Misc_TimeZone $timezone_
     *
     * @return Misc_Date
     */
    public static function fromUnixTimestamp($timestamp_, Misc_TimeZone $timezone_=null)
    {
      if(null===$timezone_)
        $timezone_=Misc_TimeZone::forSystemDefault();

      $date=new \DateTime('@'.$timestamp_, $timezone_->get());
      $date->setTimezone(Misc_TimeZone::utc()->get());

      return new self($date);
    }

    /**
     * @param string $date_ ISO-8601 formatted date/time string in UTC.
     *
     * @return Misc_Date
     */
    public static function fromISO8601($date_)
    {
      $utc=Misc_TimeZone::utc()->get();

      $date=new \DateTime($date_, $utc);
      $date->setTimezone($utc);

      return new self($date);
    }
    //--------------------------------------------------------------------------


    // ACCESSORS/MUTATORS
    /**
     * @param string $format_
     * @param Misc_TimeZone $timezone_
     *
     * @return string
     */
    public function format($format_=self::FORMAT_DEFAULT, Misc_TimeZone $timezone_=null)
    {
      $date=clone $this->m_date;

      if(null===$timezone_)
        $timezone_=Misc_TimeZone::forSystemDefault();

      $date->setTimezone($timezone_->get());

      return $date->format($format_);
    }

    /**
     * @return int
     */
    public function toUnixTimestamp(Misc_TimeZone $timezone_=null)
    {
      return (int)$this->format('U', $timezone_);
    }

    /**
     * @return string
     */
    public function toISO8601(Misc_TimeZone $timezone_=null)
    {
      if(null===$timezone_)
        $timezone_=Misc_TimeZone::utc();

      return $this->format(self::FORMAT_ISO8601, $timezone_);
    }

    /**
     * @return string
     */
    public function toLocaleString(Misc_TimeZone $timezone_=null)
    {
      // FIXME Implement I18N based formatting.

      throw new Core_Exception_NotImplemented('misc/date',
        'Converting to local format is not implemented yet.'
      );
    }

    /**
     * @return boolean
     */
    public function isBefore(Misc_Date $date_)
    {
      return $this->toUnixTimestamp()<$date_->toUnixTimestamp();
    }

    /**
     * @return boolean
     */
    public function isAfter(Misc_Date $date_)
    {
      return $this->toUnixTimestamp()>$date_->toUnixTimestamp();
    }

    /**
     * @return int
     */
    public function getDay(Misc_TimeZone $timezone_=null)
    {
      return (int)$this->format('j', $timezone_);
    }

    /**
     * @return int
     */
    public function getDayOfYear(Misc_TimeZone $timezone_=null)
    {
      return (int)$this->format('z', $timezone_);
    }

    /**
     * @return int
     */
    public function getDayOfWeek(Misc_TimeZone $timezone_=null)
    {
      return (int)$this->format('w', $timezone_);
    }

    /**
     * @return int
     */
    public function getWeek(Misc_TimeZone $timezone_=null)
    {
      return (int)$this->format('W', $timezone_);
    }

    /**
     * @return int
     */
    public function getMonth(Misc_TimeZone $timezone_=null)
    {
      return (int)$this->format('n', $timezone_);
    }

    /**
     * @return int
     */
    public function getLengthOfMonth(Misc_TimeZone $timezone_=null)
    {
      return (int)$this->format('t', $timezone_);
    }

    /**
     * @return int
     */
    public function getYear(Misc_TimeZone $timezone_=null)
    {
      return (int)$this->format('Y', $timezone_);
    }

    /**
     * @return string
     */
    public function getShortYear(Misc_TimeZone $timezone_=null)
    {
      return $this->format('y', $timezone_);
    }

    /**
     * @return boolean
     */
    public function isLeapYear(Misc_TimeZone $timezone_=null)
    {
      return 1==(int)$this->format('L', $timezone_);
    }

    /**
     * @return int
     */
    public function getHour(Misc_TimeZone $timezone_=null)
    {
      return (int)$this->format('H', $timezone_);
    }

    /**
     * @return int
     */
    public function getMinute(Misc_TimeZone $timezone_=null)
    {
      return (int)$this->format('i', $timezone_);
    }

    /**
     * @return int
     */
    public function getSecond(Misc_TimeZone $timezone_=null)
    {
      return (int)$this->format('s', $timezone_);
    }

    /**
     * @return int
     */
    public function getMicroSecond(Misc_TimeZone $timezone_=null)
    {
      return (int)$this->format('u', $timezone_);
    }

    /**
     * @return boolean
     */
    public function isMorning(Misc_TimeZone $timezone_=null)
    {
      return self::ANTE_MERIDIEM==$this->format('a', $timezone_);
    }

    /**
     * @return boolean
     */
    public function isAfternoon(Misc_TimeZone $timezone_=null)
    {
      return self::POST_MERIDIEM==$this->format('a', $timezone_);
    }

    /**
    * @return boolean
     */
    public function isSummerTime(Misc_TimeZone $timezone_=null)
    {
      return 1==$this->format('I', $timezone_);
    }

    /**
     * @return Misc_Date
     */
    public function nextDay()
    {
      return $this->afterDays(1);
    }

    /**
     * @return Misc_Date
     */
    public function prevDay()
    {
      return $this->beforeDays(1);
    }

    /**
     * @return Misc_Date
     */
    public function nextMonth()
    {
      return $this->afterMonths(1);
    }

    /**
     * @return Misc_Date
     */
    public function prevMonth()
    {
      return $this->beforeMonths(1);
    }

    /**
     * @return Misc_Date
     */
    public function nextYear()
    {
      return $this->afterYears(1);
    }

    /**
     * @return Misc_Date
     */
    public function prevYear()
    {
      return $this->beforeYears(1);
    }

    /**
     * @param Misc_Time $time_
     *
     * @return Misc_Date
     */
    public function after(Misc_Time $time_)
    {
      return $this->modified('+'.$time_->toSeconds().' second');
    }

    /**
     * @param Misc_Time $time_
     *
     * @return Misc_Date
     */
    public function before(Misc_Time $time_)
    {
      return $this->modified('-'.$time_->toSeconds().' second');
    }

    /**
     * Returns time between this and any given date.
     *
     * @param Misc_Date $date_
     *
     * @return Misc_Time
     */
    public function during(Misc_Date $date_)
    {
      $interval=$this->m_date->diff($date_->m_date);

      $seconds=0;
      $seconds+=$interval->days*Misc_Time::SECONDS_DAY;
      $seconds+=$interval->h*Misc_Time::SECONDS_HOUR;
      $seconds+=$interval->i*Misc_Time::SECONDS_MINUTE;
      $seconds+=$interval->s;

      return Misc_Time::forSeconds($seconds);
    }

    /**
     * @param int $days_
     *
     * @return Misc_Date
     */
    public function afterDays($days_)
    {
      return $this->modified('+'.$days_.' day');
    }

    /**
     * @param int $days_
     *
     * @return Misc_Date
     */
    public function beforeDays($days_)
    {
      return $this->modified('-'.$days_.' day');
    }

    /**
     * @param int $months_
     *
     * @return Misc_Date
     */
    public function afterMonths($months_)
    {
      return $this->modified('+'.$months_.' month');
    }

    /**
     * @param int $months_
     *
     * @return Misc_Date
     */
    public function beforeMonths($months_)
    {
      return $this->modified('-'.$months_.' month');
    }

    /**
     * @param int $years_
     *
     * @return Misc_Date
     */
    public function afterYears($years_)
    {
      return $this->modified('+'.$years_.' year');
    }

    /**
     * @param int $years_
     *
     * @return Misc_Date
     */
    public function beforeYears($years_)
    {
      return $this->modified('-'.$years_.' year');
    }

    /**
     * @return Misc_Date
     */
    public function beginningOfDay()
    {
      $utc=Misc_TimeZone::utc();

      $date=new \DateTime($this->format('Y-m-dT00:00:00+0000', $utc), $utc->get());
      $date->setTimezone($utc->get());

      return new self($date);
    }

    /**
     * @return Misc_Date
     */
    public function endOfDay()
    {
      return $this->beginningOfDay()->after(
        Misc_Time::get(Misc_Time::SECONDS_DAY-1, Misc_Time::TIMEUNIT_SECONDS)
      );
    }

    /**
     * @return Misc_Date
     */
    public function beginningOfMonth()
    {
      $utc=Misc_TimeZone::utc();

      $date=new \DateTime($this->format('Y-m-01T00:00:00+0000', $utc), $utc->get());
      $date->setTimezone($utc->get());

      return new self($date);
    }

    /**
     * @return Misc_Date
     */
    public function beginningOfYear()
    {
      $utc=Misc_TimeZone::utc();

      $date=new \DateTime($this->format('Y-01-01T00:00:00+0000', $utc), $utc->get());
      $date->setTimezone($utc->get());

      return new self($date);
    }

    /**
     * @return Misc_Date
     */
    public function endOfMonth()
    {
      return $this->nextMonth()->beginningOfMonth()->prevDay();
    }

    /**
     * @return Misc_Date
     */
    public function endOfYear()
    {
      return $this->nextYear()->beginningOfYear()->prevDay();
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTS
    /**
     * @see Core_Class_Comparable::compareTo()
     */
    public function compareTo(Core_Class_Comparable $object_)
    {
      if($object_ instanceof self)
      {
        $timestampSelf=$this->toUnixTimestamp();
        $timestampObject=$object_->toUnixTimestamp();

        if($timestampSelf==$timestampObject)
          return 0;

        if($timestampSelf>$timestampObject)
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
        return $this->toUnixTimestamp()==$object_->toUnixTimestamp();

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
      return $this->toISO8601();
    }

    /**
     * @see Core_Class_Serializable::unserialize()
     */
    public function unserialize($string_)
    {
      $this->m_asString=$string_;
      $this->__wakeup();

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
      return $this->format(self::FORMAT_UTC, Misc_TimeZone::utc());
    }

    public function __clone()
    {
      return self::fromISO8601($this->toISO8601());
    }

    public function __sleep()
    {
      $this->m_asString=$this->toISO8601();

      return array('m_asString');
    }

    public function __wakeup()
    {
      $utc=Misc_TimeZone::utc()->get();

      $this->m_date=new \DateTime($this->m_asString, $utc);
      $this->m_date->setTimezone($utc);
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    /**
     * @var string
     */
    protected $m_asString;
    /**
     * @var \DateTime
     */
    protected $m_date;
    //-----


    /**
     * Returns modified clone.
     *
     * @param string $modification_
     *
     * @return Misc_Date
     */
    protected function modified($modification_=null)
    {
      // FIXME clone does not seem to work...
      $instance=self::fromISO8601($this->toISO8601());

      if(null!==$modification_)
        $instance->m_date->modify($modification_);

      return $instance;
    }
    //--------------------------------------------------------------------------
  }
?>
