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
    // [URL] File Transfer Protocol + SSL/TLS [generic syntax]
    const SCHEME_FTPS='ftps';
    // [URI] Local/Network Files [file:[//host]/path]
    const SCHEME_FILE='file';
    // [URN] Geographic Locations [geo:,<lat>,<lon>[,<alt>][;u=<uncertainty>]]
    const SCHEME_GEO='geo';
    // [URL] HyperText Transport Protocol [generic syntax]
    const SCHEME_HTTP='http';
    // [URL] HyperText Transport Protocol + SSL/TLS [generic syntax]
    const SCHEME_HTTPS='https';
    // [URL] Inter-Asterisk eXchange Protocol
    // [iax:[<username>@]<host>[:<port>][/<number>[?<context>]]]
    const SCHEME_IAX='iax';
    // [URN] Instant Messaging Protocol [im:<username>@<host>]
    const SCHEME_IM='im';
    // [URI] Internet Message Access Protocol
    // [imap://[<user>[;AUTH=<type>]@]<host>[:<port>]/<command>]
    const SCHEME_IMAP='imap';
    // [URI] Internet Message Access Protocol + SSL/TLS
    // [imaps://[<user>[;AUTH=<type>]@]<host>[:<port>]/<command>]
    const SCHEME_IMAPS='imaps';
    // [URI] Internet Printing Protocol []
    const SCHEME_IPP='ipp';
    // [URI] Internet Registry Information Service []
    const SCHEME_IRIS='iris';
    // [URI] Lightweight Directory Access Protocol
    // [ldap://[<host>[:<port>]][/<dn> [?[<attributes>][?[<scope>][?[<filter>][?<extensions>]]]]]]
    const SCHEME_LDAP='ldap';
    // [URI] Lightweight Directory Access Protocol + SSL/TLS
    // [ldaps://[<host>[:<port>]][/<dn> [?[<attributes>][?[<scope>][?[<filter>][?<extensions>]]]]]]
    const SCHEME_LDAPS='ldaps';
    // [URI] SMTP Mail Addresses & Default Contents
    // [mailto:<address>[?<subject>=<value>[&<body>=<value>]]]
    const SCHEME_MAILTO='mailto';
    // [URI] Network File System
    // [msrp:<user>[:<password>]@<host>[:<port>]/<session-id>;<transport>]
    const SCHEME_MSRP='msrp';
    // [URI] MySQL Database [generic syntax]
    const SCHEME_MYSQL='mysql';
    // [URI] Network File System [generic syntax]
    const SCHEME_NFS='nfs';
    // [URI] Usenet News Network Protocol
    // [nntp://<host>:<port>/<newsgroup-name>/<article-number>]
    const SCHEME_NNTP='nntp';
    // [URI] POP3 Mailbox Access Protocol
    // [pop://[<user>[;AUTH=<auth>]@]<host>[:<port>]]
    const SCHEME_POP='pop';
    // [URI] PostgreSQL Database [generic syntax]
    const SCHEME_POSTGRESQL='postgresql';
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
    // [URI] Secure File Transfer Protocol [generic syntax]
    const SCHEME_SFTP='sftp';
    // [URI] Windows File Sharing Protocol [generic syntax]
    const SCHEME_SMB='smb';
    // [URN] Compose & Send SMS [sms:<phone number>?<action>]
    const SCHEME_SMS='sms';
    // [URI] Simple Mail Transfer Protocol [smtp://recipient@mta[/parameters]
    const SCHEME_SMTP='smtp';
    // [URI] Simple Network Management Protocol
    // [snmp://[user@]host[:port][/[<context>[;<contextEngineID>]][/<oid>]]]
    const SCHEME_SNMP='snmp';
    // [URI] Secure Shell [generic syntax]
    const SCHEME_SSH='ssh';
    // [URI] Telnet [telnet://<user>:<password>@<host>[:<port>/]]
    const SCHEME_TELNET='telnet';
    // [URI] Trivial File Transfer Protocol [generic syntax]
    const SCHEME_TFTP='tftp';
    // [URN] Unified Resource Name
    // [urn:<namespace-identifier>:<namespace-specific-string>]
    const SCHEME_URN='urn';
    // URI[] XMPP Messenging Protocol [xmpp:<user>@<host>[:<port>]/[<resource>][?<query>]]
    const SCHEME_XMPP='xmpp';

    const PORT_DNS=53;
    const PORT_FTP=21;
    const PORT_FTPS=990;
    const PORT_HTTP=80;
    const PORT_HTTPS=443;
    const PORT_IMAP=143;
    const PORT_IMAPS=993;
    const PORT_LDAP=389;
    const PORT_LDAPS=636;
    const PORT_MYSQL=3306;
    const PORT_NNTP=119;
    const PORT_NNTPS=563;
    const PORT_POP=110;
    const PORT_POSTGRESQL=5432;
    const PORT_RSYNC=873;
    const PORT_RTSP=554;
    const PORT_SFTP=115;
    const PORT_SIP=5060;
    const PORT_SIPS=5061;
    const PORT_SMTP=25;
    const PORT_SNMP=61;
    const PORT_SSH=22;
    const PORT_TELNET=23;
    const PORT_TFTP=69;
    const PORT_XMPP=5222;
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

    /**
     * @param string $scheme_
     *
     * @return integer
     */
    public static function getPortForScheme($scheme_)
    {
      if(false===isset(self::$m_mapSchemePort[$scheme_]))
        return null;

      return self::$m_mapSchemePort[$scheme_];
    }

    /**
     * @param integer $port_
     *
     * @return string
     */
    public static function getSchemeForPort($port_)
    {
      if(false===isset(self::$m_mapPortScheme[$port_]))
        return null;

      return self::$m_mapPortScheme[$port_];
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    // TODO Complete mappings.
    private static $m_resourceIdentifierTypes=[
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
      self::SCHEME_MYSQL=>self::IDENTIFIER_URI,
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
    ];

    private static $m_mapSchemePort=[
      self::SCHEME_DNS=>self::PORT_DNS,
      self::SCHEME_FTP=>self::PORT_FTP,
      self::SCHEME_FTPS=>self::PORT_FTP,
      self::SCHEME_HTTP=>self::PORT_HTTP,
      self::SCHEME_HTTPS=>self::PORT_HTTPS,
      self::SCHEME_IMAP=>self::PORT_IMAP,
      self::SCHEME_IMAPS=>self::PORT_IMAPS,
      self::SCHEME_LDAP=>self::PORT_LDAP,
      self::SCHEME_LDAPS=>self::PORT_LDAPS,
      self::SCHEME_MYSQL=>self::PORT_MYSQL,
      self::SCHEME_NNTP=>self::PORT_NNTP,
      self::SCHEME_POP=>self::PORT_POP,
      self::SCHEME_POSTGRESQL=>self::PORT_POSTGRESQL,
      self::SCHEME_RSYNC=>self::PORT_RSYNC,
      self::SCHEME_RTSP=>self::PORT_RTSP,
      self::SCHEME_SFTP=>self::PORT_SFTP,
      self::SCHEME_SIP=>self::PORT_SIP,
      self::SCHEME_SMTP=>self::PORT_SMTP,
      self::SCHEME_SNMP=>self::PORT_SNMP,
      self::SCHEME_SSH=>self::PORT_SSH,
      self::SCHEME_TELNET=>self::PORT_TELNET,
      self::SCHEME_TFTP=>self::PORT_TFTP,
      self::SCHEME_XMPP=>self::PORT_XMPP
    ];

    private static $m_mapPortScheme=[
      self::PORT_DNS=>self::SCHEME_DNS,
      self::PORT_FTP=>self::SCHEME_FTP,
      self::PORT_FTPS=>self::SCHEME_FTP,
      self::PORT_HTTP=>self::SCHEME_HTTP,
      self::PORT_HTTPS=>self::SCHEME_HTTPS,
      self::PORT_IMAP=>self::SCHEME_IMAP,
      self::PORT_IMAPS=>self::SCHEME_IMAPS,
      self::PORT_LDAP=>self::SCHEME_LDAP,
      self::PORT_LDAPS=>self::SCHEME_LDAPS,
      self::PORT_MYSQL=>self::SCHEME_MYSQL,
      self::PORT_NNTP=>self::SCHEME_NNTP,
      self::PORT_POP=>self::SCHEME_POP,
      self::PORT_POSTGRESQL=>self::SCHEME_POSTGRESQL,
      self::PORT_RSYNC=>self::SCHEME_RSYNC,
      self::PORT_RTSP=>self::SCHEME_RTSP,
      self::PORT_SFTP=>self::SCHEME_SFTP,
      self::PORT_SIP=>self::SCHEME_SIP,
      self::PORT_SMTP=>self::SCHEME_SMTP,
      self::PORT_SNMP=>self::SCHEME_SNMP,
      self::PORT_SSH=>self::SCHEME_SSH,
      self::PORT_TELNET=>self::SCHEME_TELNET,
      self::PORT_TFTP=>self::SCHEME_TFTP,
      self::PORT_XMPP=>self::SCHEME_XMPP
    ];

    private static $m_resourceTypes=[];
    //--------------------------------------------------------------------------
  }
?>
