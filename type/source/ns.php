<?php


  /**
   * Ns
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
  class Ns implements Object
  {
    // CONSTRUCTION
    public function __construct($type_)
    {
      $this->m_type=$type_;
    }
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * @param Object $object_
     *
     * @return Ns
     */
    public static function of(Object $object_)
    {
      return new self($object_->getType()->getName());
    }

    /**
     * @param string $name_
     *
     * @return Ns
     */
    public static function forName($name_)
    {
      return new self($name_);
    }
    //--------------------------------------------------------------------------


    // ACCESSORS/MUTATORS
    public function getName()
    {
      if(null===$this->m_name)
        $this->m_name=strtolower(str_replace('_', '/', $this->m_type));

      return $this->m_name;
    }
    //--------------------------------------------------------------------------


    // OVERRIDES/IMPLEMENTS
    /**
     * @see Object::getType()
     */
    public function getType()
    {
      return Type::of($this);
    }

    /**
     * @see Object::hashCode()
     */
    public function hashCode()
    {
      return String::hash($this->m_type);
    }

    /**
     * @see Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return String::equal($this->m_type, $object_->m_type);
      if($object_ instanceof Type)
        return String::equal($this->m_type, $object_->getName());
      if($object_ instanceof Object)
        return String::equal($this->m_type, $object_->getType()->getName());

      return false;
    }

    /**
     * @see Object::__toString()
     */
    public function __toString()
    {
      return $this->getName();
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    private $m_type;
    private $m_name;
    //--------------------------------------------------------------------------
  }
?>
