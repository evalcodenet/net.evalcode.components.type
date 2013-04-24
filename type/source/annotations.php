<?php


  /**
   * Annotations
   *
   * @package net.evalcode.components
   * @subpackage type
   *
   * @author evalcode.net
   */
  final class Annotations implements Object
  {
    // CONSTANTS
    const TYPE_ANNOTATION=1;
    const METHOD_ANNOTATION=2;
    const PROPERTY_ANNOTATION=4;

    const PATTERN_DEFAULT='/(?:[\040\052]*[@]({})\(*([\040-\047\053-\177]*)\)*)*[\012\040]*\052\057*[\040\012]*(?:[\040\012]*(?:(?:(?:(?:abstract|final)+\s+)*(?:class|interface|trait)\s(\w+)\s)|((?:abstract|final|static|public|protected|private|function)[\s\w]*[$A-z]+)))*/m';
    //--------------------------------------------------------------------------


    // CONSTRUCTION
    private function __construct($type_)
    {
      $this->m_type=$type_;
    }
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * Resolves (cached) annotations for given type.
     *
     * @param string $type_
     *
     * @return Annotations
     */
    public static function get($type_)
    {
      if(false===isset(self::$m_instances[$type_]))
        self::$m_instances[$type_]=self::resolveInstance($type_);

      return self::$m_instances[$type_];
    }

    /**
     * Registers annotation type for name.
     *
     * @param string $name_
     * @param string $type_
     */
    public static function registerAnnotation($name_, $type_)
    {
      self::$m_registeredAnnotations[$name_]=$type_;

      self::setRegisteredAnnotations(self::$m_registeredAnnotations);
    }

    /**
     * Registeres multiple annotation types for names at once.
     *
     * @param string|array $annotations_
     */
    public static function registerAnnotations(array $annotations_)
    {
      self::setRegisteredAnnotations(
        array_merge(self::$m_registeredAnnotations, $annotations_)
      );
    }

    /**
     * Defines registered named annotation types.
     *
     * @param string|array $annotations_
     */
    public static function setRegisteredAnnotations(array $annotations_)
    {
      self::$m_registeredAnnotations=$annotations_;
      self::$m_parserPattern=str_replace('{}', implode('|', array_keys($annotations_)), self::PATTERN_DEFAULT);
    }

    /**
     * Checks if annotation of given name is registered.
     *
     * @param string $name_
     */
    public static function isRegisteredAnnotation($name_)
    {
      return isset(self::$m_registeredAnnotations[$name_]);
    }
    //--------------------------------------------------------------------------


    // ACCESSORS
    /**
     * Returns all type annotations the corresponding type of this instance is
     * decorated with.
     *
     * @return Annotation|array
     */
    public function getTypeAnnotations()
    {
      return $this->resolveAnnotations(self::TYPE_ANNOTATION, $this->m_type);
    }

    /**
     * Checks if corresponding type of this instance is decorated with
     * an annotation for given name.
     *
     * @param string $annotationName_
     *
     * @return boolean
     */
    public function hasTypeAnnotation($annotationName_)
    {
      return isset($this->m_annotations[self::TYPE_ANNOTATION][$this->m_type][$annotationName_]);
    }

    /**
     * Returns type annotation for given name the corresponding type of this
     * instance is decorated with.
     *
     * @param string $annotationName_
     *
     * @return Annotation
     */
    public function getTypeAnnotation($annotationName_)
    {
      if(false===isset($this->m_annotations[self::TYPE_ANNOTATION][$this->m_type][$annotationName_]))
        return array();

      $this->resolveAnnotation(self::TYPE_ANNOTATION, $this->m_type, $annotationName_,
        $this->m_annotations[self::TYPE_ANNOTATION][$this->m_type][$annotationName_]
      );

      return $this->m_annotationInstances[self::TYPE_ANNOTATION][$this->m_type][$annotationName_];
    }

    /**
     * Returns method annotations the method of given name and corresponding
     * type is decorated with. Returns method annotations of all methods of
     * corresponding type if given method name is 'null'.
     *
     * @param string $methodName_
     *
     * @return Annotation|array
     */
    public function getMethodAnnotations($methodName_=null)
    {
      if(null===$methodName_)
      {
        if(false===isset($this->m_annotations[self::METHOD_ANNOTATION]))
          return array();

        foreach($this->m_annotations[self::METHOD_ANNOTATION] as $methodName=>$annotations)
          $this->resolveAnnotations(self::METHOD_ANNOTATION, $methodName);

        return $this->m_annotationInstances[self::METHOD_ANNOTATION];
      }

      return $this->resolveAnnotations(self::METHOD_ANNOTATION, $methodName_);
    }

    /**
     * Checks if method of given name and corresponding type is decorated
     * with an annotation of given name.
     *
     * @param string $methodName_
     * @param string $annotationName_
     *
     * @return boolean
     */
    public function hasMethodAnnotation($methodName_, $annotationName_)
    {
      return isset($this->m_annotations[self::METHOD_ANNOTATION][$methodName_][$annotationName_]);
    }

    /**
     * Returns annotation for given name the method of given method name and
     * corresponding type is decorated with.
     *
     * @param string $methodName_
     * @param string $annotationName_
     *
     * @return Annotation
     */
    public function getMethodAnnotation($methodName_, $annotationName_)
    {
      if(false===isset($this->m_annotations[self::METHOD_ANNOTATION][$methodName_][$annotationName_]))
        return array();

      $this->resolveAnnotation(self::METHOD_ANNOTATION, $methodName_, $annotationName_,
        $this->m_annotations[self::METHOD_ANNOTATION][$methodName_][$annotationName_]
      );

      return $this->m_annotationInstances[self::METHOD_ANNOTATION][$methodName_][$annotationName_];
    }

    /**
     * Returns property annotations the property of given name and corresponding
     * type is decorated with. Returns property annotations of all properties of
     * corresponding type if given property name is 'null'.
     *
     * @param string $propertyName_
     *
     * @return Annotation|array
     */
    public function getPropertyAnnotations($propertyName_=null)
    {
      if(null===$propertyName_)
      {
        if(false===isset($this->m_annotations[self::PROPERTY_ANNOTATION]))
          return array();

        foreach($this->m_annotations[self::PROPERTY_ANNOTATION] as $propertyName=>$annotations)
          $this->resolveAnnotations(self::PROPERTY_ANNOTATION, $propertyName);

        return $this->m_annotationInstances[self::PROPERTY_ANNOTATION];
      }

      return $this->resolveAnnotations(self::PROPERTY_ANNOTATION, $propertyName_);
    }

    /**
     * Checks if property of given name and corresponding type is decorated
     * with an annotation of given name.
     *
     * @param string $propertyName_
     * @param string $annotationName_
     *
     * @return boolean
     */
    public function hasPropertyAnnotation($propertyName_, $annotationName_)
    {
      return isset($this->m_annotations[self::PROPERTY_ANNOTATION][$propertyName_][$annotationName_]);
    }

    /**
     * Returns annotation for given name the property of given property name and
     * corresponding type is decorated with.
     *
     * @param string $propertyName_
     * @param string $annotationName_
     *
     * @return Annotation
     */
    public function getPropertyAnnotation($propertyName_, $annotationName_)
    {
      if(false===isset($this->m_annotations[self::PROPERTY_ANNOTATION][$propertyName_][$annotationName_]))
        return array();

      $this->resolveAnnotation(self::PROPERTY_ANNOTATION, $propertyName_, $annotationName_,
        $this->m_annotations[self::PROPERTY_ANNOTATION][$propertyName_][$annotationName_]
      );

      return $this->m_annotationInstances[self::PROPERTY_ANNOTATION][$propertyName_][$annotationName_];
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTS
    /**
     * (non-PHPdoc)
     * @see Object::hashCode()
     */
    public function hashCode()
    {
      return spl_object_hash($this);
    }

    /**
     * (non-PHPdoc)
     * @see Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return $this->m_type===$object_->m_type;

      return false;
    }

    /**
     * (non-PHPdoc)
     * @see Object::__toString()
     */
    public function __toString()
    {
      return sprintf('%s@%s{type: %s}',
        __CLASS__,
        $this->hashCode(),
        $this->m_type
      );
    }

    public function __sleep()
    {
      return array('m_annotations', 'm_type');
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    /**
     * Local instance cache.
     *
     * @var array|Annotations
     */
    private static $m_instances=array();
    /**
     * Registered annotations.
     *
     * @var array|string
     */
    private static $m_registeredAnnotations=array();
    /**
     * PCRE compliant regex pattern to parse types for registered annotations.
     *
     * @var string
     */
    private static $m_parserPattern;

    /**
     * Caches parsed initialized annotations
     * for the type this processor is responsible for.
     *
     * @var array|Annotation
     */
    private $m_annotationInstances=array();
    /**
     * Caches parsed information required to initialize annotations
     * for the type this processor is responsible for.
     *
     * @var array|string
     */
    private $m_annotations=array();
    /**
     * Name of type this processor is responsible for.
     *
     * @var array|string
     */
    private $m_type;
    //-----


    /**
     * Resolves/initializes and returns annotation(s) matching given arguments.
     *
     * @param integer $type_ Type/Method/Property Annotation?
     * @param string $typeName_ Name of annotated type.
     */
    private function resolveAnnotations($type_, $typeName_)
    {
      if(isset($this->m_annotations[$type_][$typeName_]))
      {
        foreach($this->m_annotations[$type_][$typeName_] as $annotationName=>$annotationProperties)
          $this->resolveAnnotation($type_, $typeName_, $annotationName, $annotationProperties);
      }

      if(false===isset($this->m_annotationInstances[$type_][$typeName_]))
        return array();

      return $this->m_annotationInstances[$type_][$typeName_];
    }

    /**
     * Resolves/initializes and returns the annotation matching given arguments.
     *
     * @param integer $type_ Type/Method/Property Annotation?
     * @param string $typeName_ Name of annotated type.
     * @param string $annotationName_ Name of annotation.
     * @param array|string $annotationProperties_ Possibly given annotation properties.
     *
     * @throws Runtime_Exception If illegal annotation name has been passed.
     */
    private function resolveAnnotation($type_, $typeName_, $annotationName_, array $annotationProperties_)
    {
      if(false===self::isRegisteredAnnotation($annotationName_))
      {
        throw new Runtime_Exception('components/annotation', sprintf(
          'Can not resolve unknown annotation [name: %s].', $annotationName_
        ));
      }

      if(isset($this->m_annotationInstances[$type_][$typeName_][$annotationName_]))
        return $this->m_annotationInstances[$type_][$typeName_][$annotationName_];

      $class=self::$m_registeredAnnotations[$annotationName_];
      $this->m_annotationInstances[$type_][$typeName_][$annotationName_]=new $class();

      foreach($annotationProperties_ as $property=>$value)
        $this->m_annotationInstances[$type_][$typeName_][$annotationName_]->$property=$value;

      return $this->m_annotationInstances[$type_][$typeName_][$annotationName_];
    }


    // HELPERS
    /**
     * Parses and caches annotations for given name of an annotated type if
     * not already cached.
     *
     * Retrieves neccessary information from cache and builds & returns
     * an instance of Annotations.
     *
     * @param string $type_ Name of annotated type.
     *
     * @return Annotations
     */
    private static function resolveInstance($type_)
    {
      if(null===($cached=Runtime::cache()->get("type/annotation/$type_")))
      {
        $cacheKeyTypeLocation="type/annotation/file/$type_";

        if(null===($typeLocation=Runtime::cache()->get($cacheKeyTypeLocation)))
        {
          $type=new ReflectionClass($type_);
          $typeLocation=$type->getFileName();

          Runtime::cache()->set($cacheKeyTypeLocation, $typeLocation);
        }

        $annotations=self::parseAnnotations($typeLocation);
        // Cache all parsed types for file of given type.
        foreach($annotations as $type=>$typeAnnotations)
        {
          Runtime::cache()->set("type/annotation/$type", $typeAnnotations);

          if($type!==$type_)
            Runtime::cache()->set("type/annotation/file/$type", $typeLocation);
        }

        $instance=new self($type_);
        $instance->m_annotations=$annotations[$type_];
      }
      else
      {
        $instance=new self($type_);
        $instance->m_annotations=$cached;
      }

      return $instance;
    }

    /**
     * Parses source code contained in file for given path and collects
     * available information about type, method & property annotations..
     *
     * @param string $path_
     *
     * @return array|string
     */
    private static function parseAnnotations($path_)
    {
      $annotations=array();

      $source=@file_get_contents($path_);

      $matches=array();
      preg_match_all(self::$m_parserPattern, $source, $matches);

      $type='';
      $buffer=array();
      foreach($matches[1] as $idx=>$annotationName)
      {
        if($annotationName)
          $buffer[$annotationName]=array();

        if($matches[2][$idx])
        {
          foreach(explode(',', $matches[2][$idx]) as $arg)
          {
            if(false===($posAssign=strpos($arg, '=')))
              $buffer[$annotationName]['value']=trim($arg);
            else
              $buffer[$annotationName][trim(substr($arg, 0, $posAssign))]=trim(substr($arg, $posAssign+1));
          }
        }

        if($matches[3][$idx])
        {
          $type=$matches[3][$idx];

          $annotations[$type][self::TYPE_ANNOTATION][$type]=$buffer;
          $buffer=array();
        }

        if($matches[4][$idx])
        {
          if(false!==($pos=strpos($matches[4][$idx], 'function')))
          {
            $annotations[$type][self::METHOD_ANNOTATION][trim(substr($matches[4][$idx], $pos+8))]=$buffer;
            $buffer=array();
          }
          else if(false!==($pos=strpos($matches[4][$idx], '$')))
          {
            $annotations[$type][self::PROPERTY_ANNOTATION][trim(substr($matches[4][$idx], $pos+1))]=$buffer;
            $buffer=array();
          }
        }
      }

      return $annotations;
    }
    //--------------------------------------------------------------------------
  }
?>
