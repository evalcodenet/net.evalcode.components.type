<?php


namespace Components;


  /**
   * Type_Test_Unit_Case_Annotations_Entity
   *
   * @package net.evalcode.components.type
   * @subpackage test.unit.case.annotations
   *
   * @author evalcode.net
   *
   * @name entity
   */
  class Type_Test_Unit_Case_Annotations_Entity implements Object
  {
    // PROPERTIES
    /**
     * @var \Components\Integer
     */
    public $id;
    /**
     * @var \Components\String
     */
    public $name;
    /**
     * @column name=created_at,size=255
     * @var Components\Date
     */
    var $createdAt;
    //--------------------------------------------------------------------------


    // ACCESSORS
    /**
     * @GET
     *
     * @name poke
     * @return \Components\String
     */
    public function poke(Components\String /** @name a */ $a_,
      Components\String /** @queryParam(name=b) */ $b_,
      Components\String /** @queryParam name=c, value=foo */ $c_,
      /** @queryParam name=d, type=string, value=bar */ $d_)
    {
      return null;
    }
    //--------------------------------------------------------------------------


    // OVERRIDES
    /**
     * @see \Components\Object::hashCode() \Components\Object::hashCode()
     */
    public function hashCode()
    {
      return \math\hasho($this);
    }

    /**
     * @see \Components\Object::equals() \Components\Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return $this->id===$object_->id;

      return false;
    }

    /**
     * @see \Components\Object::__toString() \Components\Object::__toString()
     */
    public function __toString()
    {
      return sprintf('%2@%s{id: %s, name: %s, created_at: %s}',
        __CLASS__,
        $this->hashCode(),
        $this->id,
        $this->name,
        $this->createdAt
      );
    }
    //--------------------------------------------------------------------------
  }
?>
