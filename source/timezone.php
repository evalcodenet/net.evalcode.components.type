<?php


namespace Components;


  /**
   * Timezone
   *
   * @api
   * @package net.evalcode.components.type
   *
   * @author evalcode.net
   */
  class Timezone implements Object, Cloneable, Value_String, Serializable_Php
  {
    // CONSTRUCTION
    public function __construct(\DateTimeZone $timezone_=null)
    {
      $this->m_timezone=$timezone_;
      $this->m_name=$timezone_->getName();
    }
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * @param string $name_
     *
     * @return \Components\Timezone
     */
    public static function valueOf($name_)
    {
      return new static(timezone_open($name_));
    }

    /**
     * Returns timezone for given name.
     *
     * @return \Components\Timezone
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
     * @return \Components\Timezone
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
     * @return \Components\Timezone
     */
    public static function systemDefault()
    {
      return new static(timezone_open(date_default_timezone_get()));
    }

    /**
     * Returns UTC timezone.
     *
     * @return \Components\Timezone
     */
    public static function utc()
    {
      return new static(timezone_open('UTC'));
    }
    //--------------------------------------------------------------------------


    // ACCESSORS
    /**
     * @return string
     */
    public function name()
    {
      return $this->m_name;
    }

    /**
     * @internal
     *
     * @return \DateTimeZone
     */
    function internal()
    {
      return $this->m_timezone;
    }
    //--------------------------------------------------------------------------


    // OVERRIDES
    /**
     * @see \Components\Object::equals() \Components\Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return String::equal($this->m_name, $object_->m_name);

      return false;
    }

    /**
     * @see \Components\Object::hashCode() \Components\Object::hashCode()
     */
    public function hashCode()
    {
      return string_hash($this->m_name);
    }

    /**
     * @see \Components\Object::__toString() \Components\Object::__toString()
     */
    public function __toString()
    {
      return $this->m_name;
    }

    /**
     * @see \Components\Cloneable::__clone() \Components\Cloneable::__clone()
     */
    public function __clone()
    {
      return new static(timezone_open($this->m_name));
    }

    /**
     * @see \Components\Serializable::serialVersionUid() \Components\Serializable::serialVersionUid()
     */
    public function serialVersionUid()
    {
      return 1;
    }

    public function __sleep()
    {
      return array('m_name');
    }

    public function __wakeup()
    {
      $this->m_timezone=timezone_open($this->m_name);
    }

    /**
     * @see \Components\Value_String::value() \Components\Value_String::value()
     */
    public function value()
    {
      return $this->m_name;
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    /**
     * @var string
     */
    private $m_name;
    /**
     * @var \DateTimeZone
     */
    private $m_timezone;
    //--------------------------------------------------------------------------
  }
?>
