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
  // TODO (CSH) Too many unnecessary to/from UTC conversions... Use given timezone and only convert if request.
  class Date implements Object, Cloneable, Comparable, Value_String, Serializable_Php
  {
    // PREDEFINED PROPERTIES
    const ANTE_MERIDIEM='am';
    const POST_MERIDIEM='pm';

    const FORMAT_ATOM='c';
    const FORMAT_COOKIE='l, d-M-y H:i:s T';
    const FORMAT_ISO8601='c';
    const FORMAT_RSS='D, d M Y H:i:s O';
    const FORMAT_UTC='Y-m-d H:i:s';
    const FORMAT_W3C='c';

    const FORMAT_DEFAULT='c';
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
     * @param \Components\Timezone $timezone_
     *
     * @return \Components\Date
     */
    public static function now()
    {
      $date=new \DateTime();
      $date->setTimezone(Timezone::utc()->internal());

      return new static($date);
    }

    /**
     * Parses given date/time of given timezone and converts to UTC.
     * If no timezone is given, a UTC date is expected.
     *
     * @param string $date_
     * @param \Components\Timezone $timezone_
     *
     * @return \Components\Date
     */
    public static function parse($date_, Timezone $timezone_=null, $pattern_=null)
    {
      $parsed=@date_parse($date_);

      if(null===$timezone_)
      {
        if(isset($parsed['zone']))
          $timezone_=Timezone::forOffset($parsed['zone']/60);
      }

      if(null===$timezone_)
        $timezone_=Timezone::utc();

      if(null===$pattern_)
        $pattern_=I18n::translate('common/datetime/pattern/parse');

      if(isset($parsed['errors_count']) && 0<(int)$parsed['errors_count'])
      {
        $date=\DateTime::createFromFormat($pattern_, $date_, $timezone_->internal());
      }
      else
      {
        extract($parsed);

        $date=new \DateTime(
          sprintf('%1$d-%2$d-%3$d %4$d:%5$d:%6$d', $year, $month, $day, $hour, $minute, $second),
          $timezone_->internal()
        );
      }

      if(!$date)
        throw new Exception_IllegalArgument('type/date', 'Unable to parse given date. Try specifying a matching pattern.');

      $date->setTimezone(Timezone::utc()->internal());

      return new static($date);
    }

    /**
     * Converts given unix timestamp to UTC.
     *
     * Pass optional timezone parameter if given timestamp is of another
     * timezone than the current system's one.
     *
     * @param integer $timestamp_
     * @param \Components\Timezone $timezone_
     *
     * @return \Components\Date
     */
    public static function forUnixTimestamp($timestamp_, Timezone $timezone_=null)
    {
      if(null===$timezone_)
        $timezone_=Timezone::systemDefault();

      $date=new \DateTime('@'.$timestamp_, $timezone_->internal());
      $date->setTimezone(Timezone::utc()->internal());

      return new static($date);
    }

    /**
     * @param string $date_ ISO-8601 formatted date/time string.
     *
     * @return \Components\Date
     */
    public static function forISO8601($date_)
    {
      $date=new \DateTime($date_);
      $date->setTimezone(Timezone::utc()->internal());

      return new static($date);
    }

    /**
     * @param string $date_ Date/time string in UTC.
     *
     * @return \Components\Date
     */
    public static function forUtc($date_)
    {
      $utc=Timezone::utc()->internal();

      $date=new \DateTime($date_, $utc);
      $date->setTimezone($utc);

      return new static($date);
    }

    /**
     * @param string $value_
     *
     * @return \Components\Date
     */
    public static function valueOf($value_)
    {
      return static::forISO8601($value_);
    }
    //--------------------------------------------------------------------------


    // ACCESSORS
    /**
     * @param string $format_
     * @param \Components\Timezone $timezone_
     *
     * @return string
     */
    public function format($format_=self::FORMAT_DEFAULT, Timezone $timezone_=null)
    {
      $date=clone $this->m_date;

      if(null===$timezone_)
        $timezone_=Timezone::systemDefault();

      $date->setTimezone($timezone_->internal());

      return $date->format($format_);
    }

    /**
     * @param string $format_
     * @param \Components\Timezone $timezone_
     *
     * @return string
     */
    public function formatLocalized($pattern_='common/datetime/pattern/full', Timezone $timezone_=null)
    {
      $date=clone $this->m_date;

      if(null===$timezone_)
        $timezone_=Timezone::systemDefault();

      $date->setTimezone($timezone_->internal());

      return strftime(I18n::translate($pattern_), $date->getTimestamp());
    }

    /**
     * @return integer
     */
    public function toUnixTimestamp(Timezone $timezone_=null)
    {
      return (int)$this->format('U', $timezone_);
    }

    /**
     * @return string
     */
    public function toISO8601(Timezone $timezone_=null)
    {
      return $this->format(self::FORMAT_ISO8601, $timezone_);
    }

    /**
     * @return string
     */
    public function toUtc()
    {
      return $this->m_date->format(self::FORMAT_UTC);
    }

    /**
     * @return string
     */
    public function toUtcLocalized()
    {
      return gmstrftime('%c', $this->m_date->getTimestamp());
    }

    /**
     * @return boolean
     */
    public function isBefore(Date $date_)
    {
      return $this->m_date->getTimestamp()<$date_->m_date->getTimestamp();
    }

    /**
     * @return boolean
     */
    public function isAfter(Date $date_)
    {
      return $this->m_date->getTimestamp()>$date_->m_date->getTimestamp();
    }

    /**
     * @return integer
     */
    public function getDay(Timezone $timezone_=null)
    {
      return (int)$this->format('j', $timezone_);
    }

    /**
     * @return integer
     */
    public function getDayOfYear(Timezone $timezone_=null)
    {
      return (int)$this->format('z', $timezone_);
    }

    /**
     * @return integer
     */
    public function getDayOfWeek(Timezone $timezone_=null)
    {
      return (int)$this->format('w', $timezone_);
    }

    /**
     * @return integer
     */
    public function getWeek(Timezone $timezone_=null)
    {
      return (int)$this->format('W', $timezone_);
    }

    /**
     * @return integer
     */
    public function getMonth(Timezone $timezone_=null)
    {
      return (int)$this->format('n', $timezone_);
    }

    /**
     * @return integer
     */
    public function getLengthOfMonth(Timezone $timezone_=null)
    {
      return (int)$this->format('t', $timezone_);
    }

    /**
     * @return integer
     */
    public function getYear(Timezone $timezone_=null)
    {
      return (int)$this->format('Y', $timezone_);
    }

    /**
     * @return string
     */
    public function getShortYear(Timezone $timezone_=null)
    {
      return $this->format('y', $timezone_);
    }

    /**
     * @return boolean
     */
    public function isLeapYear(Timezone $timezone_=null)
    {
      return 1==(int)$this->format('L', $timezone_);
    }

    /**
     * @return integer
     */
    public function getHour(Timezone $timezone_=null)
    {
      return (int)$this->format('H', $timezone_);
    }

    /**
     * @return integer
     */
    public function getMinute(Timezone $timezone_=null)
    {
      return (int)$this->format('i', $timezone_);
    }

    /**
     * @return integer
     */
    public function getSecond(Timezone $timezone_=null)
    {
      return (int)$this->format('s', $timezone_);
    }

    /**
     * @return integer
     */
    public function getMicroSecond(Timezone $timezone_=null)
    {
      return (int)$this->format('u', $timezone_);
    }

    /**
     * @return boolean
     */
    public function isMorning(Timezone $timezone_=null)
    {
      return self::ANTE_MERIDIEM===$this->format('a', $timezone_);
    }

    /**
     * @return boolean
     */
    public function isAfternoon(Timezone $timezone_=null)
    {
      return self::POST_MERIDIEM===$this->format('a', $timezone_);
    }

    /**
    * @return boolean
     */
    public function isSummerTime(Timezone $timezone_=null)
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
     * @param integer $days_
     *
     * @return \Components\Date
     */
    public function afterDays($days_)
    {
      return $this->modified('+'.$days_.' day');
    }

    /**
     * @param integer $days_
     *
     * @return \Components\Date
     */
    public function beforeDays($days_)
    {
      return $this->modified('-'.$days_.' day');
    }

    /**
     * @param integer $months_
     *
     * @return \Components\Date
     */
    public function afterMonths($months_)
    {
      return $this->modified('+'.$months_.' month');
    }

    /**
     * @param integer $months_
     *
     * @return \Components\Date
     */
    public function beforeMonths($months_)
    {
      return $this->modified('-'.$months_.' month');
    }

    /**
     * @param integer $years_
     *
     * @return \Components\Date
     */
    public function afterYears($years_)
    {
      return $this->modified('+'.$years_.' year');
    }

    /**
     * @param integer $years_
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
      $utc=Timezone::utc();

      $date=new \DateTime($this->format('Y-m-dT00:00:00+0000', $utc), $utc->internal());
      $date->setTimezone($utc->internal());

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
      $utc=Timezone::utc();

      $date=new \DateTime($this->format('Y-m-01T00:00:00+0000', $utc), $utc->internal());
      $date->setTimezone($utc->internal());

      return new self($date);
    }

    /**
     * @return \Components\Date
     */
    public function beginningOfYear()
    {
      $utc=Timezone::utc();

      $date=new \DateTime($this->format('Y-01-01T00:00:00+0000', $utc), $utc->internal());
      $date->setTimezone($utc->internal());

      return new self($date);
    }

    // FIXME (CSH) BS.
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


    // OVERRIDES
    /**     * @see Components\Comparable::compareTo() Components\Comparable::compareTo()
     */
    public function compareTo($object_)
    {
      if($object_ instanceof self)
      {
        $timestampSelf=$this->m_date->getTimestamp();
        $timestampObject=$object_->m_date->getTimestamp();

        if($timestampSelf===$timestampObject)
          return 0;

        if($timestampSelf>$timestampObject)
          return 1;
      }

      return -1;
    }

    /**     * @see Components\Object::equals() Components\Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return $this->m_date->getTimestamp()===$object_->m_date->getTimestamp();

      return false;
    }

    /**     * @see Components\Object::hashCode() Components\Object::hashCode()
     */
    public function hashCode()
    {
      return integer_hash($this->m_date->getTimestamp());
    }

    /**     * @see Components\Serializable::serialVersionUid() Components\Serializable::serialVersionUid()
     */
    public function serialVersionUid()
    {
      return 1;
    }

    /**     * @see Components\Object::__toString() Components\Object::__toString()
     */
    public function __toString()
    {
      return $this->toISO8601();
    }

    /**     * @see Components\Cloneable::__clone() Components\Cloneable::__clone()
     *
     * @return \Components\Date
     */
    public function __clone()
    {
      return static::forISO8601($this->toISO8601());
    }

    public function __sleep()
    {
      $this->m_iso8601=$this->toISO8601();

      return array('m_iso8601');
    }

    public function __wakeup()
    {
      $utc=Timezone::utc()->internal();

      $this->m_date=new \DateTime($this->m_iso8601, $utc);
      $this->m_date->setTimezone($utc);
    }

    /**     * @see Components\Value_String::value() Components\Value_String::value()
     */
    public function value()
    {
      return $this->toISO8601();
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    /**
     * @var string
     */
    private $m_iso8601;
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
      $instance=new static(new \DateTime('@'.$this->m_date->getTimestamp(), timezone_open('UTC')));

      if(null!==$modification_)
        $instance->m_date->modify($modification_);

      return $instance;
    }
    //--------------------------------------------------------------------------
  }
?>
