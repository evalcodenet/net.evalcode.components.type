<?php


namespace Components;


  /**
   * Resource_Type
   *
   * @api
   * @package net.evalcode.components.type
   * @subpackage resource
   *
   * @author evalcode.net
   */
  class Resource_Type
  {
    // SUPPORTED PROTOCOL IDENTIFIER SCHEMES <CLASSIFICATION> <NAME> <SYNTAX>
    // [URI] Apple Filing Protocol [afp://[<user>@]<host>[:<port>][/[<path>]]]
    const SCHEME_AFP='afp';
    // [URN] AOL Instant Messenger [aim:<function>?<parameters>]
    const SCHEME_AIM='aim';
    // [URN] Install Software via Debian/APT [apt:<package name>]
    const SCHEME_APT='apt';
    // [URI] Send Money to Bitcoin Address
    // [bitcoin:<address>[?[amount=<size>][&][label=<label>][&][message=<message>]]]
    const SCHEME_BITCOIN='bitcoin';
    // [URN] Launch Skype Call [callto:<phonenumber|screenname>]
    const SCHEME_CALLTO='callto';
    // [URN] SMTP/MIME Message Content Identifier [cid:<content-id>]
    const SCHEME_CID='cid';
    // [URL] WebDAV [generic syntax]
    const SCHEME_DAV='dav';
    // [URI] Dictionary Service Protocol
    // [dict://<user>;<auth>@<host>:<port>/d:<word>:<database>:<n>]
    const SCHEME_DICT='dict';
    // [URI] Domain Name System [dns:[//host[:port]/]<dnsname>[?<dnsquery>]]
    const SCHEME_DNS='dns';
    // [URL] File Transfer Protocol [generic syntax]
    const SCHEME_FTP='ftp';
    // [URI] Local/Network Files [file:[//host]/path]
    const SCHEME_FILE='file';
    // [URN] Geographic Locations [geo:,<lat>,<lon>[,<alt>][;u=<uncertainty>]]
    const SCHEME_GEO='geo';
    // [URL] HTTP [generic syntax]
    const SCHEME_HTTP='http';
    // [URL] HTTP+SSL/TLS [generic syntax]
    const SCHEME_HTTPS='https';
    // [URL] Inter-Asterisk eXchange Protocol
    // [iax:[<username>@]<host>[:<port>][/<number>[?<context>]]]
    const SCHEME_IAX='iax';
    // [URN] Instant Messaging Protocol [im:<username>@<host>]
    const SCHEME_IM='im';
    // [URI] IMAP [imap://[<user>[;AUTH=<type>]@]<host>[:<port>]/<command>]
    const SCHEME_IMAP='imap';
    // [URI] Internet Printing Protocol []
    const SCHEME_IPP='ipp';
    // [URI] Internet Registry Information Service []
    const SCHEME_IRIS='iris';
    // [URI] Lightweight Directory Access Protocol
    // [ldap://[<host>[:<port>]][/<dn> [?[<attributes>][?[<scope>][?[<filter>][?<extensions>]]]]]]
    const SCHEME_LDAP='ldap';
    // [URI] SMTP Mail Addresses & Default Contents
    // [mailto:<address>[?<subject>=<value>[&<body>=<value>]]]
    const SCHEME_MAILTO='mailto';
    // [URI] Network File System
    // [msrp:<user>[:<password>]@<host>[:<port>]/<session-id>;<transport>]
    const SCHEME_MSRP='msrp';
    // [URI] Network File System [generic syntax]
    const SCHEME_NFS='nfs';
    // [URI] Usenet News Network Protocol
    // [nntp://<host>:<port>/<newsgroup-name>/<article-number>]
    const SCHEME_NNTP='nntp';
    // [URI] POP3 Mailbox Access Protocol
    // [pop://[<user>[;AUTH=<auth>]@]<host>[:<port>]]
    const SCHEME_POP='pop';
    // [URI] rsync [rsync://<host>[:<port>]/<path>]
    const SCHEME_RSYNC='rsync';
    // [URI] Real Time Streaming Protocol []
    const SCHEME_RTSP='rtsp';
    // [URI] Session Initiation Protocol
    // [sip:<user>[:<password>]@<host>[:<port>][;<uri-parameters>][?<headers>]]
    const SCHEME_SIP='sip';
    // [URI] Secure Session Initiation Protocol
    // [sips:<user>[:<password>]@<host>[:<port>][;<uri-parameters>][?<headers>]]
    const SCHEME_SIPS='sips';
    // [URI] Windows File Sharing Protocol [generic syntax]
    const SCHEME_SMB='smb';
    // [URN] Compose & Send SMS [sms:<phone number>?<action>]
    const SCHEME_SMS='sms';
    // [URI] Simple Network Management Protocol
    // [snmp://[user@]host[:port][/[<context>[;<contextEngineID>]][/<oid>]]]
    const SCHEME_SNMP='snmp';
    // [URI] Telnet [telnet://<user>:<password>@<host>[:<port>/]]
    const SCHEME_TELNET='telnet';
    // [URI] Trivial File Transfer Protocol []
    const SCHEME_TFTP='tftp';
    // [URN] Unified Resource Name
    // [urn:<namespace-identifier>:<namespace-specific-string>]
    const SCHEME_URN='urn';
    // URI[] XMPP Messenging Protocol [xmpp:<user>@<host>[:<port>]/[<resource>][?<query>]]
    const SCHEME_XMPP='xmpp';
    //--------------------------------------------------------------------------


    // PROTOCOL IDENTIFIER IMPLEMENTATIONS
    const IDENTIFIER_URI='Components\\Uri';
    const IDENTIFIER_URN='Components\\Urn';
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * @param string $scheme_
     *
     * @return string
     */
    public static function getResourceIdentifierTypeForScheme($scheme_)
    {
      if(false===isset(self::$m_resourceIdentifierTypes[$scheme_]))
        return null;

      return self::$m_resourceIdentifierTypes[$scheme_];
    }

    /**
     * @param string $scheme_
     * @param string $resourceIdentifierType_
     */
    public static function registerResourceIdentifierType($scheme_, $resourceIdentifierType_)
    {
      self::$m_resourceIdentifierTypes[$scheme_]=$resourceIdentifierType_;
    }

    /**
     * @param string $scheme_
     *
     * @return string
     */
    public static function getResourceTypeForScheme($scheme_)
    {
      if(false===isset(self::$m_resourceTypes[$scheme_]))
        return null;

      return self::$m_resourceTypes[$scheme_];
    }

    /**
     * @param string $scheme_
     * @param string $resourceType_
     */
    public static function registerResourceType($scheme_, $resourceType_)
    {
      self::$m_resourceTypes[$scheme_]=$resourceType_;
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    private static $m_resourceTypes=array();

    private static $m_resourceIdentifierTypes=array(
      self::SCHEME_AFP=>self::IDENTIFIER_URI,
      self::SCHEME_AIM=>self::IDENTIFIER_URI,
      self::SCHEME_APT=>self::IDENTIFIER_URI,
      self::SCHEME_BITCOIN=>self::IDENTIFIER_URI,
      self::SCHEME_CALLTO=>self::IDENTIFIER_URI,
      self::SCHEME_CID=>self::IDENTIFIER_URI,
      self::SCHEME_DAV=>self::IDENTIFIER_URI,
      self::SCHEME_DICT=>self::IDENTIFIER_URI,
      self::SCHEME_DNS=>self::IDENTIFIER_URI,
      self::SCHEME_FILE=>self::IDENTIFIER_URI,
      self::SCHEME_FTP=>self::IDENTIFIER_URI,
      self::SCHEME_GEO=>self::IDENTIFIER_URI,
      self::SCHEME_HTTP=>self::IDENTIFIER_URI,
      self::SCHEME_HTTPS=>self::IDENTIFIER_URI,
      self::SCHEME_IAX=>self::IDENTIFIER_URI,
      self::SCHEME_IM=>self::IDENTIFIER_URI,
      self::SCHEME_IMAP=>self::IDENTIFIER_URI,
      self::SCHEME_IPP=>self::IDENTIFIER_URI,
      self::SCHEME_IRIS=>self::IDENTIFIER_URI,
      self::SCHEME_LDAP=>self::IDENTIFIER_URI,
      self::SCHEME_MAILTO=>self::IDENTIFIER_URI,
      self::SCHEME_MSRP=>self::IDENTIFIER_URI,
      self::SCHEME_NFS=>self::IDENTIFIER_URI,
      self::SCHEME_NNTP=>self::IDENTIFIER_URI,
      self::SCHEME_POP=>self::IDENTIFIER_URI,
      self::SCHEME_RSYNC=>self::IDENTIFIER_URI,
      self::SCHEME_RTSP=>self::IDENTIFIER_URI,
      self::SCHEME_SIP=>self::IDENTIFIER_URI,
      self::SCHEME_SIPS=>self::IDENTIFIER_URI,
      self::SCHEME_SMB=>self::IDENTIFIER_URI,
      self::SCHEME_SMS=>self::IDENTIFIER_URI,
      self::SCHEME_SNMP=>self::IDENTIFIER_URI,
      self::SCHEME_TELNET=>self::IDENTIFIER_URI,
      self::SCHEME_TFTP=>self::IDENTIFIER_URI,
      self::SCHEME_URN=>self::IDENTIFIER_URN,
      self::SCHEME_XMPP=>self::IDENTIFIER_URI
    );
    //--------------------------------------------------------------------------
  }
?>
