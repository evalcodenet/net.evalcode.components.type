<?php


  /**
   * Type
   *
   * @package net.evalcode.components
   * @subpackage type
   *
   * @since 1.0
   * @access public
   *
   * @author Carsten Schipke <carsten.schipke@evalcode.net>
   * @copyright Copyright (C) 2012 evalcode.net
   * @license GNU General Public License 3
   */
  class Type implements Object
  {
    // CONSTRUCTION
    public function __construct($name_)
    {
      $this->m_name=$name_;
    }
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS

    /**
     * @return Type
     */
    public static function of(Object $object_)
    {
      return new self(get_class($object_));
    }

    /**
     * @param string $name_
     *
     * @return \Components\Type
     */
    public static function forName($name_)
    {
      return new self($name_);
    }
    //--------------------------------------------------------------------------


    // ACCESSORS/MUTATORS

    /**
     * @return Ns
     */
    public function getNamespace()
    {
      return Ns::of($this);
    }

    public function getName()
    {
      return $this->m_name;
    }
    //--------------------------------------------------------------------------


    // OVERRIDES/IMPLEMENTS
    /**
     * @see Object::getType()
     */
    public function getType()
    {
      return $this;
    }

    public function equals($object_)
    {
      if($object_ instanceof self)
        return String::equal($this->m_name, $object_->m_name);
      if($object_ instanceof Object)
        return $object_->getType()->equals($this);

      return false;
    }

    public function hashCode()
    {
      return String::hash($this->m_name);
    }

    public function __toString()
    {
      return $this->m_name;
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    private $m_name;
    //--------------------------------------------------------------------------
  }
?>
