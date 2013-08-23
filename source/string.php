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
  class String extends Primitive implements Object, Cloneable, Comparable, Value_String
  {
    // PREDEFINED PROPERTIES
    /**
    * @var string Name of this type.
    */
    const TYPE=__CLASS__;
    /**
     * @var string Name of native representation of this type.
     */
    const TYPE_NATIVE='string';

    const ASCII_TABLE_NUMBERS           =00000001;
    const ASCII_TABLE_LETTERS           =00000010;
    const ASCII_TABLE_LOWERCASE         =00000100;
    const ASCII_TABLE_UPPERCASE         =00001000;
    const ASCII_TABLE_SPECIAL_CHARACTERS=00010000;
    const ASCII_TABLE_CONTROL_CHARACTERS=00100000;
    const ASCII_TABLE_FULL              =00111111;

    const TRUNCATE_END=1;
    const TRUNCATE_MIDDLE=2;
    const TRUNCATE_REVERSE=4;
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
     * @return \Components\String
     */
    public static function valueOf($value_)
    {
      return new static((string)$value_);
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
     * @return \Components\String
     */
    public static function cast($value_)
    {
      return (string)$value_;
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
     * Determines whether given string contains any readable non-zero
     * nor 'null' characters.
     *
     * @param string $string_
     *
     * @return boolean
     */
    public static function isNullOrEmpty($string_)
    {
      return null===$string_ || (!trim($string_) && !self::isZero($string_));
    }

    /**
     * Determines whether given string is equal to '0' (zero).
     *
     * @param string $string_
     *
     * @return boolean
     */
    public static function isZero($string_)
    {
      return 1===preg_match('/^[0]+$/', (string)$string_);
    }

    /**
     * Determines whether given string consists only of integers.
     *
     * @param string $string_
     *
     * @return boolean
     */
    public static function isInteger($string_)
    {
      return 1===preg_match('/^[+-]?[0-9]+$/', (string)$string_);
    }

    /**
     * Determines whether given argument is of type or can be cast to string.
     *
     * @param mixed $object_
     *
     * @return boolean
     */
    public static function isTypeCompatible($object_)
    {
      return is_string($object_) || $object_ instanceof static || method_exists(array($object_, '__toString'));
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
     * Transforms given string's characters to and returns as lowercase.
     *
     * @param string $string_
     */
    public static function lowercase($string_)
    {
      return mb_convert_case($string_, MB_CASE_LOWER, 'UTF-8');
    }

    /**
     * Transforms given string's characters to and returns as uppercase.
     *
     * @param string $string_
     */
    public static function uppercase($string_)
    {
      return mb_convert_case($string_, MB_CASE_UPPER, 'UTF-8');
    }

    public static function uppercaseWords($string_)
    {
      return mb_convert_case($string_, MB_CASE_TITLE, 'UTF-8');
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
     * Split given string into chunks of given length.
     *
     * @param string $string_
     * @param integer $lengthChunks_
     *
     * @return array|string
     */
    public static function split($string_, $lengthChunks_=1)
    {
      // FIXME Throws errors in certain versions if input is not recognizable..
      $string_=@iconv('UTF-8', 'UTF-16', $string_);
      $string_=substr($string_, 2);

      $m=2*$lengthChunks_;
      $length=strlen($string_);

      $chars=array();
      for($i=0; $i<$length; $i+=$m)
      {
        // TODO Optimize?
        // FIXME Throws errors in certain versions if input is not recognizable..
        $chars[]=@iconv('UTF-16', 'UTF-8', substr($string_, $i, $m));
      }

      return $chars;
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
    public static function replace($string_, $match_, $replace_=null, $offset_=0)
    {
      if(null===$replace_)
        $replace_='';

      if(0===$offset_)
        return str_replace($match_, $replace_, $string_);

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
    // TODO Implement $offset_.
    public static function replaceAll($string_, $match_, $replace_)
    {
      return str_replace($match_, $replace_, $string_);
    }

    /**
     * @param string $string_
     * @param integer $length_
     * @param string $append_
     * @param string $truncateAtCharacter_
     *
     * @return string
     */
    public static function truncate($string_, $length_, $append_=null, $truncateAtCharacter_=null, $style_=self::TRUNCATE_END)
    {
      if($length_>=mb_strlen($string_))
        return $string_;

      if(0<($style_&self::TRUNCATE_REVERSE))
      {
        $string_=static::reverse($string_);
        $string=mb_substr($string_, 0, $length_);

        if(null===$truncateAtCharacter_)
          return $append_.static::reverse($string);

        $truncatePos=mb_strpos($string_, $truncateAtCharacter_, $length_);

        return $append_.static::reverse($string.mb_substr($string_, $length_, $truncatePos-$length_));
      }

      $string=mb_substr($string_, 0, $length_);
      if(null===$truncateAtCharacter_)
        return $string.$append_;

      $truncatePos=mb_strpos($string_, $truncateAtCharacter_, $length_);

      return $string.mb_substr($string_, $length_, $truncatePos-$length_).$append_;
    }

    /**
     * Reverse given string.
     *
     * @param string $string_
     *
     * @return string
     */
    public static function reverse($string_)
    {
      $characters=static::split($string_, 1);
      $characters=array_reverse($characters);

      return implode('', $characters);
    }

    /**
     * Checks for ASCII string.
     *
     * @param string $string_
     *
     * @return bool
     */
    public static function isAscii($string_)
    {
      return 1!==preg_match('/[^\x00-\x7F]/', $string_);
    }

    /**
     * Converts string to ASCII.
     *
     * @param string $string_
     *
     * @return string
     *
     * FIXME Internationalize
     */
    public static function toAscii($string_)
    {
      // FIXME Throws errors in certain versions if input is not recognizable..
      return @iconv('UTF-8', 'ASCII//TRANSLIT', $string_);
    }

    /**
     * Checks for LATIN-1 string.
     *
     * @param string $string_
     *
     * @return boolean
     */
    public static function isLatin1($string_)
    {
      $len=mb_strlen($string_);

      for($i=0; $i<$len; ++$i)
      {
        $ord=ord($string_[$i]);

        // ASCII?
        if($ord>=0 && $ord<=127)
          continue;

        // 2 byte sequence?
        if($ord>=192 && $ord<=223)
        {
          $ord=($ord-192)*64+ord($string_[++$i])-128;

          // LATIN-1?
          if($ord<=0xff)
            continue;
        }

        return false;
      }

      return true;
    }

    /**
     * Checks for camelcase name.
     *
     * @param string $string_
     *
     * @return boolean
     */
    public static function isCamelCase($string_)
    {
      return 1===preg_match('/^[a-z][a-zA-Z0-9]*$/', $string_);
    }

    /**
     * @param string $string_ mul ti ply
     *
     * @return string mulTiPly
     */
    public static function toCamelCase($string_)
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
    public static function toTypeName($string_)
    {
      $string_=preg_replace('/[^a-z0-9]/i', ' ', $string_);
      $string_=ucwords(strtolower($string_));

      return preg_replace('/[ ]+/', '_', $string_);
    }

    /**
     * @param string $string_ propErTy
     *
     * @return string PROP ER TY
     */
    public static function camelCaseToUppercase($string_)
    {
      return strtoupper(static::camelCaseToLowercase($string_));
    }

    /**
     * @param string $string_ propErTy
     *
     * @return string prop er ty
     */
    public static function camelCaseToLowercase($string_)
    {
      static $stringTable=array(
        'A'=>' a', 'B'=>' b', 'C'=>' c', 'D'=>' d', 'E'=>' e', 'F'=>' f', 'G'=>' g', 'H'=>' h',
        'I'=>' i', 'J'=>' j', 'K'=>' k', 'L'=>' l', 'M'=>' m', 'N'=>' n', 'O'=>' o', 'P'=>' p',
        'Q'=>' q', 'R'=>' r', 'S'=>' s', 'T'=>' t', 'U'=>' u', 'V'=>' v', 'W'=>' w', 'X'=>' x',
        'Y'=>' y', 'Z'=>' z'
      );

      return strtr(trim($string_), $stringTable);
    }

    /**
     * Converts camelcase names to underscore.
     *
     * @param string $string_ propErTy
     *
     * @return string prop_er_ty
     */
    public static function camelCaseToUnderscore($string_)
    {
      static $stringTable=array(
        'A'=>'_a', 'B'=>'_b', 'C'=>'_c', 'D'=>'_d', 'E'=>'_e', 'F'=>'_f', 'G'=>'_g', 'H'=>'_h',
        'I'=>'_i', 'J'=>'_j', 'K'=>'_k', 'L'=>'_l', 'M'=>'_m', 'N'=>'_n', 'O'=>'_o', 'P'=>'_p',
        'Q'=>'_q', 'R'=>'_r', 'S'=>'_s', 'T'=>'_t', 'U'=>'_u', 'V'=>'_v', 'W'=>'_w', 'X'=>'_x',
        'Y'=>'_y', 'Z'=>'_z'
      );

      return strtr(trim($string_), $stringTable);
    }

    /**
     * Converts underscore names to camelcase.
     *
     * @param string $string_ prop_er_ty
     *
     * @return string propErTy
     */
    public static function underscoreToCamelCase($string_)
    {
      $camelcase=ucwords(strtr(trim($string_), '_', ' '));
      $camelcase[0]=self::lowercase($camelcase[0]);

      return mb_ereg_replace(' ', '', $camelcase);
    }

    /**
     * Converts underscore names to namespaces.
     *
     * @param string $string_ Name_Space_Type_Name
     *
     * @return string name/space/type/name
     */
    public static function underscoreToNamespace($string_)
    {
      return strtolower(strtr($string_, '_', '/'));
    }

    /**
     * Converts PHP type names to namespaces.
     *
     * @param string $string_ Name\\Space\\Type_Name
     *
     * @return string name/space/type/name
     *
     * For actual type <> name conversion look at runtime/classloader#lookupName
     * @see \Components\Runtime_Classloader::lookupName()
     */
    public static function typeToNamespace($string_)
    {
      return strtolower(strtr($string_, '\\_', '//'));
    }

    public static function typeToPath($string_)
    {
      return strtolower(strtr(str_replace('\\', '//', $string_), '_', '/'));
    }

    public static function pathToType($string_)
    {
      $chunks=explode('//', $string_);

      $type=array_pop($chunks);
      $type=strtr(ucwords(strtr($type, '/', ' ')), ' ', '_');

      if(1>count($chunks))
        return $type;

      $namespace=strtr(ucwords(implode(' ', $chunks)), ' ', '\\');

      return "$namespace\\$type";
    }

    /**
     * Converts namespace notation to PHP type names.
     *
     * @param string $string_ name/space/type/name
     *
     * @return string Name_Space_Type_Name
     *
     * For actual name <> type resolution look at runtime/classloader#lookup
     * @see \Components\Runtime_Classloader::lookup()
     */
    public static function namespaceToType($string_)
    {
      $string_=strtr($string_, '/', ' ');
      $string_=ucwords($string_);

      return strtr($string_, ' ', '_');
    }

    /**
     * Converts namespace notation to database table names.
     *
     * @param string $string_ entity/foo/bar
     *
     * @return string entity_foo_bar
     */
    public static function namespaceToTableName($string_)
    {
      $string_=preg_replace('/[^a-z0-9]/i', '_', $string_);

      return preg_replace('/_+/', '_', strtolower($string_));
    }

    /**
     * Checks for lowercase url friendly string.
     *
     * @param string $string_
     *
     * @return bool
     */
    public static function isLowercaseUrlIdentifier($string_)
    {
      return 1===preg_match('/^[a-z][a-z0-9_\-]*$/', $string_);
    }

    /**
     * Converts to lowercase url friendly string.
     *
     * @param string $string_
     *
     * @return string
     */
    public static function toLowercaseUrlIdentifier($string_, $preserveUnicode_=false)
    {
      if($preserveUnicode_)
        $string_=mb_convert_encoding($string_, 'HTML-ENTITIES', 'UTF-8');
      else
        $string_=static::toAscii($string_);

      $string_=preg_replace('/[^a-z0-9]/i', '-', $string_);
      $string_=preg_replace('/-+/', '-', strtolower($string_));

      if('-'===$string_)
        return null;

      return $string_;
    }

    /**
     * Removes HTML and PHP tags from given string.
     *
     * @param string $string_
     * @param string $ignoreTags_
     * @param boolean $escapeHtml_
     * @param Io_Charset $charset_
     *
     * @return string
     */
    public static function stripTags($string_, $ignoreTags_=null,
      $escapeHtml_=true, Io_Charset $charset_=null)
    {
      if(false===$escapeHtml_)
        return strip_tags($string_, $ignoreTags_);

      return static::escapeHtml(strip_tags($string_, $ignoreTags_), $charset_);
    }

    /**
     * @param string $string_
     * @param Io_Charset $charset_
     *
     * @return string
     */
    public static function escapeHtml($string_, Io_Charset $charset_=null)
    {
      if(null===$charset_)
        return htmlentities($string_, ENT_COMPAT, 'UTF-8');

      return htmlentities($string_, ENT_COMPAT, $charset_->name());
    }

    /**
     * Escapes string for use with javascript.
     *
     * @param string $string_
     *
     * @return string
     */
    public static function escapeJs($string_)
    {
      static $match=array("/\\\\/", "/\n/", "/\r/", "/\"/", "/\'/", "/&/", "/</", "/>/");
      static $replace=array("\\\\\\\\", "\\n", "\\r", "\\\"", "\\'", "\\x26", "\\x3C", "\\x3E");

      return self::replaceAll($string_, $match, $replace);
    }

    /**
     * Encodes to base64.
     *
     * @param string $string_
     *
     * @return string
     */
    public static function toBase64($string_)
    {
      return base64_encode($string_);
    }

    /**
     * Decodes from base64.
     *
     * @param string $string_
     *
     * @return string
     */
    public static function fromBase64($string_)
    {
      return base64_decode($string_);
    }

    /**
     * Encodes to url-friendly base64.
     *
     * @param string $string_
     *
     * @return string
     */
    public static function toBase64Url($string_)
    {
      return self::replaceAll(self::toBase64($string_), array('+', '/'), array('-', '_'));
    }

    /**
     * Decodes from url-friendly base64.
     *
     * @param string $string_
     *
     * @return string
     */
    public static function fromBase64Url($string_)
    {
      return self::fromBase64(self::replaceAll($string_, array('-', '_'), array('+', '/')));
    }

    /**
     * Encodes to quoted printable.
     *
     * @param string $string_
     *
     * @return string
     */
    public static function toQuotedPrintable($string_)
    {
      return quoted_printable_encode($string_);
    }

    /**
     * Decodes from quoted printable.
     *
     * @param string $string_
     *
     * @return string
     */
    public static function fromQuotedPrintable($string_)
    {
      return quoted_printable_decode($string_);
    }

    /**
     * Checks if given string is encoded by rawurlencode.
     *
     * @param string $string_
     *
     * @return boolean
     */
    public static function isUrlEncoded($string_)
    {
      static $m_urlEncoded=array(
        '%20', '%21', '%2A', '%27',
        '%28', '%29', '%3B', '%3A',
        '%40', '%26', '%3D', '%2B',
        '%24', '%2C', '%2F', '%3F',
        '%25', '%23', '%5B', '%5D'
      );
      static $m_urlDecoded=array(
        ' ', '!', '*', "'",
        "(", ")", ";", ":",
        "@", "&", "=", "+",
        "$", ",", "/", "?",
        "%", "#", "[", "]"
      );

      $count=0;
      str_replace($m_urlEncoded, $m_urlDecoded, $string_, $count);

      return 0<$count;
    }

    /**
     * Encodes to url-friendly string.
     *
     * @param string $string_
     * @param boolean $avoidDoubleEncoding_ Only encodes if given string is not already encoded.
     *
     * @return string
     */
    public static function urlEncode($string_, $avoidDoubleEncoding_=true)
    {
      if(false===$avoidDoubleEncoding_ || false===self::isUrlEncoded($string_))
        return rawurlencode($string_);

      return $string_;
    }

    /**
     * Decodes back from url-friendly string.
     *
     * @param string $string_
     * @param boolean $avoidDoubleDecoding_ Only decodes if given string is url encoded.
     *
     * @return string
     */
    public static function urlDecode($string_, $avoidDoubleDecoding_=true)
    {
      if(false===$avoidDoubleDecoding_ || self::isUrlEncoded($string_))
        return rawurldecode($string_);

      return $string_;
    }

    /**
     * @param string $length_
     * @param string $complexity_
     *
     * @throws Exception_IllegalArgument
     *
     * @return string
     */
    public static function generatePassword($length_=8, $complexity_=3)
    {
      if($length_>25 || $length_<6)
      {
        throw new Exception_IllegalArgument('components/text',
          'Password length must be greater than 6 and less than 25.'
        );
      }

      static $maxValues=array(1=>60, 2=>80, 3=>90, 4=>100);

      $password='';
      for($i=0; $i<$length_; $i++)
      {
        $value=rand(1, $maxValues[$complexity_]);
        // alphanumeric lowercase
        if($value>0 && $value<=$maxValues[1])
          $password.=chr(rand(97, 122));
        // alphanumeric uppercase
        if($value>$maxValues[1] && $value<=$maxValues[2])
          $password.=chr(rand(65, 90));
        // numeric
        if($value>$maxValues[2] && $value<=$maxValues[3])
          $password.=chr(rand(48, 57));
        // peculiar
        if($value>$maxValues[3] && $value<=$maxValues[4])
          $password.=chr(rand(35, 38));
      }

      return $password;
    }

    /**
     * The actual length of returned serial gets increasingly inacurate
     * with increasingly expected length since we do not respect that
     * further separators than naivly estimated are required as soon as
     * their amount exceeds the expected segment length.
     *
     * @param integer $length_
     * @param integer $lengthChunks_
     * @param string $separatorChunks_
     * @param integer $asciiTable_
     *
     * @return string
     */
    public static function generateSerialNumber($length_=29, $lengthSegments_=5, $separatorSegments_='-', $asciiTable_=null)
    {
      if(null===$asciiTable_)
        $asciiTable_=self::ASCII_TABLE_NUMBERS|self::ASCII_TABLE_LETTERS|self::ASCII_TABLE_UPPERCASE;

      $chars=static::asciiTable($asciiTable_);
      $limit=count($chars)-1;

      $countSegments=$length_/$lengthSegments_;

      if(null!==$separatorSegments_)
        $length_-=($countSegments-1)*strlen($separatorSegments_);

      $serial='';
      for($i=0; $i<$length_; $i++)
        $serial.=chr($chars[rand(0, $limit)]);

      $segments=str_split($serial, $lengthSegments_);

      return implode($separatorSegments_, array_slice($segments, 0, $countSegments));
    }

    /**
     * @param integer $type_
     *
     * @return array|integer
     */
    public static function asciiTable($type_=self::ASCII_TABLE_FULL)
    {
      if(isset(self::$m_asciiTable[$type_]))
        return self::$m_asciiTable[$type_];

      $table=array();
      if(0<(self::ASCII_TABLE_CONTROL_CHARACTERS&$type_))
        $table=array_merge($table, range(0, 31, 1));
      if(0<(self::ASCII_TABLE_SPECIAL_CHARACTERS&$type_))
        $table=array_merge($table, range(32, 47, 1), range(58, 64, 1), range(91, 96, 1), range(123, 127, 1));
      if(0<(self::ASCII_TABLE_NUMBERS&$type_))
        $table=array_merge($table, range(48, 57, 1));

      if(0<(self::ASCII_TABLE_LETTERS&$type_))
      {
        if((0===(self::ASCII_TABLE_UPPERCASE&$type_) && 0===(self::ASCII_TABLE_LOWERCASE&$type_))
          || (0<(self::ASCII_TABLE_UPPERCASE&$type_) && 0<(self::ASCII_TABLE_LOWERCASE&$type_)))
          $table=array_merge($table, range(65, 90, 1), range(97, 122, 1));
        else if(0<(self::ASCII_TABLE_LOWERCASE&$type_))
          $table=array_merge($table, range(97, 122, 1));
        else if(0<(self::ASCII_TABLE_UPPERCASE&$type_))
          $table=array_merge($table, range(65, 90, 1));
      }

      return self::$m_asciiTable[$type_]=$table;
    }

    public static function toPhoneNumber($string_, $convertMobileCountryCodeIdentifier_=false)
    {
      $string_=preg_replace('/[^+0-9]/', '', $string_);

      if($convertMobileCountryCodeIdentifier_)
        $string_=str_replace('+', '00', $string_);

      return $string_;
    }

    public static function toNumber($string_)
    {
      return preg_replace('/[^0-9]/', '', $string_);
    }
    //--------------------------------------------------------------------------


    // OVERRIDES
    /**
    * (non-PHPdoc)
    * @see Components\Cloneable::__clone()
    */
    public function __clone()
    {
      return new self($this->m_value);
    }

    /**
     * (non-PHPdoc)
     * @see Components\Comparable::compareTo()
     */
    public function compareTo($object_)
    {
      if($object_ instanceof self)
        return static::compare($this->m_value, $object_->m_value);

      if(is_string($object_))
        return static::compare($this->m_value, $object_);

      throw new Exception_IllegalCast('components/type/string', sprintf(
        'Can not compare to given parameter [%s].', $object_
      ));
    }

    /**
     * (non-PHPdoc)
     * @see Components\Object::hashCode()
     */
    public function hashCode()
    {
      return string_hash($this->m_value);
    }

    /**
     * (non-PHPdoc)
     * @see Components\Object::equals()
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return static::equals($this->m_value, $object_->m_value);

      return $this->m_value===$object_;
    }

    /**
     * (non-PHPdoc)
     * @see Components\Object::__toString()
     */
    public function __toString()
    {
      return $this->m_value;
    }

    /**
     * (non-PHPdoc)
     * @see Components\Serializable::serialVersionUid()
     */
    public function serialVersionUid()
    {
      return 1;
    }
    //--------------------------------------------------------------------------


    //IMPLEMENTATION
    private static $m_asciiTable=array();
    //--------------------------------------------------------------------------
  }
?>
