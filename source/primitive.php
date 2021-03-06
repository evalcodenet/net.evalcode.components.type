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
   * @api
   * @package net.evalcode.components.type
   *
   * @author evalcode.net
   *
   * @see \Components\Boolean Boolean
   * @see \Components\Float Float
   * @see \Components\HashMap HashMap
   * @see \Components\Integer Integer
   * @see \Components\String String
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
      // TODO (CSH) is_scalar || is_array might be faster ...
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
     * <pre>
     *   /**
     *    * @return boolean
     *    *\/
     *   Boolean::native();
     *   /**
     *    * @return float
     *    *\/
     *   Float::native();
     *   /**
     *    * @return array
     *    *\/
     *   HashMap::native();
     *   /**
     *    * @return integer
     *    *\/
     *   Integer::native();
     *   /**
     *    * @return string
     *    *\/
     *   String::native();
     * </pre>
     *
     * @see \Components\Primitive::native() \Components\Primitive::native()
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

    /**
     * @param string $type_
     * @param mixed $value_
     *
     * @return Primitive
     */
    public static function boxedForType($type_, $value_)
    {
      if(isset(self::$m_nativeToBoxed[$type_]))
      {
        $type_=self::$m_nativeToBoxed[$type_];

        return $type_::valueOf($value_);
      }

      if(isset(self::$m_boxedToNative[$type_]))
        return $type_::valueOf($value_);

      return null;
    }

    /**
     * @param string $type_
     * @param mixed $value_
     *
     * @return mixed
     */
    public static function castTo($type_, $value_)
    {
      if(null===self::$m_cast)
      {
        self::$m_cast=[
          Boolean::TYPE_NATIVE=>'boolval',
          Double::TYPE_NATIVE=>'doubleval',
          Float::TYPE_NATIVE=>'floatval',
          HashMap::TYPE_NATIVE=>function($value_) {return (array)$value_;},
          Integer::TYPE_NATIVE=>'intval',
          String::TYPE_NATIVE=>function($value_) {return (string)$value_;},
          Boolean::TYPE=>['\\Components\\Boolean', 'valueOf'],
          Double::TYPE=>['\\Components\\Double', 'valueOf'],
          Character::TYPE=>['\\Components\\Character', 'valueOf'],
          Float::TYPE=>['\\Components\\Float', 'valueOf'],
          HashMap::TYPE=>['\\Components\\HashMap', 'valueOf'],
          Integer::TYPE=>['\\Components\\Integer', 'valueOf'],
          String::TYPE=>['\\Components\\String', 'valueOf']
        ];
      }

      if($method=self::$m_cast[$type_])
        return call_user_func($method, $value_);

      return null;
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
     * @var string[]
     */
    private static $m_nativeToBoxed=[
      Boolean::TYPE_NATIVE=>Boolean::TYPE,
      Double::TYPE_NATIVE=>Double::TYPE,
      Float::TYPE_NATIVE=>Float::TYPE,
      HashMap::TYPE_NATIVE=>HashMap::TYPE,
      Integer::TYPE_NATIVE=>Integer::TYPE,
      String::TYPE_NATIVE=>String::TYPE
    ];
    /**
     * PHP built-in/native primitives
     * for their corresponding boxed implementations.
     *
     * @var string[]
     */
    private static $m_boxedToNative=[
      Boolean::TYPE=>Boolean::TYPE_NATIVE,
      Double::TYPE=>Double::TYPE_NATIVE,
      Character::TYPE=>Character::TYPE_NATIVE,
      Float::TYPE=>Float::TYPE_NATIVE,
      HashMap::TYPE=>HashMap::TYPE_NATIVE,
      Integer::TYPE=>Integer::TYPE_NATIVE,
      String::TYPE=>String::TYPE_NATIVE
    ];

    /**
     * @var callable[]
     */
    private static $m_cast;

    /**
     * Primitive value.
     *
     * @var mixed
     */
    protected $m_value;
    //--------------------------------------------------------------------------
  }
?>
