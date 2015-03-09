#. `eZ Publish Platform 5.x <index.html>`__
#. `eZ Publish Platform
   Documentation <eZ-Publish-Platform-Documentation_1114149.html>`__
#. `Installation and Upgrade
   Guides <Installation-and-Upgrade-Guides_6292016.html>`__
#. `Requirements <Requirements_7438502.html>`__

eZ Publish Platform 5.x : Requirements 5.3
==========================================

Created and last modified by andre.romcke@ez.no on Jan 06, 2015

[ `Requirements <#Requirements5.3-Requirements>`__ ] [ `Supported
stacks <#Requirements5.3-Supportedstacks>`__ ] [ `Reference
Stack <#Requirements5.3-ReferenceStack>`__ ] [ `Approved
stacks <#Requirements5.3-Approvedstacks>`__ ] [ `Compatible
platforms <#Requirements5.3-Compatibleplatforms>`__ ] [ `Supported
browsers <#Requirements5.3-supportedbrowsersSupportedbrowsers>`__ ]

Requirements
============

eZ Publish software is built to rely on existing technologies and
standards, mainly:

-  PHP scripting language (5.3/5.4/5.5, minimum 5.3.3)

-  SQL database (MySql or Postgres)

-  XHTML version 1.0 / HTML 5

-  XML 1.0

-  Java JRE 1.7 (Oracle-Sun/OpenJDK) when Solr is used (by eZ Find
   search engine and/or Preview if the new Solr search handler for API)

These are the main components, for more details, please consult
documentation for in-depth information.

To answer the question "Is my platform supported by eZ Publish", several
things must be taken into consideration to determining whether a
platform is supported or not, and how. The following tables gives you
the details of the platform requirements for the latest eZ Publish
release.

Supported stacks
----------------

Reference Stack
~~~~~~~~~~~~~~~

The most safe stack for eZ Publish Platform. The stack is supported and
certified for eZ Publish Platform 5. This means that our QA
certification team has successfully run intensive certification tests on
the platform, and that we can fully support the platform in the scope of
an eZ Publish Subscription.

The reference stack for eZ Publish Platform 5 is based on Red Hat
Enterprise Linux 6. The detail of the stack can be seen in the table
below.

 

**Stack**

RHEL

**OS**

-  Red Hat RHEL 6.x latests stable (tested on 6.5)

**Web Server**

-  Apache 2.2.15 (pre-fork mode) (rhel6 package)

**Symfony Web Framework (\* )**

-  Latest stable version of Symfony 2.3.x with Twig

**DBMS**

-  MySQL 5.1 (rhel6 package)

**PHP (mod\_php) + PHP CLI**

-  PHP 5.3.3 (rhel6 packages)

**PHP + PHP CLI extensions**

-  APC 3.1.9 (rhel6 packages)
-  bz2
-  Curl
-  dom
-  exif
-  fileinfo
-  ftp
-  gd
-  Iconv
-  json
-  mbstring
-  [STRIKEOUT:memcache] -> memcached (only for cluster mode, see `5.3.4
   Release notes (#3) <5.3.4-Release-Notes_25985326.html>`__)
-  Database:

   -  MySQL:

      -  mysqli (LS)
      -  pdo-mysql (5.x)

-  pecl\_http

   -  Required by ezphttprequest used by ezodoscope & ezrecommender

-  pcntl
-  pcre
-  posix
-  reflection
-  simplexml
-  spl
-  ssl
-  xmlreader
-  xsl
-  zlib
-  php-intl

**Graphic Handler**

-  ImageMagick 6.5.4 (rhel6 packages)

**Other**

-  OpenOffice 3.2.1 (rhel6 packages)

**eZ Publish extensions**

-  eZ Online Editor LS 5.3.0
-  eZ Website Interface LS 5.3.0
-  eZ Flow LS 5.3.0
-  eZ Find LS 5.3.0
-  eZ Google Maps Location LS 5.3.0
-  eZ Star Rating LS 5.3.0
-  eZ Website Toolbar LS 5.3.0
-  eZ Openoffice.org LS 5.3.0
-  eZ MB Password Expiry LS 5.3.0
-  eZ Multiupload LS 5.3.0
-  eZ Survey LS 5.3.0
-  eZ JSCore LS 5.3.0
-  eZ Script Monitor LS 5.3.0
-  eZ SI LS 5.3.0
-  eZ Style Editor LS 5.3.0
-  eZ XML Export LS 5.3.0
-  eZ Image Editor LS 5.3.0
-  eZ Network LS 5.3.0
-  eZ Form Token LS 5.3.0
-  eZ Content Staging LS 5.3.0
-  eZ Autosave LS 5.3.0
-  eZ REST API Provider LS 5.3.0

**Cluster mode**

-  eZDFSFileHandler (mysqli) + Linux NFS
-  Persistence cache configured with Memcache
-  HTTP cache configured to use Varnish

**File system**

-  Linux ext4

Approved stacks
~~~~~~~~~~~~~~~

These stacks are also tested, however not as extensively as our
reference stack. These stacks still benefit from the full support and
maintenance guarantees provided with the eZ Publish Platform
Subscription, but more issues might occur during normal operations and
issues might take longer to resolve. However these setups will most
likely give you noticeable more performance than the stock packages
provided by RHEL 6.x currently, especially if MySql 5.6 or MariaDB 5.5
is used.

The supported non-reference stacks for eZ Publish Platform 5 are mainly:

-  **Debian**
-  **Ubuntu**
-  **CentOS** (with same packages as reference platform above)

The details of the approved stacks can be seen in the table below,
everything uses officially packages unless mentioned otherwise. 

 

Debian

Ubuntu

**Operating system**

-  Debian 7

-  Ubuntu 14.04LTS

**Web Server**

-  Apache 2.2.x (prefork mode)

-  Nginx 1.4.x
-  Apache 2.4 (prefork mode)

**Symfony Web Framework (\* )**

-  Latest stable version of Symfony 2.3.x with Twig

-  Latest stable version of Symfony 2.3.x with Twig

**DBMS**

-  MySQL 5.5.x
-  PostgreSQL 9.x

-  MySQL 5.6
-  MariaDB 5.5

**PHP (mod\_php) + PHP CLI + apache**

-  PHP 5.4.4

-  PHP 5.5.9 (php5-fpm on Nginx, libapache2-mod-php5 on Apache)

**PHP**

-  APC 3.1.13-1 (tested with Debain package)
-  bz2
-  Curl
-  dom
-  exif
-  fileinfo
-  ftp
-  gd
-  Iconv
-  json
-  mbstring
-  memcached (only for cluster mode)
-  Database:

   -  MySQL:

      -  mysqli (LS)
      -  pdo-mysql (5.x)

   -  Postgres:

      -  pgsql (LS)
      -  pdo-pgsql (5.x)

-  pecl\_http

   -  Required by ezphttprequest used by ezodoscope & ezrecommender

-  pcntl
-  pcre
-  posix
-  reflection
-  simplexml
-  spl
-  ssl
-  xmlreader
-  xsl
-  zlib
-  php-intl

-  bz2
-  Curl
-  dom
-  exif
-  fileinfo
-  ftp
-  gd
-  Iconv
-  json
-  mbstring
-  memcached (only for cluster mode)
-  Database:
-  MySQL:

   -  mysqli (LS)
   -  pdo-mysql (5.x)

-  pecl\_http

   -  Required by ezphttprequest used by ezodoscope & ezrecommender

-  pcntl
-  pcre
-  posix
-  reflection
-  simplexml
-  spl
-  ssl
-  xmlreader
-  xsl
-  zlib
-  php-intl

**Graphic Handler**

-  ImageMagick >= 6.4.x
-  GD2 ( PHP extension )

**eZ Publish extensions**

-  Same as Reference platform (see above)

**Cluster mode**

-  eZDFSFileHandler (mysqli) + Linux NFS
-  Persistence cache configured with Memcache[d]
-  HTTP cache configured to use Varnish

**Filesystem**

-  Linux ext3 / ext4

| \*: to ease developer and administrator life, the latest stable
version of the Symfony framework is bundled with the eZ Publish release.
| eZ support eZ Publish only when used with the latest maintenance
version of Symfony within the version specified above, new maintenance
versions are announced
by \ `Symfony <http://symfony.com/blog/category/releases>`__ and
provided via composer. Symfony is not supported directly by eZ within eZ
Publish Enterprise Subscriptions, however contact your eZ Systems
representative for alternatives.

Compatible platforms
--------------------

eZ Publish can run and execute on many more platforms than the ones
listed above, including (but not limited to) the operating systems
listing below if they pass the \ `Symfony
requirements <http://symfony.com/doc/current/reference/requirements.html>`__, and
using cache solutions technically supported by
`Stash <http://www.stashphp.com/Drivers.html>`__.

**However, eZ Systems doesn't insure and guarantee quality operation of
an eZ Publish Platform installation if it is running on any platform not
listed as supported.** eZ Publish Enterprise Subscriptions are still
available for compatible platforms, but the guarantee and the product
support will not apply and although you will receive various maintenance
releases and services, no bug fix guarantee will apply to issues related
to the platform. Maintenance and monitoring tools will not be available.
eZ Systems does not advise merely compatible platforms for production
use.

Compatible platform:

-  Most Linux operating system (Fedora, Arc, CoreOs...)
-  Solaris
-  OpenSolaris
-  Windows Vista/7/2008 (some issue might occur related to third party
   composer libraries, contact these for fixes if that is the case)
-  Mac OS X server 

Supported browsers
==================

eZ Publish is developed to work properly and support the following
browser configurations for administrator users:

-  Mozilla® Firefox®, most recent stable version (tested on Firefox 29).
   eZ makes every effort to test and support the most recent version of
   Firefox. 

-  Google Chrome™, most recent stable version (tested on
   chrome 35). Chrome applies updates automatically; eZ makes every
   effort to test and support the most recent version.

-  Microsoft® Internet Explorer® versions 9, 10 and 11. We recommend
   using the latest version (11).

-  Apple® Safari® 6.2 / 7.0 on Mac OS X. Apple Safari on iOS isn’t
   supported for admin backend.

Please note that the user interface will display and behave optimally in
any browser that supports HTML 5, CSS 3 and ECMAScript 5. If these
technologies are not supported the system will gracefully appear with
simpler design/layout but will still be accessible through
standard/default HTML elements.

 

Comments:
---------

+--------------------------------------------------------------------------+
| Ezpublish is not compatible with MariaDB. Numbering is different in      |
| MariaDb and that produce a warning.Epublish consider it as a fatal       |
| error.                                                                   |
|                                                                          |
| |image2| Posted by ext.bor at Aug 18, 2014 13:07                         |
+--------------------------------------------------------------------------+
| Which version are you using, from where, how are your mariadb settings   |
| configured, and which part of eZ Publish are you using to reproduce      |
| this?                                                                    |
|                                                                          |
| In other words, please report this in the `issue                         |
| tracker <https://jira.ez.no/secure/Dashboard.jspa>`__. As this page      |
| states we support MariaDB 5.5 as of version 5.3+ / 2014.05+, if that is  |
| not the case then we have ourselves an issue.                            |
|                                                                          |
| |image3| Posted by andre.romcke@ez.no at Aug 18, 2014 13:32              |
+--------------------------------------------------------------------------+

Document generated by Confluence on Mar 03, 2015 15:12

.. |image0| image:: images/icons/contenttypes/comment_16.png
.. |image1| image:: images/icons/contenttypes/comment_16.png
.. |image2| image:: images/icons/contenttypes/comment_16.png
.. |image3| image:: images/icons/contenttypes/comment_16.png
