#. `eZ Publish Platform 5.x <index.html>`__
#. `eZ Publish Platform
   Documentation <eZ-Publish-Platform-Documentation_1114149.html>`__
#. `Installation and Upgrade
   Guides <Installation-and-Upgrade-Guides_6292016.html>`__
#. `Requirements <Requirements_7438502.html>`__

eZ Publish Platform 5.x : Requirements 5.4
==========================================

Created and last modified by andre.romcke@ez.no on Feb 26, 2015

Server Requirements
===================

eZ Publish software is built to rely on existing technologies and
standards, mainly:

-  | PHP scripting language: (5.4/5.5/5.6, minimum 5.4.4)

-  SQL database: MySql/MariaDB or PostgreSQL

-  Web Server: Apache 2.2, Apache 2.4 or Nginx 1.4+

-  Java JRE 1.7 (Oracle-Sun/OpenJDK) when Solr is used (for use with eZ
   Find search engine)

These are the main components, for more details, please consult
documentation for in-depth information.

To answer the question "Is my platform supported by eZ Publish", several
things must be taken into consideration to determining whether a
platform is supported or not, and how. The following tables gives you
the details of the platform requirements for the latest eZ Publish
release.

Professionally Supported stacks
-------------------------------

While eZ Publish Platform can support a lot of technologies technically
via it's use of third-party libraries, a subset of these are chosen to
be professionally supported by eZ Systems, meaning eZ takes
responsibility on these third party libraries together with their
communities to make sure they work well with eZ Publish Platform within
the scope of what is documented to be supported below.

Reference Stack
~~~~~~~~~~~~~~~

The most safe stack for eZ Publish Platform. The stack is supported and
certified for eZ Publish Platform 5. This means that our QA
certification team has successfully run intensive certification tests on
the platform, and that we can fully support the platform in the scope of
an eZ Publish Subscription.

The reference stack for eZ Publish Platform 5 is based on Red Hat
Enterprise Linux (RHEL) and CentOS. The detail of the stack can be seen
in the table below.

 

**Stack**

RHEL/CentOS

**OS**

-  RHEL / CentOS 7.x latests stable (tested on 7.0)

**Web Server**

-  Apache 2.4.6 (RHEL/CentOS package, pre-fork mode)

**Symfony Web Framework (\* )**

-  Latest stable version of Symfony\ [STRIKEOUT:2.5.x] 2.6 *(as of
   5.4.1)* with Twig
   *Note: 5.4 will be updated to Symfony 2.7 LTS in Spring/Summer 2015!*

**DBMS**

-  MariaDB 5.5.35 (RHEL/CentOS package)

**PHP (mod\_php) + PHP CLI**

-  PHP 5.4.16 (RHEL/CentOS package)

**PHP + PHP CLI extensions**

-  ZendOpCache 2.2.x (PECL package)
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
-  memcached (PECL package, only for cluster mode)
-  Database:

   -  MySQL/MariaDB:

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

-  ImageMagick (RHEL/CentOS packages)

**Other**

-  LibreOffice 4.x (RHEL/CentOS packages, needed for ezodf)

**eZ Publish extensions**

-  eZ Online Editor LS 5.4.0
-  eZ Website Interface LS 5.3.0\*
-  eZ Flow LS 5.3.0\*
-  eZ Find LS 5.4.0
-  eZ Google Maps Location LS 5.3.0\*
-  eZ Star Rating LS 5.3.0\*
-  eZ Website Toolbar LS 5.3.0\*
-  eZ Openoffice.org LS 5.3.0\*
-  eZ MB Password Expiry LS 5.3.0\*
-  eZ Multiupload LS 5.3.0\*
-  eZ Survey LS 5.3.0\*
-  eZ JSCore LS 5.4.0
-  eZ Script Monitor LS 5.3.0\*
-  eZ SI LS 5.3.0\*
-  eZ Style Editor LS 5.3.0\*
-  eZ XML Export LS 5.3.0\*
-  eZ Image Editor LS 5.3.0\*
-  eZ Network LS 5.4.0
-  eZ Form Token LS 5.4.0
-  eZ Content Staging LS 5.3.0\*
-  eZ Autosave LS 5.3.0\*
-  eZ REST API Provider LS 5.3.0\*

:sup:`:sub:`\\\* eZ Publish Platform 5.4 is supported in parallel with
5.3, reusing all extensions that have not changed since 5.3.``

**Cluster mode**

-  eZDFSFileHandler (mysqli) + Linux NFS
-  Persistence cache configured with Memcached
-  HTTP cache configured to use Varnish

**File system**

-  Linux ext4

Approved stacks
~~~~~~~~~~~~~~~

These stacks are also tested, however not as extensively as our
reference stack. These stacks still benefit from the full support and
maintenance guarantees provided with the eZ Publish Platform
Subscription, but more issues might occur during normal operations and
issues might in some cases take longer to resolve. However some of these
more recent setups might give you some more performance than the
standard reference platform.

The supported non-reference stacks for eZ Publish Platform 5 are mainly:

-  **Debian**
-  **Ubuntu**

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

-  

   -  *See Reference Stack*

-  

   -  *See Reference Stack*

**DBMS**

-  MySQL 5.5.x
-  PostgreSQL 9.x

-  MySQL 5.6
-  MariaDB 5.5

**PHP (mod\_php) + PHP CLI + apache**

-  PHP 5.4.4

-  PHP 5.5.9 (php5-fpm on Nginx, libapache2-mod-php5 on Apache)

**PHP**

-  APC 3.1.13-1 (Debain package)
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

   -  PostgreSQL:

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
-  Persistence cache configured with Memcached
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

Community Supported stacks
--------------------------

 

eZ Publish can theoretically run and execute on many more platforms than
the ones listed above, including (but not limited to) the operating
systems listing below if they pass the \ `Symfony
requirements <http://symfony.com/doc/current/reference/requirements.html>`__,
using cache solutions technically supported
by \ `Stash <http://www.stashphp.com/Drivers.html>`__, using databases
supported by \ `Doctrine
DBAL <http://doctrine-dbal.readthedocs.org/en/latest/reference/configuration.html>`__,
and using a binary file storage solution supported by
`FlySystem <https://github.com/thephpleague/flysystem#adapters>`__.

**eZ Systems doesn't insure or guarantee quality operation of an eZ
Publish Platform installation if it is running on a platform not listed
as professionally supported.** eZ Publish Enterprise Subscriptions are
still available for compatible platforms, but the guarantee and the
product support will not apply and although you will receive various
maintenance releases and services, no bug fix guarantee will apply to
issues related to the platform. Maintenance and monitoring tools will
not be available. eZ Systems does not advise merely compatible platforms
for production use.

However compatible platforms are community supported, meaning
contributions and efforts made to improve support for these technologies
are welcome and can contribute to the technology being professionally
supported by the eZ Systems team in the future.

Compatible platforms
~~~~~~~~~~~~~~~~~~~~

-  Most Linux operating system (Fedora, Arc, CoreOs...)
-  Solaris
-  OpenSolaris
-  Windows Vista/7/2008
-  Mac OS X (server & normal) 

Supported browsers
==================

eZ Publish is developed to work properly and support the following
browser configurations for administrator users:

-  Mozilla® Firefox®, most recent stable version\* (tested on Firefox
   33)

-  Google Chrome™, most recent stable version\* (tested on Chrome 38)

-  Microsoft® Internet Explorer® versions 9, 10 and 11 (tested mainly on
   IE 11)\*

-  Apple® Safari® 7.x (tested on 7.1)\* on Mac OS X. Apple Safari on iOS
   isn’t currently supported for admin backend

| :sub:`:sup:`\*  eZ makes every effort to test and support the most
recent version of browsers that uses automated update system, however
issues with Online Editor (TinyMCE) introduced as part of new browsers
can in extreme cases mean we can not support a certain feature on the
browser as we are not in a situation where we can upgrade TinyMCE within
eZ Publish 5.x. ``
| Please note that the user interface will display and behave optimally
in any browser that supports HTML 5, CSS 3 and ECMAScript 5. If these
technologies are not supported the system will gracefully appear with
simpler design/layout but will still be accessible through
standard/default HTML elements.

 

Document generated by Confluence on Mar 03, 2015 15:12
