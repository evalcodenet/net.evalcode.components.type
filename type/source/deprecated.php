<?php


namespace Components;


  /**
   * Deprecated
   *
   * @package net.evalcode.components
   * @subpackage runtime
   *
   * @author evalcode.net
   */
  class Deprecated extends Runtime_Exception
  {
    // PREDEFINED PROPERTIES
    const NAMESPACE_DEFAULT='deprecated';
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * Throws an deprecated exception if given version is older than
     * the current project version.
     *
     * If no message is given, an auto-generated message will be used
     * which contains type/method & location where this method has been
     * invoked - respectively the location of the deprecated code.
     *
     * @param string $namespace_
     * @param Version $version_
     * @param string $message_
     *
     * @throws Deprecated
     */
    public static function since($namespace_, Version $version_, $message_=null)
    {
      // ignore for production.
      if(Environment::isLive())
        return;

      // TODO Implement when we have proper release planning & versioning
    }

    /**
     * Throws an deprecated exception if given date was before the
     * current date.
     *
     * If no message is given, an auto-generated message will be used
     * which contains type/method & location where this method has been
     * invoked - respectively the location of the deprecated code.
     *
     * @param string $namespace_
     * @param Date $date_
     * @param string $message_
     *
     * @throws Deprecated
     */
    public static function sinceDate($namespace_, Date $date_, $message_=null)
    {
      // ignore for production.
      if(Environment::isLive())
        return;

      if(Date::now()->isAfter($date_))
      {
        if(null===$message_)
          throw self::createDefaultException($namespace_);

        throw new self($namespace_, $message_, null, true);
      }
    }

    /**
     * Throws an deprecated exception if given type exists.
     *
     * If no message is given, an auto-generated message will be used
     * which contains type/method & location where this method has been
     * invoked - respectively the location of the deprecated code.
     *
     * @param string $namespace_
     * @param string $clazz_
     * @param string $message_
     *
     * @throws Deprecated
     */
    public static function ifClassExists($namespace_, $clazz_, $message_=null)
    {
      // ignore for production.
      if(Environment::isLive())
        return;

      if(false===@class_exists($clazz_))
      {
        if(null===$message_)
          throw self::createDefaultException($namespace_);

        throw new self($namespace_, $message_, null, true);
      }
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    /**
     * Creates a default exception with default exception message
     * containing type/method & location of the code that
     * invokes an public static accessor of this class.
     *
     * @param string $namespace_
     */
    private static function createDefaultException($namespace_)
    {
      $exception=new self($namespace_, null, null, false);
      $stackTrace=$exception->getTrace();

      $exception->message=sprintf(
        'Deprecated use of [type: %1$s, method: %2$s, location: %3$s:%4$s].',
          $stackTrace[2]['class'],
          $stackTrace[2]['function'],
          isset($stackTrace[2]['file'])?$stackTrace[2]['file']:'{internal}',
          isset($stackTrace[2]['line'])?$stackTrace[2]['line']:0
      );

      $exception->log();

      return $exception;
    }
    //--------------------------------------------------------------------------
  }
?>
