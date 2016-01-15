<?php


namespace Components;


  /**
   * Annotation
   *
   * @api
   * @package net.evalcode.components.type
   *
   * @author evalcode.net
   *
   * @property string value
   */
  class Annotation extends Properties
  {
    // PREDEFINED PROPERTIES
    /**
     * annotation
     *
     * <p>
     *   Name referencing the annotation in phpdoc comments.
     * </p>
     *
     * @var string
     */
    const NAME='annotation';
    /**
     * Annotation
     *
     * <p>
     *   Type for internal annotation-type-for-name resolution.
     * </p>
     *
     * @var string
     */
    const TYPE=__CLASS__;
    //--------------------------------------------------------------------------


    // OVERRIDES
    /**
     * @see Components\Object::hashCode() Components\Object::hashCode()
     */
    public function hashCode()
    {
      return \math\hashs(static::NAME);
    }

    /**
     * @see Components\Object::equals() Components\Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return $this->hashCode()===$object_->hashCode();

      return false;
    }

    /**
     * @see Components\Object::__toString() Components\Object::__toString()
     */
    public function __toString()
    {
      return sprintf('%s@%s{%s}',
        get_class($this),
        $this->hashCode(),
        Arrays::toString($this->toArray())
      );
    }
    //--------------------------------------------------------------------------
  }
?>
