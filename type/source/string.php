<?php


namespace Components;


  /**
   * String
   *
   * @package net.evalcode.components
   * @subpackage type
   *
   * @author evalcode.net
   */
  class String extends Primitive implements Object, Cloneable, Comparable
  {
    // CONSTANTS
    /**
     * @var string Name of this type.
     */
    const TYPE=__CLASS__;
    /**
     * @var string Name of native representation of this type.
     */
    const TYPE_NATIVE='string';
    //--------------------------------------------------------------------------


    // CONSTRUCTION
    /**
     * @param string $value_
     */
    public function __construct($value_)
    {
      $this->m_value=$value_;
    }
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * @return String
     */
    public static function valueOf($value_)
    {
      return new self((string)$value_);
    }

    /**
     * @return string
     */
    public static function native()
    {
      return self::TYPE_NATIVE;
    }

    /**
     * @param mixed $value_
     *
     * @return String
     */
    public static function cast($value_)
    {
      return new self((string)$value_);
    }

    /**
     * Determines whether given string is 'null' or of zero-length.
     *
     * @param string $string_
     *
     * @return boolean
     */
    public static function isEmpty($string_)
    {
      return null===$string_ || 1>mb_strlen($string_);
    }

    /**
    * Calculates hash code for given string.
    *
    * @param string $string_
    *
    * @return integer
    */
    public static function hash($string_)
    {
      return string_hash($string_);
    }

    /**
     * @param string $string_
     *
     * @return string
     */
    public static function encodeBase64($string_)
    {
      return base64_encode($string_);
    }

    /**
     * @param string $stringEncoded_
     *
     * @return string
     */
    public static function decodeBase64($stringEncoded_)
    {
      return base64_decode($stringEncoded_);
    }

    /**
     * @param string $string_
     *
     * @return string
     */
    public static function urlEncodeBase64($string_)
    {
      return rtrim(strtr(base64_encode($string_), '+/', '-_'), '=');
    }

    /**
     * @param string $stringEncoded_
     *
     * @return string
     */
    public static function urlDecodeBase64($stringEncoded_)
    {
      return base64_decode(str_pad(strtr($stringEncoded_, '-_', '+/'), strlen($stringEncoded_)%4, '=', STR_PAD_RIGHT));
    }

    /**
     * Transforms given string's characters to and returns as lowercase.
     *
     * @param string $string_
     */
    public static function lowercase($string_)
    {
      return mb_strtolower($string_);
    }

    /**
     * Transforms given string's characters to and returns as uppercase.
     *
     * @param string $string_
     */
    public static function uppercase($string_)
    {
      return mb_strtoupper($string_);
    }

    /**
     * @param string $string_
     *
     * @return string
     */
    public static function camelcase($string_)
    {
      if(false===is_string($string_))
        $string_=(string)$string_;

      $string='';

      $string_=mb_strtolower(trim($string_));
      $len=mb_strlen($string_);
      for($i=0; $i<$len; $i++)
      {
        if(32===($dec=ord($string_[$i])))
          $string.=mb_strtoupper($string_[++$i]);
        else
          $string.=$string_[$i];
      }

      return $string;
    }

    /**
     * @param string $string_
     *
     * @return string
     */
    public static function camelcaseToUppercase($string_)
    {
      if(false===is_string($string_))
        $string_=(string)$string_;

      $string='';

      $len=mb_strlen($string_);
      for($i=0; $i<$len; $i++)
      {
        $dec=ord($string_[$i]);
        if(64<$dec && 91>$dec)
        {
          if(0<$i)
            $string.=' ';

          $string.=$string_[$i];
        }
        else
        {
          $string.=chr($dec-32);
        }
      }

      return $string;
    }

    /**
     * @param string $string_
     *
     * @return string
     */
    public static function camelcaseToLowercase($string_)
    {
      if(false===is_string($string_))
        $string_=(string)$string_;

      $string='';

      $len=mb_strlen($string_);
      for($i=0; $i<$len; $i++)
      {
        $dec=ord($string_[$i]);
        if(64<$dec && 91>$dec)
        {
          if(0<$i)
            $string.=' ';

          $string.=chr($dec+32);
        }
        else
        {
          $string.=$string_[$i];
        }
      }

      return $string;
    }

    /**
     * Returns first position of second given string in first given string.
     *
     * <p>
     *   Returns first position of $string1_ in $string0_ starting at $offset_.
     *   Returns -1 if indexed (sub-)$string0_ does not contain $string1_.
     * </p>
     *
     * @param string $string0_
     * @param string $string1_
     * @param integer $offset_
     *
     * @return integer
     */
    public static function indexOf($string0_, $string1_, $offset_=0)
    {
      if(false===($idx=mb_strpos($string0_, $string1_, $offset_)))
        return -1;

      return $idx;
    }

    /**
     * Returns last position of second given string in first given string.
     *
     * <p>
     *   Returns last position of $string1_ in $string0_ starting at $offset_.
     *   Returns -1 if indexed (sub-)$string0_ does not contain $string1_.
     * </p>
     *
     * @param string $string0_
     * @param string $string1_
     * @param integer $offset_
     *
     * @return integer
     */
    public static function lastIndexOf($string0_, $string1_, $offset_=0)
    {
      if(false===($idx=mb_strrpos($string0_, $string1_, $offset_)))
        return -1;

      return $idx;
    }

    /**
     * Returns specified part of given string.
     *
     * <p>
     *   Extracts and returns a string from passed $string_ ranging
     *   from $offset_ to $offset_+$length_.
     * </p>
     *
     * @param string $string_
     * @param integer $offset_
     * @param integer $length_
     *
     * @return string
     */
    public static function substring($string_, $offset_, $length_=null)
    {
      if(null===$length_)
        return mb_substr($string_, $offset_);

      return mb_substr($string_, $offset_, $length_);
    }

    /**
     * Returns length of passed string.
     *
     * <p>
     *   Returns length of passed $string_.
     * </p>
     *
     * @param string $string_
     *
     * @return integer
     */
    public static function length($string_)
    {
      return mb_strlen($string_);
    }

    /**
     * Determines whether two passed strings are equal to each other.
     *
     * <p>
     *   Returns 'true' if passed $string0_, $string1_ are equal, otherwise
     *   returns 'false'.
     * </p>
     *
     * @param string $string0_
     * @param string $string1_
     *
     * @return boolean
     */
    public static function equal($string0_, $string1_)
    {
      return 0===strnatcmp($string0_, $string1_);
    }

    /**
     * Compares two strings to each other case-sensitive and returns
     * an numeric indicator of which one is the greater one.
     *
     * <p>
     *   Returns an integer below, equal to or above zero indicating whether
     *   passed $string0_ is less than, equal to or more than passed $string1_.
     * </p>
     *
     * @param string $string0_
     * @param string $string1_
     *
     * @return integer
     */
    public static function compare($string0_, $string1_)
    {
      return strnatcmp($string0_, $string1_);
    }

    /**
     * Compares two strings to each other case-insensitive and returns
     * an numeric indicator of which one is the greater one.
     *
     * <p>
     *   Returns an integer below, equal to or above zero indicating whether
     *   passed $string0_ is less than, equal to or more than passed $string1_.
     * </p>
     *
     * @param string $string0_
     * @param string $string1_
     *
     * @return integer
     */
    public static function compareIgnoreCase($string0_, $string1_)
    {
      return strnatcasecmp($string0_, $string1_);
    }

    /**
     * Determines whether passed string contains second passed string.
     *
     * <p>
     *   Returns 'true' if $string0_ contains contents of $string1_,
     *   otherwise returns 'false'.
     * </p>
     *
     * @param string $string0_
     * @param string $string1_
     *
     * @return boolean
     */
    public static function contains($string0_, $string1_)
    {
      return false!==mb_strpos($string0_, $string1_);
    }

    /**
     * Determines whether passed string starts with second passed string.
     *
     * <p>
     *   Returns 'true' if $string0_ starts with contents of $string1_,
     *   otherwise returns 'false'.
     * </p>
     *
     * @param string $string0_
     * @param string $string1_
     *
     * @return boolean
     */
    public static function startsWith($string0_, $string1_)
    {
      return 0===mb_strpos($string0_, $string1_);
    }

    /**
     * Determines whether passed string starts with second passed string
     * ignoring case sensitivity.
     *
     * <p>
     *   Returns 'true' if $string0_ starts with contents of $string1_
     *   regardless whether passed strings may contain different capitalization.
     *   Otherwise returns 'false'.
     * </p>
     *
     * @param string $string0_
     * @param string $string1_
     *
     * @return boolean
     */
    public static function startsWithIgnoreCase($string0_, $string1_)
    {
      return 0===mb_stripos($string0_, $string1_);
    }

    /**
     * Determines whether passed string ends with second passed string.
     *
     * <p>
     *   Returns 'true' if $string0_ ends with contents of $string1_,
     *   otherwise returns 'false'.
     * </p>
     *
     * @param string $string0_
     * @param string $string1_
     *
     * @return boolean
     */
    public static function endsWith($string0_, $string1_)
    {
      if(false===($pos=mb_strrpos($string0_, $string1_)))
        return false;

      return mb_strlen($string0_)===$pos+mb_strlen($string1_);
    }

    /**
     * Determines whether passed string ends with second passed string
     * ignoring case sensitivity.
     *
     * <p>
     *   Returns 'true' if $string0_ ends with contents of $string1_
     *   regardless whether passed strings may contain different capitalization.
     *   Otherwise returns 'false'.
     * </p>
     *
     * @param string $string0_
     * @param string $string1_
     *
     * @return boolean
     */
    public static function endsWithIgnoreCase($string0_, $string1_)
    {
      if(false===($pos=mb_strripos($string0_, $string1_)))
        return false;

      return mb_strlen($string0_)===$pos+mb_strlen($string1_);
    }

    /**
     * @param string $string_
     * @param string $match_
     * @param string $replace_
     *
     * @return string
     */
    public static function replace($string_, $match_, $replace_, $offset_=0)
    {
      if(-1<($idx=mb_strpos($string_, $match_, $offset_)))
        return mb_substr($string_, 0, $idx).$replace_.mb_substr($string_, $idx+mb_strlen($match_));

      return $string_;
    }

    /**
     * @param string $string_
     * @param string $match_
     * @param string $replace_
     *
     * @return string
     */
    public static function replaceAll($string_, $match_, $replace_)
    {
      return mb_ereg_replace($match_, $replace_, $string_);
    }

    /**
     * @param string $string_
     * @param integer $length_
     * @param string $append_
     * @param string $truncateAtCharacter_
     *
     * @return string
     */
    public static function truncate($string_, $length_, $append_=null, $truncateAtCharacter_=null)
    {
      if($length_>mb_strlen($string_))
        return $string_;

      $string=mb_substr($string_, 0, $length_);
      if(null===$truncateAtCharacter_)
        return $string.$append_;

      $truncatePos=mb_strpos($string_, $truncateAtCharacter_, $length_);

      return $string.mb_substr($string_, $length_, $truncatePos-$length_).$append_;
    }

    public static function escapeHtml($string_)
    {
      return htmlentities($string_, ENT_NOQUOTES, 'utf-8');
    }
    //--------------------------------------------------------------------------


    // OVERRIDES/IMPLEMENTS
    /**
     * (non-PHPdoc)
     * @see Cloneable::__clone()
     */
    public function __clone()
    {
      return new self($this->m_value);
    }

    /**
     * (non-PHPdoc)
     * @see Comparable::compareTo()
     */
    public function compareTo($object_)
    {
      if($object_ instanceof self)
        return self::compare($this->m_value, $object_->m_value);

      if(is_string($object_))
        return self::compare($this->m_value, $object_);

      throw new Runtime_Exception('type/string', sprintf(
        'Can not compare to given parameter [%s].', $object_
      ));
    }

    /**
     * (non-PHPdoc)
     * @see Object::hashCode()
     */
    public function hashCode()
    {
      return self::hash($this->m_value);
    }

    /**
     * (non-PHPdoc)
     * @see Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return self::equals($this->m_value, $object_->m_value);

      return $this->m_value===$object_;
    }

    /**
     * (non-PHPdoc)
     * @see Object::__toString()
     */
    public function __toString()
    {
      return $this->m_value;
    }
    //--------------------------------------------------------------------------
  }
?>
