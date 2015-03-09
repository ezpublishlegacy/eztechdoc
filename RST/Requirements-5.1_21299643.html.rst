#. `eZ Publish Platform 5.x <index.html>`__
#. `eZ Publish Platform
   Documentation <eZ-Publish-Platform-Documentation_1114149.html>`__
#. `Installation and Upgrade
   Guides <Installation-and-Upgrade-Guides_6292016.html>`__
#. `Requirements <Requirements_7438502.html>`__

eZ Publish Platform 5.x : Requirements 5.1
==========================================

Created by andre.romcke@ez.no, last modified by
sarah.haim-lubczanski@ez.no on Oct 07, 2014

[ `Reference platforms <#Requirements5.1-Referenceplatforms>`__ ] [
`Supported non-reference stacks
(approved) <#Requirements5.1-Supportednon-referencestacks(approved)>`__
] [ `Compatible platforms <#Requirements5.1-Compatibleplatforms>`__ ] [
`Supported
browsers <#Requirements5.1-supportedbrowsersSupportedbrowsers>`__ ]

eZ Publish 5.1 is built to rely on existing technologies and standards,
mainly:

-  PHP scripting language
-  SQL database
-  Java JRE when eZ Find search engine is used

To answer the question "Is my platform supported by eZ Publish?",
several things must be taken into consideration. The following tables
gives you the details of the platform requirements for the latest eZ
Publish release.

Reference platforms
===================

The most safe and optimized stack for eZ Publish Platform. The stack is
supported and certified for eZ Publish Platform 5.1. This means that our
QA certification team has successfully run intensive certification tests
on the platform, and that we can fully support the platform in the scope
of an eZ Publish Subscription.

The reference stack for eZ Publish Platform 5.1 is based on Red Hat
Enterprise Linux 6. The detail of the stack can be seen in the table
below.

**Stack**

**Single mode & Cluster mode**

**OS**

-  RedHat RHEL 6.x

**Web Server**

-  Apache 2.2.15 (pre-fork mode) (rhel6 package)

**DBMS**

-  MySQL 5.1.61 (rhel62 packages)

**PHP (mod\_php) + PHP CLI**

-  Official PHP 5.3.3 (rhel62 packages)
-  Official PHP 5.4.x

**PHP + PHP CLI extensions**

-  APC 3.1.9 (external pecl extension)
-  bz2
-  curl
-  dom
-  exif
-  fileinfo
-  ftp
-  gd
-  iconv
-  json
-  mbstring
-  memcache (only needed for cluster mode)
-  mysqli
-  pcntl
-  pcre
-  pdo-mysql
-  posix
-  reflection
-  simplexml
-  spl
-  ssl
-  xmlreader
-  zlib
-  xml
-  libxml
-  xsl

**Graphic Handler**

-  ImageMagick 6.5.4.7

**Other**

-  OpenOffice 3.2.1-19
-  Java JRE 1.6 or higher (Oracle-Sun/OpenJDK) when eZ Find search
   engine is used

**eZ Publish extensions**

-  eZ Online Editor LS 5.1.0
-  eZ Website Interface LS 5.1.0
-  eZ Flow LS 5.1.0
-  eZ Find LS 5.1.0
-  eZ Google Maps Location LS 5.1.0
-  eZ Star Rating LS 5.1.0
-  eZ Website Toolbar LS 5.1.0
-  eZ Openoffice.org LS 5.1.0
-  eZ MB Password Expiry LS 5.1.0
-  eZ Multiupload LS 5.1.0
-  eZ Survey LS 5.1.0
-  eZ Comments LS 5.1.0
-  eZ JSCore LS 5.1.0
-  eZ Script Monitor LS 5.1.0
-  eZ SI LS 5.1.0
-  eZ Style Editor LS 5.1.0
-  eZ XML Export LS 5.1.0
-  eZ Image Editor LS 5.1.0
-  eZ Network LS 5.1.0
-  eZ Form Token LS 5.1.0
-  eZ Content Staging LS 5.1.0
-  eZ Autosave LS 5.1.0
-  eZ REST API Provider LS 5.1.0

**Cluster mode**

-  eZDFSFileHandler (mysqli) + Linux NFS
-  Persistence cache configured with Memcache
-  HTTP cache configured to use Varnish

**File system**

-  Linux ext4

Supported non-reference stacks (approved)
=========================================

These stacks are also tested, but not as extensively as our reference
stacks. These stacks still benefit from the full support and maintenance
guarantees provided with the eZ Publish Platform Subscription, but more
issues might occur during normal operations, performance might be lower
and issues take longer to resolve.

The supported non-reference stacks for eZ Publish Platform 5.1 are:

-  SUSE Linux Enterprise Server 11 SP2(\*\*)
-  Debian 6 

The detail of the stacks can be seen in the table below.

 

**Single Mode**

**Cluster Mode**

**Operating system**

-  Debian 6
-  SUSE Linux Enterprise Server (SLES) 11 SP2(\*\*)

-  Debian 6
-  SUSE Linux Enterprise Server (SLES) 11 SP2(\*\*)

**Web Server**

-  Apache 2.2.x (prefork mode)

-  Apache 2.2.x (prefork mode)

**DBMS**

-  MySQL 5.0.x or 5.1.x
-  PostgreSQL 8.4

-  MySQL 5.0.x or 5.1.x

**PHP (mod\_php) + PHP CLI + apache**

-  PHP 5.3.x
-  PHP 5.4.x

-  PHP 5.3.x
-  PHP 5.4.x

**PHP**

-  APC 3.1.9 (external pecl extension)
-  bz2
-  curl
-  dom
-  exif
-  fileinfo
-  ftp
-  gd
-  iconv
-  json
-  mbstring
-  mysqli
-  oci8
-  pcntl
-  pcre
-  pdo-mysql
-  pdo-pgsql
-  pgsql
-  posix
-  reflection
-  simplexml
-  spl
-  ssl
-  xmlreader
-  zlib
-  xml
-  libxml
-  xsl

-  APC 3.1.9 (external pecl extension)
-  bz2
-  curl
-  dom
-  exif
-  fileinfo
-  ftp
-  gd
-  iconv
-  json
-  memcached
-  mbstring
-  mysqli
-  oci8
-  pcntl
-  pcre
-  pdo-mysql
-  pdo-pgsql
-  pgsql
-  posix
-  reflection
-  simplexml
-  spl
-  ssl
-  xmlreader
-  zlib
-  xml
-  libxml
-  xsl

**Graphic Handler**

-  ImageMagick >= 6.4.x
-  GD2 ( PHP extension )

-  ImageMagick >= 6.4.x
-  GD2 ( PHP extension )

**eZ Publish extensions**

-  eZ Online Editor LS 5.1.0
-  eZ Website Interface LS 5.1.0
-  eZ Flow LS 5.1.0
-  eZ Find LS 5.1.0
-  eZ Google Maps Location LS 5.1.0
-  eZ Star Rating LS 5.1.0
-  eZ Website Toolbar LS 5.1.0
-  eZ Openoffice.org LS 5.1.0
-  eZ MB Password Expiry LS 5.1.0
-  eZ Multiupload LS 5.1.0
-  eZ Survey LS 5.1.0
-  eZ Comments LS 5.1.0
-  eZ JSCore LS 5.1.0
-  eZ Script Monitor LS 5.1.0
-  eZ SI LS 5.1.0
-  eZ Style Editor LS 5.1.0
-  eZ XML Export LS 5.1.0
-  eZ Image Editor LS 5.1.0
-  eZ Network LS 5.1.0
-  eZ Form Token LS 5.1.0
-  eZ Content Staging LS 5.1.0
-  eZ Autosave LS 5.1.0
-  eZ REST API Provider LS 5.1.0

-  eZ Online Editor LS 5.1.0
-  eZ Website Interface LS 5.1.0
-  eZ Flow LS 5.1.0
-  eZ Find LS 5.1.0
-  eZ Google Maps Location LS 5.1.0
-  eZ Star Rating LS 5.1.0
-  eZ Website Toolbar LS 5.1.0
-  eZ Openoffice.org LS 5.1.0
-  eZ MB Password Expiry LS 5.1.0
-  eZ Multiupload LS 5.1.0
-  eZ Survey LS 5.1.0
-  eZ Comments LS 5.1.0
-  eZ JSCore LS 5.1.0
-  eZ Script Monitor LS 5.1.0
-  eZ SI LS 5.1.0
-  eZ Style Editor LS 5.1.0
-  eZ XML Export LS 5.1.0
-  eZ Image Editor LS 5.1.0
-  eZ Network LS 5.1.0
-  eZ Form Token LS 5.1.0
-  eZ Content Staging LS 5.1.0
-  eZ Autosave LS 5.1.0
-  eZ REST API Provider LS 5.1.0

**Cluster mode**

 

-  eZDFSFileHandler (mysqli) + Linux NFS
-  Persistence cache configured with Memcache[d]
-  HTTP cache configured to use Varnish

**Filesystem**

-  Linux ext3 / ext4

-  Linux ext3 / ext4

 \*\* Issues have been identified with the SLES 11 SP2 in regards of the
PHP stack. eZ Systems can not provide a workaround and the
only recommendation is to wait for a new service pack for SLES.

Compatible platforms
====================

eZ Publish can run and execute on many more platforms than the ones
listed above, including (but not limited to) the following operating
systems if they pass the
`Symfony requirements <http://symfony.com/doc/current/reference/requirements.html>`__:

-  Solaris 
-  Opensolaris
-  Windows 2000/XP/Vista/7/2008 (only on legacy stack or legacy mode)
-  Mac OSX server

However, eZ Systems doesn't insure and guarantee quality operation of an
eZ Publish Platform installation if it is running on any platform not
listed as supported. eZ Publish Enterprise Subscriptions are still
available for compatible platforms, but the guarantee and the product
support will not apply and although you will receive various maintenance
releases and services, no bug fix guarantee will apply to issues related
to the platform. Maintenance and monitoring tools will not be available.
eZ Systems does not advise merely compatible platforms for production
use.

Supported browsers
==================

eZ Publish is developed to work properly and support the following
browser configurations for administrator users:

-  Firefox: Latest stable version. Tested on Firefox 16. 
-  Google Chrome: Latest stable version. Tested on Chrome 21”
-  Internet Explorer: 8 & 9. Tested on IE 9
-  Safari: 6. Tested on Safari 6.0 on Mac OSX 10.8

Please note that the interface will display and behave optimally in any
browser that supports HTML 5.0, CSS 3.0 and ECMAScript 5. If
these technologies are not supported the system will gracefully appear
with simpler design/layout but will still be accessible through
standard/default HTML elements.

 

Document generated by Confluence on Mar 03, 2015 15:12
