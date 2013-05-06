<?php


namespace Components;


  /**
   * Core_Object_Unmarshaller_Json
   *
   * @package tncCorePlugin
   * @subpackage lib.object.unmarshaller
   *
   * @author evalcode.net
   */
  class Core_Object_Unmarshaller_Json
    extends Core_Object_Unmarshaller_Abstract
  {
    // PREDEFINED PROPERTIES
    const KEY_COLLECTION='element';
    const KEY_COLLECTION_ELEMENT_TYPE='@type';
    //--------------------------------------------------------------------------


    // OVERRIDES
    public function unmarshall($string_, $type_=Core_Class::NAME_CLASS)
    {
      if(false===@class_exists($type_))
      {
        throw new Core_Exception('core/object/unmarshaller/json', sprintf(
          'Unmarshalling failed: Class for target type not found [%1$s].', $type_
        ));
      }

      $type=new \ReflectionClass($type_);

      try
      {
        $instance=$type->newInstance();
      }
      // TODO Check if this is the correct exception type that is thrown if instantiation failed.
      catch(\ReflectionException $e)
      {
        throw new Core_Exception('core/object/unmarshaller/json', sprintf(
          'Unable to unserialize to given type. A public [no|optional]-argument constructor is required [type: %1$s].', $type_
        ));
      }

      if($type->isSubclassOf(Core_Class_Serializable_Json::NAME_CLASS_SERIALIZABLE_JSON))
        return $instance->unserialize($string_);

      if(false===($source=@json_decode($string_, true)))
      {
        throw new Core_Exception('core/object/unmarshaller/json',
          'Unmarshalling failed: Unable to decode JSON string.'
        );
      }

      // map result collection
      if(isset($source[self::KEY_COLLECTION]))
      {
        $collection=array();
        if(isset($source[self::KEY_COLLECTION][self::KEY_COLLECTION_ELEMENT_TYPE]))
          $collection[0]=$source[self::KEY_COLLECTION];
        else
          $collection=$source[self::KEY_COLLECTION];

        return $this->mapCollection($collection, $type_);
      }

      // map single result
      // TODO Replace by \ReflectionClass/Object above.
      $target=new $type_();
      $this->mapObject($source, $target);

      return $target;
    }
    //--------------------------------------------------------------------------
  }
?>
