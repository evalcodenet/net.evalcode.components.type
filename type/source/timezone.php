<?php


namespace Components;


  /**
   * Timezone
   *
   * @package net.evalcode.components
   * @subpackage type
   *
   * @author evalcode.net
   */
  class Timezone implements Object, Cloneable, Serializable_Php, Value_String
  {
    // CONSTRUCTION
    public function __construct(\DateTimeZone $timezone_=null)
    {
      $this->m_timezone=$timezone_;
    }
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * @param string $name_
     *
     * @return Components\Timezone
     */
    public static function valueOf($name_)
    {
      return new static(timezone_open($name_));
    }

    /**
     * Returns timezone for given name.
     *
     * @return Components\Timezone
     */
    public static function forName($name_)
    {
      return new static(timezone_open($name_));
    }

    /**
     * Returns timezone for given GMT offset.
     *
     * @param signed int $hours_
     *
     * @return Components\Timezone
     */
    public static function forOffset($hours_)
    {
      $hours=abs($hours_);

      if(0>$hours_)
        $hours="Etc/GMT-$hours";
      else
        $hours="Etc/GMT+$hours";

      return new static(timezone_open($hours));
    }

    /**
     * Returns timezone for current php.ini configuration.
     *
     * @return Components\Timezone
     */
    public static function forSystemDefault()
    {
      return new static(timezone_open(date_default_timezone_get()));
    }

    /**
     * Returns UTC timezone.
     *
     * @return Components\Timezone
     */
    public static function utc()
    {
      return new static(timezone_open('UTC'));
    }
    //--------------------------------------------------------------------------


    // ACCESSORS
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


    // OVERRIDES
    /**
     * (non-PHPdoc)
     * @see Components.Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof static)
        return String::equal($this->getName(), $this->getName());

      return false;
    }

    /**
     * (non-PHPdoc)
     * @see Components.Object::hashCode()
     */
    public function hashCode()
    {
      return String::hash($this->getName());
    }

    /**
     * (non-PHPdoc)
     * @see Components.Object::__toString()
     */
    public function __toString()
    {
      return $this->getName();
    }

    /**
     * (non-PHPdoc)
     * @see Components.Cloneable::__clone()
     */
    public function __clone()
    {
      return static::forName($this->getName());
    }

    /**
     * (non-PHPdoc)
     * @see Components.Serializable_Php::serialize()
     */
    public function serialize()
    {
      return (string)$this;
    }

    /**
     * (non-PHPdoc)
     * @see Components.Serializable_Php::unserialize()
     */
    public function unserialize($data_)
    {
      $this->m_asString=$data_;
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

    public function __sleep()
    {
      $this->m_asString=(string)$this;

      return array('m_asString');
    }

    public function __wakeup()
    {
      $this->m_timezone=timezone_open($this->m_asString);
    }

    /**
     * (non-PHPdoc)
     * @see Components.Value_String::value()
     */
    public function value()
    {
      return $this->m_timezone->getName();
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
