<?php


  /**
   * Annotation
   *
   * @package net.evalcode.components
   * @subpackage type
   *
   * @author evalcode.net
   */
  abstract class Annotation
  {
    // CONSTANTS
    /**
     * Annotation
     *
     * </>
     * Name referencing the annotation in phpdoc comments.
     * </p>
     *
     * @var string
     */
    const NAME='Annotation';
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


    // PROPERTIES
    /**
     * Optional default value.
     *
     * @var string
     */
    public $value;
    //--------------------------------------------------------------------------
  }
?>
