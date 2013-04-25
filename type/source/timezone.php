<?php


namespace Components;


  /**
   * Misc_TimeZone
   *
   * @package tncMiscPlugin
   * @subpackage lib
   *
   * @author evalcode.net
   */
  class Misc_TimeZone implements Core_Class_Serializable
  {
    // CONSTRUCTION
    /*protected*/ function __construct(\DateTimeZone $timezone_=null)
    {
      $this->m_timezone=$timezone_;
    }
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * Returns timezone for given name.
     *
     * @return Misc_TimeZone
     */
    public static function forName($name_)
    {
      return new self(timezone_open($name_));
    }

    /**
     * Returns timezone for given GMT offset.
     *
     * @param signed int $hours_
     *
     * @return Misc_TimeZone
     */
    public static function forOffset($hours_)
    {
      $hours=abs($hours_);

      if(0>$hours_)
        $hours="Etc/GMT-$hours";
      else
        $hours="Etc/GMT+$hours";

      return new self(timezone_open($hours));
    }

    /**
     * Returns timezone for current php.ini configuration.
     *
     * @return Misc_TimeZone
     */
    public static function forSystemDefault()
    {
      return new self(timezone_open(date_default_timezone_get()));
    }

    /**
     * Returns UTC timezone.
     *
     * @return Misc_TimeZone
     */
    public static function utc()
    {
      return new self(timezone_open('UTC'));
    }
    //--------------------------------------------------------------------------


    // ACCESSORS/MUTATORS
    /**
     * @return \DateTimeZone
     */
    public function get()
    {
      return $this->m_timezone;
    }

    /**
     * @return string
     */
    public function getName()
    {
      return $this->m_timezone->getName();
    }
    //--------------------------------------------------------------------------


    // OVERRIDES/IMPLEMENTS
    /**
     * @see Core_Class::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return Misc_Text::equals($this->getName(), $this->getName());

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
      return $this->getName();
    }

    public function __clone()
    {
      return self::forName($this->getName());
    }

    public function __sleep()
    {
      $this->m_asString=(string)$this;

      return array('m_asString');
    }

    public function __wakeup()
    {
      $this->m_timezone=timezone_open($this->m_asString);
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    /**
     * @var string
     */
    private $m_asString;
    /**
     * @var \DateTimeZone
     */
    private $m_timezone;
    //--------------------------------------------------------------------------
  }
?>
