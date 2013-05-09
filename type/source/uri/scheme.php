<?php


namespace Components;


  /**
   * Uri_Scheme
   *
   * @package net.evalcode.components
   * @subpackage type.uri
   *
   * @author evalcode.net
   */
  class Uri_Scheme
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
    const IMPL_URI='Components\\Uri';
    const IMPL_URN='Components\\Urn';

    const IMPL_GENERIC=self::IMPL_URI;
    //--------------------------------------------------------------------------


    // STATIC ACCESSORS
    /**
     * @param string $scheme_
     *
     * @return string
     */
    public static function getImplTypeForScheme($scheme_)
    {
      if(isset(self::$m_implementations[$scheme_]))
        return self::$m_implementations[$scheme_];

      return self::IMPL_GENERIC;
    }
    //--------------------------------------------------------------------------


    // IMPLEMENTATION
    private static $m_implementations=array(
      self::SCHEME_AFP=>self::IMPL_GENERIC,
      self::SCHEME_AIM=>self::IMPL_GENERIC,
      self::SCHEME_APT=>self::IMPL_GENERIC,
      self::SCHEME_BITCOIN=>self::IMPL_GENERIC,
      self::SCHEME_CALLTO=>self::IMPL_GENERIC,
      self::SCHEME_CID=>self::IMPL_GENERIC,
      self::SCHEME_DAV=>self::IMPL_GENERIC,
      self::SCHEME_DICT=>self::IMPL_GENERIC,
      self::SCHEME_DNS=>self::IMPL_GENERIC,
      self::SCHEME_FILE=>self::IMPL_GENERIC,
      self::SCHEME_FTP=>self::IMPL_GENERIC,
      self::SCHEME_GEO=>self::IMPL_GENERIC,
      self::SCHEME_HTTP=>self::IMPL_GENERIC,
      self::SCHEME_HTTPS=>self::IMPL_GENERIC,
      self::SCHEME_IAX=>self::IMPL_GENERIC,
      self::SCHEME_IM=>self::IMPL_GENERIC,
      self::SCHEME_IMAP=>self::IMPL_GENERIC,
      self::SCHEME_IPP=>self::IMPL_GENERIC,
      self::SCHEME_IRIS=>self::IMPL_GENERIC,
      self::SCHEME_LDAP=>self::IMPL_GENERIC,
      self::SCHEME_MAILTO=>self::IMPL_GENERIC,
      self::SCHEME_MSRP=>self::IMPL_GENERIC,
      self::SCHEME_NFS=>self::IMPL_GENERIC,
      self::SCHEME_NNTP=>self::IMPL_GENERIC,
      self::SCHEME_POP=>self::IMPL_GENERIC,
      self::SCHEME_RSYNC=>self::IMPL_GENERIC,
      self::SCHEME_RTSP=>self::IMPL_GENERIC,
      self::SCHEME_SIP=>self::IMPL_GENERIC,
      self::SCHEME_SIPS=>self::IMPL_GENERIC,
      self::SCHEME_SMB=>self::IMPL_GENERIC,
      self::SCHEME_SMS=>self::IMPL_GENERIC,
      self::SCHEME_SNMP=>self::IMPL_GENERIC,
      self::SCHEME_TELNET=>self::IMPL_GENERIC,
      self::SCHEME_TFTP=>self::IMPL_GENERIC,
      self::SCHEME_URN=>self::IMPL_URN,
      self::SCHEME_XMPP=>self::IMPL_GENERIC
    );
    //--------------------------------------------------------------------------
  }
?>
