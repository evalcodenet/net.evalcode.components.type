<?php


namespace Components;


  /**
   * Date
   *
   * @package net.evalcode.components
   * @subpackage type
   *
   * @author evalcode.net
   */
  class Date implements Object, Cloneable, Comparable,
    Serializable_Php, Serializable_Json
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
    public function __construct(\DateTime $date_=null)
    {
      $this->m_date=$date_;
    }
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * Returns current time for UTC.
     *
     * @param \Components\TimeZone $timezone_
     *
     * @return \Components\Date
     */
    public static function now()
    {
      $date=new \DateTime();
      $date->setTimezone(TimeZone::utc()->get());

      return new self($date);
    }

    /**
     * Parses given date/time of given timezone and converts to UTC.
     * If no timezone is given, a UTC date is expected.
     *
     * @param string $date_
     * @param string $expectedFormat_
     * @param \Components\TimeZone $timezone_
     *
     * @return \Components\Date
     */
    public static function parse($date_, TimeZone $timezone_=null, $expectedFormat_=null)
    {
      extract(date_parse($date_));

      if(null===$timezone_ && isset($zone))
        $timezone_=TimeZone::forOffset($zone/60);

      if(null===$timezone_)
        $timezone_=TimeZone::utc();

      // TODO Validate input against expected format.

      $date=new \DateTime(
        sprintf('%1$d-%2$d-%3$d %4$d:%5$d:%6$d', $year, $month, $day, $hour, $minute, $second),
        $timezone_->get()
      );

      $date->setTimezone(TimeZone::utc()->get());

      return new self($date);
    }

    /**
     * Converts given unix timestamp to UTC.
     *
     * Pass optional timezone parameter if given timestamp is of another
     * timezone than the current system's one.
     *
     * @param int $timestamp_
     * @param \Components\TimeZone $timezone_
     *
     * @return \Components\Date
     */
    public static function fromUnixTimestamp($timestamp_, TimeZone $timezone_=null)
    {
      if(null===$timezone_)
        $timezone_=TimeZone::forSystemDefault();

      $date=new \DateTime('@'.$timestamp_, $timezone_->get());
      $date->setTimezone(TimeZone::utc()->get());

      return new self($date);
    }

    /**
     * @param string $date_ ISO-8601 formatted date/time string in UTC.
     *
     * @return \Components\Date
     */
    public static function fromISO8601($date_)
    {
      $utc=TimeZone::utc()->get();

      $date=new \DateTime($date_, $utc);
      $date->setTimezone($utc);

      return new self($date);
    }
    //--------------------------------------------------------------------------


    // ACCESSORS/MUTATORS
    /**
     * @param string $format_
     * @param \Components\TimeZone $timezone_
     *
     * @return string
     */
    public function format($format_=self::FORMAT_DEFAULT, TimeZone $timezone_=null)
    {
      $date=clone $this->m_date;

      if(null===$timezone_)
        $timezone_=TimeZone::forSystemDefault();

      $date->setTimezone($timezone_->get());

      return $date->format($format_);
    }

    /**
     * @param string $format_
     * @param \Components\TimeZone $timezone_
     *
     * @return string
     */
    public function formatLocalized($format_='common/date/pattern/full', TimeZone $timezone_=null)
    {
      return $this->format(translate($format_), $timezone_);
    }

    /**
     * @return int
     */
    public function toUnixTimestamp(TimeZone $timezone_=null)
    {
      return (int)$this->format('U', $timezone_);
    }

    /**
     * @return string
     */
    public function toISO8601(TimeZone $timezone_=null)
    {
      if(null===$timezone_)
        $timezone_=TimeZone::utc();

      return $this->format(self::FORMAT_ISO8601, $timezone_);
    }

    /**
     * @return boolean
     */
    public function isBefore(Date $date_)
    {
      return $this->toUnixTimestamp()<$date_->toUnixTimestamp();
    }

    /**
     * @return boolean
     */
    public function isAfter(Date $date_)
    {
      return $this->toUnixTimestamp()>$date_->toUnixTimestamp();
    }

    /**
     * @return int
     */
    public function getDay(TimeZone $timezone_=null)
    {
      return (int)$this->format('j', $timezone_);
    }

    /**
     * @return int
     */
    public function getDayOfYear(TimeZone $timezone_=null)
    {
      return (int)$this->format('z', $timezone_);
    }

    /**
     * @return int
     */
    public function getDayOfWeek(TimeZone $timezone_=null)
    {
      return (int)$this->format('w', $timezone_);
    }

    /**
     * @return int
     */
    public function getWeek(TimeZone $timezone_=null)
    {
      return (int)$this->format('W', $timezone_);
    }

    /**
     * @return int
     */
    public function getMonth(TimeZone $timezone_=null)
    {
      return (int)$this->format('n', $timezone_);
    }

    /**
     * @return int
     */
    public function getLengthOfMonth(TimeZone $timezone_=null)
    {
      return (int)$this->format('t', $timezone_);
    }

    /**
     * @return int
     */
    public function getYear(TimeZone $timezone_=null)
    {
      return (int)$this->format('Y', $timezone_);
    }

    /**
     * @return string
     */
    public function getShortYear(TimeZone $timezone_=null)
    {
      return $this->format('y', $timezone_);
    }

    /**
     * @return boolean
     */
    public function isLeapYear(TimeZone $timezone_=null)
    {
      return 1==(int)$this->format('L', $timezone_);
    }

    /**
     * @return int
     */
    public function getHour(TimeZone $timezone_=null)
    {
      return (int)$this->format('H', $timezone_);
    }

    /**
     * @return int
     */
    public function getMinute(TimeZone $timezone_=null)
    {
      return (int)$this->format('i', $timezone_);
    }

    /**
     * @return int
     */
    public function getSecond(TimeZone $timezone_=null)
    {
      return (int)$this->format('s', $timezone_);
    }

    /**
     * @return int
     */
    public function getMicroSecond(TimeZone $timezone_=null)
    {
      return (int)$this->format('u', $timezone_);
    }

    /**
     * @return boolean
     */
    public function isMorning(TimeZone $timezone_=null)
    {
      return self::ANTE_MERIDIEM==$this->format('a', $timezone_);
    }

    /**
     * @return boolean
     */
    public function isAfternoon(TimeZone $timezone_=null)
    {
      return self::POST_MERIDIEM==$this->format('a', $timezone_);
    }

    /**
    * @return boolean
     */
    public function isSummerTime(TimeZone $timezone_=null)
    {
      return 1==$this->format('I', $timezone_);
    }

    /**
     * @return \Components\Date
     */
    public function nextDay()
    {
      return $this->afterDays(1);
    }

    /**
     * @return \Components\Date
     */
    public function prevDay()
    {
      return $this->beforeDays(1);
    }

    /**
     * @return \Components\Date
     */
    public function nextMonth()
    {
      return $this->afterMonths(1);
    }

    /**
     * @return \Components\Date
     */
    public function prevMonth()
    {
      return $this->beforeMonths(1);
    }

    /**
     * @return \Components\Date
     */
    public function nextYear()
    {
      return $this->afterYears(1);
    }

    /**
     * @return \Components\Date
     */
    public function prevYear()
    {
      return $this->beforeYears(1);
    }

    /**
     * @param \Components\Time $time_
     *
     * @return \Components\Date
     */
    public function after(Time $time_)
    {
      return $this->modified('+'.$time_->toSeconds().' second');
    }

    /**
     * @param \Components\Time $time_
     *
     * @return \Components\Date
     */
    public function before(Time $time_)
    {
      return $this->modified('-'.$time_->toSeconds().' second');
    }

    /**
     * Returns time between this and any given date.
     *
     * @param \Components\Date $date_
     *
     * @return \Components\Time
     */
    public function during(Date $date_)
    {
      $interval=$this->m_date->diff($date_->m_date);

      $seconds=0;
      $seconds+=$interval->days*Time::SECONDS_DAY;
      $seconds+=$interval->h*Time::SECONDS_HOUR;
      $seconds+=$interval->i*Time::SECONDS_MINUTE;
      $seconds+=$interval->s;

      return Time::forSeconds($seconds);
    }

    /**
     * @param int $days_
     *
     * @return \Components\Date
     */
    public function afterDays($days_)
    {
      return $this->modified('+'.$days_.' day');
    }

    /**
     * @param int $days_
     *
     * @return \Components\Date
     */
    public function beforeDays($days_)
    {
      return $this->modified('-'.$days_.' day');
    }

    /**
     * @param int $months_
     *
     * @return \Components\Date
     */
    public function afterMonths($months_)
    {
      return $this->modified('+'.$months_.' month');
    }

    /**
     * @param int $months_
     *
     * @return \Components\Date
     */
    public function beforeMonths($months_)
    {
      return $this->modified('-'.$months_.' month');
    }

    /**
     * @param int $years_
     *
     * @return \Components\Date
     */
    public function afterYears($years_)
    {
      return $this->modified('+'.$years_.' year');
    }

    /**
     * @param int $years_
     *
     * @return \Components\Date
     */
    public function beforeYears($years_)
    {
      return $this->modified('-'.$years_.' year');
    }

    /**
     * @return \Components\Date
     */
    public function beginningOfDay()
    {
      $utc=TimeZone::utc();

      $date=new \DateTime($this->format('Y-m-dT00:00:00+0000', $utc), $utc->get());
      $date->setTimezone($utc->get());

      return new self($date);
    }

    /**
     * @return \Components\Date
     */
    public function endOfDay()
    {
      return $this->beginningOfDay()->after(
        Time::get(Time::SECONDS_DAY-1, Time::TIMEUNIT_SECONDS)
      );
    }

    /**
     * @return \Components\Date
     */
    public function beginningOfMonth()
    {
      $utc=TimeZone::utc();

      $date=new \DateTime($this->format('Y-m-01T00:00:00+0000', $utc), $utc->get());
      $date->setTimezone($utc->get());

      return new self($date);
    }

    /**
     * @return \Components\Date
     */
    public function beginningOfYear()
    {
      $utc=TimeZone::utc();

      $date=new \DateTime($this->format('Y-01-01T00:00:00+0000', $utc), $utc->get());
      $date->setTimezone($utc->get());

      return new self($date);
    }

    /**
     * @return \Components\Date
     */
    public function endOfMonth()
    {
      return $this->nextMonth()->beginningOfMonth()->prevDay();
    }

    /**
     * @return \Components\Date
     */
    public function endOfYear()
    {
      return $this->nextYear()->beginningOfYear()->prevDay();
    }
    //--------------------------------------------------------------------------


    // OVERRIDES/IMPLEMENTS
    /**
     * (non-PHPdoc)
     * @see Components.Comparable::compareTo()
     */
    public function compareTo($object_)
    {
      if($object_ instanceof static)
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
     * (non-PHPdoc)
     * @see Components.Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof static)
        return $this->toUnixTimestamp()===$object_->toUnixTimestamp();

      return false;
    }

    /**
     * (non-PHPdoc)
     * @see Components.Object::hashCode()
     */
    public function hashCode()
    {
      return integer_hash($this->toUnixTimestamp());
    }

    /**
     * (non-PHPdoc)
     * @see Components.Serializable_Php::serialize()
     */
    public function serialize()
    {
      return serialize($this->toISO8601());
    }

    /**
     * (non-PHPdoc)
     * @see Components.Serializable_Php::unserialize()
     *
     * @return \Components\Date
     */
    public function unserialize($data_)
    {
      $this->m_asString=unserialize($data_);
      $this->__wakeup();

      return $this;
    }

    /**
     * (non-PHPdoc)
     * @see Components.Serializable_Json::serializeJson()
     */
    public function serializeJson()
    {
      return json_encode($this->toISO8601());
    }

    /**
     * (non-PHPdoc)
     * @see Components.Serializable_Json::unserializeJson()
     *
     * @return \Components\Date
     */
    public function unserializeJson($json_)
    {
      $this->m_asString=json_decode($json_);
      $this->__wakeup();

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
      return $this->format(self::FORMAT_UTC, TimeZone::utc());
    }

    /**
     * (non-PHPdoc)
     * @see Components.Cloneable::__clone()
     *
     * @return \Components\Date
     */
    public function __clone()
    {
      return static::fromISO8601($this->toISO8601());
    }

    public function __sleep()
    {
      $this->m_asString=$this->toISO8601();

      return array('m_asString');
    }

    public function __wakeup()
    {
      $utc=TimeZone::utc()->get();

      $this->m_date=new \DateTime($this->m_asString, $utc);
      $this->m_date->setTimezone($utc);
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    /**
     * @var string
     */
    private $m_asString;
    /**
     * @var \DateTime
     */
    private $m_date;
    //-----


    /**
     * Returns modified clone.
     *
     * @param string $modification_
     *
     * @return \Components\Date
     */
    protected function modified($modification_=null)
    {
      // FIXME clone does not seem to work...
      $instance=static::fromISO8601($this->toISO8601());

      if(null!==$modification_)
        $instance->m_date->modify($modification_);

      return $instance;
    }
    //--------------------------------------------------------------------------
  }
?>
