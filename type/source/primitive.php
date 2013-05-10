<?php


namespace Components;


  /**
   * Primitive
   *
   * <p>
   *   Super-type for all types representing boxed implementations of
   *   native PHP primitives.
   * </p>
   *
   * @package net.evalcode.components
   * @subpackage type
   *
   * @author evalcode.net
   *
   * @see Boolean
   * @see Float
   * @see HashMap
   * @see Integer
   * @see String
   */
  abstract class Primitive extends Type implements Serializable
  {
    // CONSTRUCTION
    public function __construct($value_=null)
    {
      parent::__construct(get_class($this));

      $this->m_value=$value_;
    }
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * Determines whether passed value is type name of a
     * PHP built-in/native primitive or one of its boxed implementations.
     *
     * @param string $type_
     *
     * @return boolean
     */
    public static function isPrimitive($type_)
    {
      if(isset(self::$m_nativeToBoxed[$type_]) || isset(self::$m_boxedToNative[$type_]))
        return true;

      return false;
    }

    /**
     * Determines whether passed value is name of a
     * boxed type representing a PHP built-in/native primitive.
     *
     * @param string $type_
     *
     * @return boolean
     */
    public static function isBoxed($type_)
    {
      if(isset(self::$m_boxedToNative[$type_]))
        return true;

      return false;
    }

    /**
     * Returns name of boxed implementation
     * corresponding to given PHP built-in/native primitive type name.
     *
     * @param string $type_
     *
     * @return string
     */
    public static function asBoxed($type_)
    {
      if(isset(self::$m_nativeToBoxed[$type_]))
        return self::$m_nativeToBoxed[$type_];

      if(isset(self::$m_boxedToNative[$type_]))
        return $type_;

      return null;
    }

    /**
     * Determines whether passed value is name of a
     * PHP built-in/native primitive type.
     *
     * @param string $type_
     *
     * @return boolean
     */
    public static function isNative($type_)
    {
      if(isset(self::$m_nativeToBoxed[$type_]))
        return true;

      return false;
    }

    /**
     * Returns name of PHP built-in/native primitive type
     * represented by the boxed type of given name.
     *
     * <p>
     *   For performance reasons, prefer to invoke [BoxedType]::native()
     *   directly whenever possible. For example:
     * </p>
     *
     * <code>
     *   /**
     *    * @return boolean
     *    {@*}
     *   Boolean::native();
     *   /**
     *    * @return float
     *    {@*}
     *   Float::native();
     *   /**
     *    * @return array
     *    {@*}
     *   HashMap::native();
     *   /**
     *    * @return integer
     *    {@*}
     *   Integer::native();
     *   /**
     *    * @return string
     *    {@*}
     *   String::native();
     * </code>
     *
     * @see Components.Primitive::native()
     *
     * @param string $type_
     *
     * @return string
     */
    public static function asNative($type_)
    {
      if(isset(self::$m_boxedToNative[$type_]))
        return self::$m_boxedToNative[$type_];

      if(isset(self::$m_nativeToBoxed[$type_]))
        return $type_;

      return null;
    }

    /**
     * Returns name of PHP built-in/native primitive type
     * represented by a invoked boxed type.
     *
     * @return string
     */
    public static function native()
    {
      throw new Exception_NotImplemented('components/type/primitive', 'Override Primitive::native()');
    }

    /**
     * Common transformation method for all boxed primitives.
     *
     * @param mixed $value_
     *
     * @return mixed
     */
    public static function cast($value_)
    {
      throw new Exception_NotImplemented('components/type/primitive', 'Override Primitive::cast().');
    }

    /**
     * Common factory method for all boxed primitives.
     *
     * @param mixed $value_
     *
     * @return Primitive
     */
    public static function valueOf($value_)
    {
      throw new Exception_NotImplemented('components/type/primitive', 'Override Primitive::valueOf().');
    }
    //--------------------------------------------------------------------------


    // ACCESSORS
    /**
     * Returns primitive value wrapped by its boxed implementation.
     *
     * @return mixed
     */
    public function value()
    {
      return $this->m_value;
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    /**
     * Registered boxed implementations
     * for their corresponding PHP built-in/native primitives.
     *
     * @var string|array
     */
    private static $m_nativeToBoxed=array(
      Boolean::TYPE_NATIVE=>Boolean::TYPE,
      Double::TYPE_NATIVE=>Double::TYPE,
      Float::TYPE_NATIVE=>Float::TYPE,
      HashMap::TYPE_NATIVE=>HashMap::TYPE,
      Integer::TYPE_NATIVE=>Integer::TYPE,
      String::TYPE_NATIVE=>String::TYPE
    );
    /**
     * PHP built-in/native primitives
     * for their corresponding boxed implementations.
     *
     * @var string|array
     */
    private static $m_boxedToNative=array(
      Boolean::TYPE=>Boolean::TYPE_NATIVE,
      Double::TYPE=>Double::TYPE_NATIVE,
      Character::TYPE=>Character::TYPE_NATIVE,
      Float::TYPE=>Float::TYPE_NATIVE,
      HashMap::TYPE=>HashMap::TYPE_NATIVE,
      Integer::TYPE=>Integer::TYPE_NATIVE,
      String::TYPE=>String::TYPE_NATIVE
    );

    /**
     * Primitive value.
     *
     * @var mixed
     */
    protected $m_value;
    //--------------------------------------------------------------------------
  }
?>
