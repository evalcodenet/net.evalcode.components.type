<?php


namespace Components;


  /**
   * Arrays
   *
   * @package net.evalcode.components
   * @subpackage type.exception
   *
   * @author evalcode.net
   */
  final class Arrays
  {
    // PREDEFINED PROPERTIES
    /**
     * Process arrays recursively
     *
     * @var int
     */
    const RECURSIVE=1;
    /**
     * Process arrays by their given order.
     *
     * @var int
     */
    const UNSORTED=2;
    /**
     * Process arrays sequential one level after another.
     *
     * @var int
     */
    const ONE_BY_ONE=4;
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    public static function toString(array $array_, $mode_=3,
      $maxDepth_=99, $separatorKeyValue_=': ', $separatorValues_=', ',
      $arrayDelimiterL_='[', $arrayDelimiterR_=']', &$string_='', &$level_=0)
    {
      $string_.=$arrayDelimiterL_;

      $values=array();

      if($maxDepth_>++$level_ && 0<count($array_))
      {
        foreach($array_ as $key=>$value)
        {
          if(is_array($value))
          {
            if(Bitmask::hasBitForBitmask($mode_, self::RECURSIVE))
            {
              $values[]=$key.$separatorKeyValue_.self::toString(
                $value,
                $mode_,
                $maxDepth_,
                $separatorKeyValue_,
                $separatorValues_,
                $arrayDelimiterL_,
                $arrayDelimiterR_,
                $strings_,
                $level_
              );
            }
            else
            {
              $values[]=$key.$separatorKeyValue_.self::TYPE;
            }
          }
          else
          {
            $values[]=$key.$separatorKeyValue_.(string)$value;
          }
        }
      }

      $string_.=implode($separatorValues_, $values);
      $string_.=$arrayDelimiterR_;

      $level_--;

      return $string_;
    }

    public static function containsKey(array $array_, $key_, $mode_=3, array &$parentKeys_=array())
    {
      // search current level
      $exists=array_key_exists($key_, $array_);

      if($exists || false===Bitmask::hasBitForBitmask($mode_, self::RECURSIVE))
        return $exists;

      // proceed with nested levels if requested
      foreach($array_ as $key=>$value)
      {
        if(is_array($value))
        {
          if(self::containsKey($value, $key_, $mode_, $parentKeys_))
          {
            array_unshift($parentKeys_, $key);

            return true;
          }
        }
      }

      return $exists;
    }

    public static function containsKeyBySubstring(array $array_, $substring_, $mode_=3, array &$parentKeys_=array())
    {
      $exists=false;
      $nestedArrays=array();
      $recursive=Bitmask::hasBitForBitmask($mode_, self::RECURSIVE);

      // search current level
      foreach($array_ as $key=>$value)
      {
        if(is_array($value))
          $nestedArrays[]=$key;

        if(false===$exists)
        {
          $exists=String::contains($key, $substring_);

          if(-1<$exists)
          {
            $exists=$key;

            if(false===$recursive)
              return $exists;
          }
        }
      }

      if(false===$recursive)
        return $exists;

      // proceed with nested levels if requested
      foreach($nestedArrays as $nestedArray)
      {
        $exists=self::containsKeyBySubstring(
          $array_[$nestedArray], $substring_, $mode_, $parentKeys_
        );

        if(false!==$exists)
        {
          array_unshift($parentKeys_, $nestedArray);

          return $exists;
        }
      }

      return $exists;
    }

    public static function containsValue(array $array_, $value_, $mode_=3, array &$parentKeys_=array())
    {
      // search current level
      $exists=array_search($value_, $array_);

      if(false!==$exists || false===Bitmask::hasBitForBitmask($mode_, self::RECURSIVE))
        return $exists;

      // proceed with nested levels if requested
      foreach($array_ as $key=>$value)
      {
        if(is_array($value))
        {
          if(self::containsValue($value, $value_, $mode_, $parentKeys_))
          {
            array_unshift($parentKeys_, $key);

            return true;
          }
        }
      }

      return $exists;
    }

    public static function containsValueBySubstring(array $array_, $substring_, $mode_=3, array &$parentKeys_=array())
    {
      $exists=false;
      $nestedArrays=array();
      $recursive=Bitmask::hasBitForBitmask($mode_, self::RECURSIVE);

      // search current level
      foreach($array_ as $key=>$value)
      {
        if(is_array($value))
        {
          $nestedArrays[]=$key;
        }
        else if(false===$exists)
        {
          $exists=String::contains($value, $substring_);

          if(false!==$exists)
          {
            $exists=$key;

            if(false===$recursive)
              return $exists;
          }
        }
      }

      if(false===$recursive)
        return $exists;

      // proceed with nested levels if requested
      foreach($nestedArrays as $nestedArray)
      {
        $exists=self::containsValueBySubstring(
          $array_[$nestedArray], $substring_, $mode_, $parentKeys_
        );

        if(false!==$exists)
        {
          array_unshift($parentKeys_, $nestedArray);

          return $exists;
        }
      }

      return $exists;
    }
    //--------------------------------------------------------------------------
  }
?>
