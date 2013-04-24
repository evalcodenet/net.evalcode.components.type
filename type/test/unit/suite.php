<?php


  /**
   * Type_Test_Unit_Suite
   *
   * @package net.evalcode.components
   * @subpackage type.test.unit
   *
   * @since 1.0
   * @access public
   *
   * @author Carsten Schipke <carsten.schipke@evalcode.net>
   * @copyright Copyright (C) 2012 evalcode.net
   * @license GNU General Public License 3
   */
  class Type_Test_Unit_Suite implements Test_Unit_Suite
  {
    // IMPLEMENTS
    public function name()
    {
      return 'type/test/unit/suite';
    }

    public function cases()
    {
      return array(
        'Type_Test_Unit_Case_Annotations'
      );
    }
    //--------------------------------------------------------------------------
  }
?>
