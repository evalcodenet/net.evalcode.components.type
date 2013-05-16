<?php


namespace Components;


  /**
   * Annotation
   *
   * @package net.evalcode.components
   * @subpackage type
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
     * </>
     * Name referencing the annotation in phpdoc comments.
     * </p>
     *
     * @var string
     */
    const NAME='annotation';
    /**
     * Annotation
     *
     * <p>
     * Type for internal annotation-type-for-name resolution.
     * </p>
     *
     * @var string
     */
    const TYPE=__CLASS__;
    //--------------------------------------------------------------------------


    // OVERRIDES/IMPLEMENTS
    /**
     * (non-PHPdoc)
     * @see Components\Object::hashCode()
     */
    public function hashCode()
    {
      return string_hash(static::NAME);
    }

    /**
     * (non-PHPdoc)
     * @see Components\Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return $this->hashCode()===$object_->hashCode();

      return false;
    }

    /**
     * (non-PHPdoc)
     * @see Components\Object::__toString()
     */
    public function __toString()
    {
      return sprintf('%s@%s{properties: %s}',
        __CLASS__,
        $this->hashCode(),
        Arrays::toString($this->toArray())
      );
    }
    //--------------------------------------------------------------------------
  }
?>
