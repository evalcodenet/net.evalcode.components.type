<?php


  /**
   * Enumeration
   *
   * @package net.evalcode.components
   * @subpackage type
   *
   * @author evalcode.net
   */
  abstract class Enumeration implements Object, Comparable
  {
    // CONSTRUCTION
    public function __construct($name_)
    {
      $type=get_class($this);

      $this->m_name=constant("$type::$name_");
      $this->m_key=self::$m_enums[$type][$name_];
    }
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * @param string $name_
     * @param array $args_
     *
     * @return Enumeration
     *
     * @throws Runtime_Exception
     */
    public static function __callStatic($name_, array $args_=array())
    {
      if(__CLASS__===($type=get_called_class()))
        throw new Runtime_Exception('type/enumeration', 'Enumeration can not be invoked directly.');

      if(isset(self::$m_enumInstances[$type][$name_]))
        return self::$m_enumInstances[$type][$name_];

      if(false===isset(self::$m_enums[$type]))
      {
        if(false===self::$m_initialized)
        {
          if(null===(self::$m_enums=Runtime::cache()->get('type/enumeration')))
            self::$m_enums=array();
        }

        if(false===array_key_exists($type, self::$m_enums))
        {
          self::$m_enums[$type]=array_flip(static::values());
          Runtime::cache()->set('type/enumeration', self::$m_enums);
        }
      }

      if(false===array_key_exists($name_, self::$m_enums[$type]))
      {
        $trace=debug_backtrace(false);
        $caller=$trace[1];

        throw new Runtime_Exception('type/enumeration', sprintf(
          'Call to undefined method %1$s::%2$s() in %3$s on line %4$d.',
            $type,
            $name_,
            $caller['file'],
            $caller['line']
        ));
      }

      if(0<count($args_))
      {
        array_unshift($args_, $name_);
        $class=new ReflectionClass($type);

        return $class->newInstanceArgs($args_);
      }

      // Cache simple enum instances.
      return self::$m_enumInstances[$type][$name_]=new $type($name_);
    }

    public static function contains($name_)
    {
      return array_key_exists($name_, self::$m_enums[get_called_class()]);
    }

    public static function containsKey($name_)
    {
      var_dump(self::$m_enums[get_called_class()]);
      return array_key_exists($name_, self::$m_enums[get_called_class()]);
    }

    /**
     * @param string $name_
     *
     * @return Enumeration
     */
    public static function valueOf($name_)
    {
      return static::$name_();
    }

    public abstract static function values();
    //--------------------------------------------------------------------------


    // ACCESSORS/MUTATORS
    public function name()
    {
      return $this->m_name;
    }

    public function key()
    {
      return $this->m_key;
    }
    //--------------------------------------------------------------------------


    // OVERRIDES/IMPLEMENTS
    /**
     * (non-PHPdoc)
     * @see Comparable::compareTo()
     */
    public function compareTo($object_)
    {
      if($object_ instanceof self)
      {
        if($this->m_key===$object_->m_key)
          return 0;

        return $this->m_key<$object_->m_key?-1:1;
      }

      return false;
    }

    /**
     * (non-PHPdoc)
     * @see Object::hashCode()
     */
    public function hashCode()
    {
      return String::hash($this->m_name);
    }

    /**
     * (non-PHPdoc)
     * @see Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof static)
        return $this->m_key===$object_->m_key;

      return false;
    }

    /**
     * (non-PHPdoc)
     * @see Object::__toString()
     */
    public function __toString()
    {
      return $this->m_name;
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    /**
     * @var boolean
     */
    private static $m_initialized=false;
    /**
     * @var array
     */
    private static $m_enums=array();
    /**
     * @var array|Enumeration
     */
    private static $m_enumInstances=array();

    protected $m_name;
    protected $m_key;
    //--------------------------------------------------------------------------
  }
?>
