<?php


namespace Components;


  /**
   * Type_Test_Unit_Suite
   *
   * @package net.evalcode.components
   * @subpackage type.test.unit
   *
   * @author evalcode.net
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
        'Components\\Type_Test_Unit_Case_Annotations'
      );
    }
    //--------------------------------------------------------------------------
  }
?>
