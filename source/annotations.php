<?php


namespace Components;


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
    // PREDEFINED PROPERTIES
    const TYPE_ANNOTATION=1;
    const METHOD_ANNOTATION=2;
    const PROPERTY_ANNOTATION=4;
    const PARAMETER_ANNOTATION=8;

    const PATTERN='/(?:namespace[\s]+([\\a-z]+)[;]+[\s\w\\/]*)*(?:[\040\052]*[@]([a-z0-9]+)\(*([\040-\047\053-\177]*)\)*)*[\012\040]*\052\057*[\040\012]*(?:[\040\012]*(?:(?:(?:(?:abstract|final)+\s+)*(?:class|interface|trait)\s(\w+)\s)|((?:var|final|static|public|function)*[\s\w]*[$a-z_]+)))*/mi';
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
     * @return \Components\Annotations
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
    }

    /**
     * Registeres multiple annotation types for names at once.
     *
     * @param array|string $annotations_
     */
    public static function registerAnnotations(array $annotations_)
    {
      self::$m_registeredAnnotations=array_merge(self::$m_registeredAnnotations, $annotations_);
    }

    /**
     * Defines registered named annotation types.
     *
     * @param array|string $annotations_
     */
    public static function setRegisteredAnnotations(array $annotations_)
    {
      self::$m_registeredAnnotations=$annotations_;
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
     * @return array|Components\Annotation
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
     * @return \Components\Annotation
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
     * @return array|Components\Annotation
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
     * @return \Components\Annotation
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
     * Returns annotations of given method parameter or returns annotations
     * of all parameters for given method if no parameter name specified.
     *
     * @param string $methodName_
     * @param string $parameterName_
     *
     * @return array|Components\Annotation
     */
    public function getParameterAnnotations($methodName_, $parameterName_=null)
    {
      if(null===$parameterName_)
      {
        if(false===isset($this->m_annotations[self::PARAMETER_ANNOTATION][$methodName_]))
          return array();

        foreach($this->m_annotations[self::PARAMETER_ANNOTATION][$methodName_] as $parameterName=>$parameterAnnotations)
          $this->resolveParameterAnnotations(self::PARAMETER_ANNOTATION, $methodName_, $parameterName, $parameterAnnotations);

        return $this->m_annotationInstances[self::PARAMETER_ANNOTATION][$methodName_];
      }

      if(false===isset($this->m_annotations[self::PARAMETER_ANNOTATION][$methodName_][$parameterName_]))
        return array();

      $this->resolveParameterAnnotations(self::PARAMETER_ANNOTATION, $methodName_, $parameterName_,
        $this->m_annotations[self::PARAMETER_ANNOTATION][$methodName_][$parameterName_]
      );

      return $this->m_annotationInstances[self::PARAMETER_ANNOTATION][$methodName_][$parameterName_];
    }

    /**
     * Checks if parameter of given name and corresponding method is decorated
     * with an annotation of given name.
     *
     * @param string $methodName_
     * @param string $parameterName_
     * @param string $annotationName_
     *
     * @return boolean
     */
    public function hasParameterAnnotation($methodName_, $parameterName_, $annotationName_)
    {
      return isset($this->m_annotations[self::PARAMETER_ANNOTATION][$methodName_][$parameterName_][$annotationName_]);
    }

    /**
     * Returns property annotations the property of given name and corresponding
     * type is decorated with. Returns property annotations of all properties of
     * corresponding type if given property name is 'null'.
     *
     * @param string $propertyName_
     *
     * @return array|Components\Annotation
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
     * @return \Components\Annotation
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


    // OVERRIDES
    /**     * @see Components\Object::hashCode() Components\Object::hashCode()
     */
    public function hashCode()
    {
      return object_hash($this);
    }

    /**     * @see Components\Object::equals() Components\Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return $this->m_type===$object_->m_type;

      return false;
    }

    /**     * @see Components\Object::__toString() Components\Object::__toString()
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
    private static $m_registeredAnnotations=array(
      Annotation_Name::NAME=>Annotation_NAME::TYPE,
      Annotation_Type::NAME=>Annotation_Type::TYPE
    );

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
      if(isset($this->m_annotationInstances[$type_][$typeName_][$annotationName_]))
        return $this->m_annotationInstances[$type_][$typeName_][$annotationName_];

      if(isset(self::$m_registeredAnnotations[$annotationName_]))
        $class=self::$m_registeredAnnotations[$annotationName_];
      else
        $class=Annotation::TYPE;

      $this->m_annotationInstances[$type_][$typeName_][$annotationName_]=new $class();

      foreach($annotationProperties_ as $property=>$value)
        $this->m_annotationInstances[$type_][$typeName_][$annotationName_]->$property=$value;

      return $this->m_annotationInstances[$type_][$typeName_][$annotationName_];
    }

    private function resolveParameterAnnotations($type_, $methodName_, $parameterName_, array $annotations_)
    {

      if(isset($this->m_annotations[$type_][$methodName_][$parameterName_]))
      {
        foreach($this->m_annotations[$type_][$methodName_][$parameterName_] as $annotationName=>$annotationProperties)
          $this->resolveParameterAnnotation($type_, $methodName_, $parameterName_, $annotationName, $annotationProperties);
      }

      if(false===isset($this->m_annotationInstances[$type_][$methodName_][$parameterName_]))
        return array();

      return $this->m_annotationInstances[$type_][$methodName_][$parameterName_];
    }

    private function resolveParameterAnnotation($type_, $methodName_, $parameterName_, $annotationName_, array $annotationProperties_)
    {
      if(isset($this->m_annotationInstances[$type_][$methodName_][$parameterName_][$annotationName_]))
        return $this->m_annotationInstances[$type_][$methodName_][$parameterName_][$annotationName_];

      if(isset(self::$m_registeredAnnotations[$annotationName_]))
        $class=self::$m_registeredAnnotations[$annotationName_];
      else
        $class=Annotation::TYPE;

      $this->m_annotationInstances[$type_][$methodName_][$parameterName_][$annotationName_]=new $class();

      foreach($annotationProperties_ as $property=>$value)
        $this->m_annotationInstances[$type_][$methodName_][$parameterName_][$annotationName_]->$property=$value;

      return $this->m_annotationInstances[$type_][$methodName_][$parameterName_][$annotationName_];
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
     * @return \Components\Annotations
     */
    private static function resolveInstance($type_)
    {
      if(0===strpos($type_, '\\'))
        $type_=ltrim($type_, '\\');

      $cacheKeyType='components/type/annotations/'.md5($type_);

      if(false===($cached=Cache::get($cacheKeyType)))
      {
        // Pays off if classloader cache is built sufficiently ...
        if(!$typeLocation=Runtime_Classloader::get()->getClasspath($type_))
        {
          $cacheKeyTypeLocation="$cacheKeyType/file";

          // ... yet requires fallback for out-of-control classloaders (e.g. during unit test execution).
          if(false===($typeLocation=Cache::get($cacheKeyTypeLocation)))
          {
            $type=new \ReflectionClass($type_);
            $typeLocation=$type->getFileName();

            Cache::set($cacheKeyTypeLocation, $typeLocation);
          }
        }

        $annotations=self::parseAnnotations($typeLocation);
        foreach($annotations as $type=>$typeAnnotations)
          Cache::set($cacheKeyType, $typeAnnotations);

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
     * available information about type, property, method & parameter annotations..
     *
     * @param string $path_
     *
     * @return array|string
     */
    // TODO Proper implementation
    private static function parseAnnotations($path_)
    {
      $annotations=array();

      $source=file_get_contents($path_);

      $matches=array();
      preg_match_all(self::PATTERN, $source, $matches);

      $type=null;
      $method=null;
      $namespace=null;

      $buffer=array();
      foreach($matches[2] as $idx=>$annotationName)
      {
        if($annotationName)
          $buffer[$annotationName]=array();

        if($matches[3][$idx])
        {
          foreach(explode(',', $matches[3][$idx]) as $arg)
          {
            if(false===($posAssign=strpos($arg, '=')))
              $buffer[$annotationName]['value']=trim($arg);
            else
              $buffer[$annotationName][trim(substr($arg, 0, $posAssign))]=trim(substr($arg, $posAssign+1));
          }
        }

        if($matches[1][$idx])
          $namespace=$matches[1][$idx];

        if($matches[4][$idx])
        {
          if(null===$namespace)
            $type=$matches[4][$idx];
          else
            $type=$namespace.'\\'.$matches[4][$idx];

          $annotations[$type][self::TYPE_ANNOTATION][$type]=$buffer;
          $buffer=array();
        }

        if($matches[5][$idx])
        {
          // parameter
          if(0===strpos($matches[5][$idx], '$'))
          {
            $annotations[$type][self::PARAMETER_ANNOTATION][$method][trim(substr($matches[5][$idx], 1))]=$buffer;
            $buffer=array();
          }
          // method
          if(false!==($pos=strpos($matches[5][$idx], 'function')))
          {
            $method=trim(substr($matches[5][$idx], $pos+8));
            $annotations[$type][self::METHOD_ANNOTATION][$method]=$buffer;
            $buffer=array();
          }
          // property
          else if(false!==($pos=strpos($matches[5][$idx], '$')))
          {
            $annotations[$type][self::PROPERTY_ANNOTATION][trim(substr($matches[5][$idx], $pos+1))]=$buffer;
            $buffer=array();
          }
        }
      }

      return $annotations;
    }
    //--------------------------------------------------------------------------
  }
?>
