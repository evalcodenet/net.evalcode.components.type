<?php


namespace Components;


  /**
   * Type_Test_Unit_Case_Annotations
   *
   * @package net.evalcode.components
   * @subpackage type.test.unit.case
   *
   * @author evalcode.net
   */
  class Type_Test_Unit_Case_Annotations implements Test_Unit_Case
  {
    // TESTS
    /**
     * @test
     * @profile fork
     */
    public function testParse()
    {
      split_time('Reset');

      $annotations=Annotations::get('Components\\Type_Test_Unit_Case_Annotations_Entity');
      split_time('Invoke Annotations::get(Components\\Type_Test_Unit_Case_Annotations_Entity)');

      $annotations=Annotations::get('Components\\Type_Test_Unit_Case_Annotations_Entity');
      split_time('Invoke Annotations::get(Components\\Type_Test_Unit_Case_Annotations_Entity)');

      assertTrue($annotations->hasTypeAnnotation(Annotation_Name::NAME));
      split_time('Invoke Annotations$hasMethodAnnotation(name)');

      assertTrue($annotations->hasTypeAnnotation(Annotation_Name::NAME));
      split_time('Invoke Annotations$hasMethodAnnotation(name)');

      assertTrue($annotations->hasTypeAnnotation('package'));
      split_time('Invoke Annotations$hasMethodAnnotation(package)');

      assertFalse($annotations->hasTypeAnnotation('version'));
      split_time('Invoke Annotations$hasMethodAnnotation(version)');

      assertTrue($annotations->hasMethodAnnotation('poke', Annotation_Name::NAME));
      split_time('Invoke Annotations$hasMethodAnnotation(poke)');

      assertTrue($annotations->hasMethodAnnotation('poke', Annotation_Name::NAME));
      split_time('Invoke Annotations$hasMethodAnnotation(poke)');

      $pokeName=$annotations->getMethodAnnotation('poke', Annotation_Name::NAME);
      split_time('Invoke Annotations$getMethodAnnotation(poke)');

      $pokeName=$annotations->getMethodAnnotation('poke', Annotation_Name::NAME);
      split_time('Invoke Annotations$getMethodAnnotation(poke)');

      $annotations=Annotations::get(__CLASS__);
      split_time('Invoke Annotations::get('.__CLASS__.')');

      $annotations=Annotations::get(__CLASS__);
      split_time('Invoke Annotations::get('.__CLASS__.')');

      assertEquals('poke', $pokeName->value);
    }
    //--------------------------------------------------------------------------
  }
?>
