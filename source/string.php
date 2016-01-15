<?php


namespace Components;


  /**
   * String
   *
   * @api
   * @package net.evalcode.components.type
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

    const ASCII_TABLE_NUMBERS=00000001;
    const ASCII_TABLE_LETTERS=00000010;
    const ASCII_TABLE_LOWERCASE=00000100;
    const ASCII_TABLE_UPPERCASE=00001000;
    const ASCII_TABLE_SPECIAL_CHARACTERS=00010000;
    const ASCII_TABLE_CONTROL_CHARACTERS=00100000;
    const ASCII_TABLE_FULL=00111111;

    const TRUNCATE_END=LIBSTD_STR_TRUNCATE_END;
    const TRUNCATE_MIDDLE=LIBSTD_STR_TRUNCATE_MIDDLE;
    const TRUNCATE_REVERSE=LIBSTD_STR_TRUNCATE_REVERSE;

    const PAD_LEFT=LIBSTD_STR_LEFT;
    const PAD_RIGHT=LIBSTD_STR_RIGHT;
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
      return new static((string)$value_);
    }

    /**
     * @see \str\equals() equals
     */
    public static function equal($string0_, $string1_)
    {
      return \str\equals($string0_, $string1_);
    }

    /**
     * @see \str\hash() hash
     */
    public static function hash($string_)
    {
      return \math\hashs_fnv($string_);
    }

    /**
     * @see \str\isEmpty() isEmpty
     */
    public static function isEmpty($string_)
    {
      return \str\isEmpty($string_);
    }

    /**
     * @see \str\isNullOrEmpty() isNullOrEmpty
     */
    public static function isNullOrEmpty($string_)
    {
      return \str\isNullOrEmpty($string_);
    }

    /**
     * @see \str\isZero() isZero
     */
    public static function isZero($string_)
    {
      return \str\isZero($string_);
    }

    /**
     * @see \str\isInteger() isInteger
     */
    public static function isInteger($string_)
    {
      return \str\isInteger($string_);
    }

    /**
     * @see \str\isTypeCompatible() isTypeCompatible
     */
    public static function isTypeCompatible($mixed_)
    {
      return \str\isTypeCompatible($mixed_);
    }

    /**
     * @see \str\length() length
     */
    public static function length($string_)
    {
      return \str\length($string_);
    }

    /**
     * @see \str\lowercase() lowercase
     */
    public static function lowercase($string_)
    {
      return \str\lowercase($string_);
    }

    /**
     * @see \str\uppercase() uppercase
     */
    public static function uppercase($string_)
    {
      return \str\uppercase($string_);
    }

    /**
     * @see \str\capitalize() capitalize
     */
    public static function capitalize($string_)
    {
      return \str\capitalize($string_);
    }

    /**
     * @see \str\indexOf() indexOf
     */
    public static function indexOf($string0_, $string1_, $offset_=0)
    {
      return \str\isNullOrEmpty($string0_, $string1_, $offset_);
    }

    /**
     * @see \str\lastIndexOf() lastIndexOf
     */
    public static function lastIndexOf($string0_, $string1_, $offset_=0)
    {
      return \str\lastIndexOf($string0_, $string1_, $offset_);
    }

    /**
     * @see \str\substring() substring
     */
    public static function substring($string_, $offset_, $length_=null)
    {
      return \str\substring($string_, $offset_, $length_);
    }

    /**
     * @see \str\split() split
     */
    public static function split($string_, $lengthChunks_=1)
    {
      return \str\split($string_, $lengthChunks_);
    }

    /**
     * @see \str\compare() compare
     */
    public static function compare($string0_, $string1_)
    {
      return \str\compare($string0_, $string1_);
    }

    /**
     * @see \str\compareIgnoreCase() compareIgnoreCase
     */
    public static function compareIgnoreCase($string0_, $string1_)
    {
      return \str\compareIgnoreCase($string0_, $string1_);
    }

    /**
     * @see \str\contains() contains
     */
    public static function contains($string0_, $string1_)
    {
      return \str\contains($string0_, $string1_);
    }

    /**
     * @see \str\startsWith() startsWith
     */
    public static function startsWith($string0_, $string1_)
    {
      return \str\startsWith($string0_, $string1_);
    }

    /**
     * @see \str\startsWithIgnoreCase() startsWithIgnoreCase
     */
    public static function startsWithIgnoreCase($string0_, $string1_)
    {
      return \str\startsWithIgnoreCase($string0_, $string1_);
    }

    /**
     * @see \str\endsWith() endsWith
     */
    public static function endsWith($string0_, $string1_)
    {
      return \str\endsWith($string0_, $string1_);
    }

    /**
     * @see \str\endsWithIgnoreCase() endsWithIgnoreCase
     */
    public static function endsWithIgnoreCase($string0_, $string1_)
    {
      return \str\endsWithIgnoreCase($string0_, $string1_);
    }

    /**
     * @see \str\replace() replace
     */
    public static function replace($string_, $match_, $replace_=null, $offset_=0)
    {
      return \str\replace($string_, $match_, $replace_, $offset_);
    }

    /**
     * @see \str\replaceAll() replaceAll
     */
    public static function replaceAll($string_, $match_, $replace_)
    {
      return \str\replaceAll($string_, $match_, $replace_);
    }

    /**
     * @see \str\truncate() truncate
     */
    public static function truncate($string_, $length_, $append_=null, $truncateAtCharacter_=null, $style_=self::TRUNCATE_END)
    {
      return \str\truncate($string_, $length_, $append_, $truncateAtCharacter_, $style_);
    }

    /**
     * @see \str\pad() pad
     */
    public static function pad($string_, $padLength_, $padString_, $padType_=null)
    {
      return \str\pad($string_, $padLength_, $padString_, $padType_);
    }

    /**
     * @see \str\reverse() reverse
     */
    public static function reverse($string_)
    {
      return \str\reverse($string_);
    }

    /**
     * @see \str\isAscii() isAscii
     */
    public static function isAscii($string_)
    {
      return \str\isAscii($string_);
    }

    /**
     * @see \str\toAscii() toAscii
     */
    public static function toAscii($string_)
    {
      return \str\toAscii($string_);
    }

    /**
     * @see \str\isLatin1() isLatin1
     */
    public static function isLatin1($string_)
    {
      return \str\isLatin1($string_);
    }

    /**
     * @see \str\isCamelCase() isCamelCase
     */
    public static function isCamelCase($string_)
    {
      return \str\isCamelCase($string_);
    }

    /**
     * @see \str\toCamelCase() toCamelCase
     */
    public static function toCamelCase($string_)
    {
      return \str\toCamelCase($string_);
    }

    /**
     * @see \str\toTypeName() toTypeName
     */
    public static function toTypeName($string_)
    {
      return \str\toTypeName($string_);
    }

    /**
     * @see \str\camelCaseToUppercase() camelCaseToUppercase
     */
    public static function camelCaseToUppercase($string_)
    {
      return \str\camelCaseToUppercase($string_);
    }

    /**
     * @see \str\camelCaseToLowercase() camelCaseToLowercase
     */
    public static function camelCaseToLowercase($string_)
    {
      return \str\camelCaseToLowercase($string_);
    }

    /**
     * @see \str\camelCaseToUnderscore() camelCaseToUnderscore
     */
    public static function camelCaseToUnderscore($string_)
    {
      return \str\camelCaseToUnderscore($string_);
    }

    /**
     * @see \str\underscoreToCamelCase() underscoreToCamelCase
     */
    public static function underscoreToCamelCase($string_)
    {
      return \str\underscoreToCamelCase($string_);
    }

    /**
     * @see \str\underscoreToNamespace() underscoreToNamespace
     */
    public static function underscoreToNamespace($string_)
    {
      return \str\underscoreToNamespace($string_);
    }

    /**
     * @see \str\typeToNamespace() typeToNamespace
     */
    public static function typeToNamespace($string_)
    {
      return \str\typeToNamespace($string_);
    }

    /**
     * @see \str\typeToPath() typeToPath
     */
    public static function typeToPath($string_)
    {
      return \str\typeToPath($string_);
    }

    /**
     * @see \str\pathToType() pathToType
     */
    public static function pathToType($string_)
    {
      return \str\pathToType($string_);
    }

    /**
     * @see \str\namespaceToType() namespaceToType
     */
    public static function namespaceToType($string_)
    {
      return \str\namespaceToType($string_);
    }

    /**
     * @see \str\namespaceToTableName() namespaceToTableName
     */
    public static function namespaceToTableName($string_)
    {
      return \str\namespaceToTableName($string_);
    }

    /**
     * @see \str\isLowercaseUrlIdentifier() isLowercaseUrlIdentifier
     */
    public static function isLowercaseUrlIdentifier($string_)
    {
      return \str\isLowercaseUrlIdentifier($string_);
    }

    /**
     * @see \str\toLowercaseUrlIdentifier() toLowercaseUrlIdentifier
     */
    public static function toLowercaseUrlIdentifier($string_, $preserveUnicode_=false)
    {
      return \str\toLowercaseUrlIdentifier($string_, $preserveUnicode_);
    }

    /**
     * @see \html\stripTags() stripTags
     */
    public static function stripTags($string_, $ignoreTags_=null,
      Io_Charset $charset_=null, $escapeHtml_=true, $flags_=ENT_QUOTES)
    {
      if(null===$charset_)
        return \html\strip($string_, $ignoreTags_, null, $escapeHtml_, ENT_XHTML, $flags_);

      return \html\strip($string_, $ignoreTags_, $charset_->name(), $escapeHtml_, ENT_XHTML, $flags_);
    }

    /**
     * @see \html\escape escape
     */
    public static function escapeHtml($string_, Io_Charset $charset_=null, $flags_=ENT_QUOTES)
    {
      if(null===$charset_)
        return \html\escape($string_, null, ENT_XHTML, $flags_);

      return \html\escape($string_, $charset_->name(), ENT_XHTML, $flags_);
    }

    /**
     * @see \html\escape5 escape5
     */
    public static function escapehtml5($string_, Io_Charset $charset_=null, $flags_=ENT_QUOTES)
    {
      if(null===$charset_)
        return \html\escape5($string_, null, ENT_HTML5, $flags_);

      return \html\escape5($string_, $charset_->name(), ENT_HTML5, $flags_);
    }

    /**
     * @see \xml\escape() escape
     */
    public static function escapeXml($string_, Io_Charset $charset_=null, $flags_=ENT_QUOTES)
    {
      if(null===$charset_)
        return \xml\escape($string_, null, ENT_XML1, $flags_);

      return \xml\escape($string_, $charset_->name(), ENT_XML1, $flags_);
    }

    /**
     * @see \js\escape() escape
     */
    public static function escapeJs($string_)
    {
      return \js\escape($string_);
    }

    /**
     * @see \str\encodeBase64() encodeBase64
     */
    public static function encodeBase64($string_)
    {
      return \str\encodeBase64($string_);
    }

    /**
     * @see \str\decodeBase64() decodeBase64
     */
    public static function decodeBase64($string_)
    {
      return \str\decodeBase64($string_);
    }

    /**
     * @see \str\encodeBase64Url() encodeBase64Url
     */
    public static function encodeBase64Url($string_)
    {
      return \str\encodeBase64Url($string_);
    }

    /**
     * @see \str\decodeBase64Url() decodeBase64Url
     */
    public static function decodeBase64Url($string_)
    {
      return \str\decodeBase64Url($string_);
    }

    /**
     * @see \str\encodeQuotedPrintable() encodeQuotedPrintable
     */
    public static function encodeQuotedPrintable($string_)
    {
      return \str\encodeQuotedPrintable($string_);
    }

    /**
     * @see \str\decodeQuotedPrintable() decodeQuotedPrintable
     */
    public static function decodeQuotedPrintable($string_)
    {
      return \str\decodeQuotedPrintable($string_);
    }

    /**
     * @see \str\encodedUrl() encodedUrl
     */
    public static function encodedUrl($string_)
    {
      return \str\encodedUrl($string_);
    }

    /**
     * @see \str\encodeUrl() encodeUrl
     */
    public static function encodeUrl($string_, $avoidDoubleEncoding_=false)
    {
      return \str\encodeUrl($string_, $avoidDoubleEncoding_);
    }

    /**
     * @see \str\decodeUrl() decodeUrl
     */
    public static function decodeUrl($string_, $avoidDoubleDecoding_=false)
    {
      return \str\decodeUrl($string_, $avoidDoubleDecoding_);
    }

    /**
     * @see \str\toNumber() toNumber
     */
    public static function toNumber($string_)
    {
      return \str\toNumber($string_);
    }

    /**
     * @see \str\toPhoneNumber() toPhoneNumber
     */
    public static function toPhoneNumber($string_, $convertMobileCountryCodeIdentifier_=false)
    {
      return \str\toPhoneNumber($string_, $convertMobileCountryCodeIdentifier_);
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
      if($length_>32 || $length_<8)
      {
        throw new Exception_IllegalArgument('string',
          'Value of password length must be between 7 and 33.'
        );
      }

      static $maxValues=[1=>60, 2=>80, 3=>90, 4=>100];

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
    public static function generateSerialNumber($length_=29, $lengthSegments_=5,
      $separatorSegments_='-', $asciiTable_=null)
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
     * @return integer[]
     */
    public static function asciiTable($type_=self::ASCII_TABLE_FULL)
    {
      if(isset(self::$m_asciiTable[$type_]))
        return self::$m_asciiTable[$type_];

      $table=[];
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
    //--------------------------------------------------------------------------


    // OVERRIDES/IMPLEMENTS
    /**
     * @see \Components\Cloneable::__clone() __clone
     */
    public function __clone()
    {
      return new self($this->m_value);
    }

    /**
     * @see \Components\Comparable::compareTo() compareTo
     */
    public function compareTo($object_)
    {
      if($object_ instanceof self)
        return \str\compare($this->m_value, $object_->m_value);

      if(is_scalar($object_) || method_exists([$object_, '__toString']))
        return \str\compare($this->m_value, (string)$object_);

      throw new Exception_IllegalCast('string', sprintf(
        'Can not compare to given parameter [%s].', $object_
      ));
    }

    /**
     * @see \Components\Object::hashCode() hashCode
     */
    public function hashCode()
    {
      return \math\hashs_fnv($this->m_value);
    }

    /**
     * @see \Components\Object::equals() equals
     */
    public function equals($object_)
    {
      if($object_ instanceof self)
        return \str\equals($this->m_value, $object_->m_value);

      return $this->m_value===$object_;
    }

    /**
     * @see \Components\Object::__toString() __toString
     */
    public function __toString()
    {
      return $this->m_value;
    }

    /**
     * @see \Components\Serializable::serialVersionUid() serialVersionUid
     */
    public function serialVersionUid()
    {
      return 1;
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    private static $m_asciiTable=[];
    //--------------------------------------------------------------------------
  }
?>
