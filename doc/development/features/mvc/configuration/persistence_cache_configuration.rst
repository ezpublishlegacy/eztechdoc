#. `eZ Publish Platform 5.x <index.html>`__
#. `eZ Publish Platform
   Documentation <eZ-Publish-Platform-Documentation_1114149.html>`__
#. `Development & Administration Guides <6291674.html>`__
#. `Features <Features_12781009.html>`__
#. `MVC and Application <MVC-and-Application_2719826.html>`__
#. `Configuration <Configuration_2720538.html>`__

eZ Publish Platform 5.x : Persistence cache configuration
=========================================================

Created and last modified by andre.romcke@ez.no on Jan 06, 2015

| 

-  `Introduction <#Persistencecacheconfiguration-Introduction>`__
-  `Configuration <#Persistencecacheconfiguration-Configuration>`__

   -  `Multi repository
      setup <#Persistencecacheconfiguration-Multirepositorysetup>`__

-  `Stash cache backend
   configuration <#Persistencecacheconfiguration-Stashcachebackendconfiguration>`__

   -  `General
      settings <#Persistencecacheconfiguration-Generalsettings>`__
   -  `FileSystem <#Persistencecacheconfiguration-FileSystem>`__

      -  `Available
         settings <#Persistencecacheconfiguration-Availablesettings>`__
      -  `FileSystem cache backend
         troubleshooting <#Persistencecacheconfiguration-FileSystemcachebackendtroubleshooting>`__

         -  `Manual <#Persistencecacheconfiguration-Manual>`__
         -  `Share stash cache across
            environments <#Persistencecacheconfiguration-Sharestashcacheacrossenvironments>`__

   -  `APC <#Persistencecacheconfiguration-APC>`__
   -  `Memcache <#Persistencecacheconfiguration-Memcache>`__

      -  `Example with
         Memcache <#Persistencecacheconfiguration-ExamplewithMemcache>`__

Introduction
============

**Tech Note**

Current implementation uses a caching library called
`Stash <http://stash.tedivm.com/>`__ (, via
`Stash-bundle <https://github.com/tedivm/TedivmStashBundle>`__). Stash
supports the following cache backends: **FileSystem**, \ **Memcache**,
**APC**, **Sqlite**\ **, Redis **\ and **BlackHole.**

If eZ Publish Platform changes to another cache system, configuration
will change in the future, changes to configuration in StashBundle is
listed here:

Configuration change in 5.4/2014.07

Icon

StashBundle version bundled with 5.4/2014.07 and higher refers to cache
backends as *"drivers"* where it was previously referred to as
*"handlers"* in configuration\ *!*

**Cache service**

The cache system is exposed as a "cache" service, and can be reused by
any other service as described on the
`Persistence cache <Persistence-cache_10158280.html>`__ page.

Configuration
=============

During Setup wizard and manually using ``ezpublish:configure`` console
command a default configuration is generated currently **using
FileSystem**, using ``%kernel.cache_dir%/stash`` to store cache files.

The configuration is placed in ezpublish/config/ezpublish.yml, and looks
like:

**Default ezpublish.yml**

.. code:: theme:

    stash:
        caches:
            default:
                # For eZ Publish Platform versions prior to 5.4/2014.07, use "handlers" instead of "drivers"!
                drivers:
                    - FileSystem
                inMemory: false
                registerDoctrineAdapter: false

The default settings used during setup wizard as found in
``ezpublish/config/ezpublish_setup.yml``:

**ezpublish\_setup.yml**

.. code:: theme:

    stash:
        caches:
            default:
                # For eZ Publish Platform versions prior to 5.4/2014.07, use "handlers" instead of "drivers"!
                drivers:
                    - BlackHole
                inMemory: true
                registerDoctrineAdapter: false

This setting works across all installs and just caches objects within
the same request thanks to the ``inMemory: true`` setting.

If you want to change to another cache backend, see in *Stash backend
configuration* below for what kind of settings you have available.

Note for "inMemory" cache with long running scripts

Icon

Use of ``inMemory`` caching with BlackHole or any other cache backend
should not be used for long running scripts as it will over time return
stale data, inMemory cache is not shared across requests/processes, so
invalidation does not happen!

Multi repository setup
~~~~~~~~~~~~~~~~~~~~~~

New in 5.2 is the possibility to select a specific Stash cache pool on a
siteaccess or sitegroup level, the following example shows use in a
sitegroup:

**ezpublish.yml site group setting**

.. code:: theme:

            ezdemo_group:
                cache_pool_name: "default"
                database:
                    ...

| The "default" here refers to the name of the cache pool as specified
in the *stash* configuration block shown above, if your install has
several repositories (databases), then make sure every group of sites
using different repositories also uses a different cache pool to avoid
unwanted effects.
| NB: We plan to make this more native in the future, so this setting
will someday not be needed.

Stash cache backend configuration
=================================

General settings
~~~~~~~~~~~~~~~~

To check which cache settings are available for your installation, run
the following command in your terminal :

.. code:: theme:

    php ezpublish/console config:dump-reference stash

FileSystem
~~~~~~~~~~

This cache backend is using local filesystem, by default the Symfony
cache folder, as this is per server, it \ **does not support multi
server (`cluster <Clustering_25985700.html>`__) setups**!

Icon

**We strongly discourage you from storing cache files on NFS**, as it
defeats the purpose of the cache: speed

**Available settings**
^^^^^^^^^^^^^^^^^^^^^^

+--------------------------------------+--------------------------------------+
| ::                                   | The path where the cache is placed,  |
|                                      | default is                           |
|     path                             | ``%kernel.cache_dir%/stash``,        |
|                                      | effectively                          |
|                                      | ``ezpublish/cache/<env>/stash``      |
+--------------------------------------+--------------------------------------+
| ::                                   | Number of times the cache key should |
|                                      | be split up to avoid having to many  |
|     dirSplit                         | files in each folder, default is 2.  |
                                                                             
+--------------------------------------+--------------------------------------+
| ::                                   | The permissions of the cache file,   |
|                                      | default is 0660.                     |
|     filePermissions                  |                                      |
                                                                             
+--------------------------------------+--------------------------------------+
| ::                                   | The permission of the cache file     |
|                                      | directories (see dirSplit), default  |
|     dirPermissions                   | is 0770.                             |
                                                                             
+--------------------------------------+--------------------------------------+
| ::                                   | Limit on how many key to path        |
|                                      | entries are kept in memory during    |
|     memKeyLimit                      | execution at a time to avoid having  |
|                                      | to recalculate the path on key       |
|                                      | lookups, default 200.                |
+--------------------------------------+--------------------------------------+
| ::                                   | Algorithm used for creating paths,   |
|                                      | default md5. Use crc32 on Windows to |
|     keyHashFunction                  | avoid path length issues.\ ````      |
                                                                             
+--------------------------------------+--------------------------------------+

Issues with Microsoft Windows

Icon

If you are using a Windows OS, you may encounter an issue
regarding\ **long paths for cache directory name**. The paths are long
because Stash uses md5 to generate unique key that are sanitized really
quickly.

Solution is to **change the hash algorithm** used by Stash.

**Specifying key hash function**

.. code:: theme:

    stash:
        caches:
            default:
                # For eZ Publish Platform versions prior to 5.4/2014.07, use "handlers" instead of "drivers"!
                drivers:
                    - FileSystem
                inMemory: true
                registerDoctrineAdapter: false
                FileSystem:
                    keyHashFunction: 'crc32'

| **This configuration is only recommended for Windows users**.
| Note: You can also define the\ **path** where you want the cache files
to be generated.
| Note2: This configuration is only recommended for Windows users, but
does solve this problem. 

 

FileSystem cache backend troubleshooting
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

By default, Stash Filesystem cache backend stores cache to a sub-folder
named after the environment
(``i.e. ezpublish/cache/dev``, \ ``ezpublish/cache/prod``). This can
lead to the following issue : if different environments are used for
operations, persistence cache (manipulating content, mostly) will be
affected and cache can become inconsistent.

To prevent this, there are 2 solutions :

#. Manual
         

   | **Always** use the same environment, for web, command line,
   cronjobs...

#. Share stash cache across environments
                                        

| Either by using another Stash cache backend, or by setting Stash to
use a shared cache folder that does not depend on the environment. 
| In ezpublish.yml:

.. code:: theme:

    stash:
        caches:
            default:
                FileSystem:
                    path: "%kernel.root_dir%/cache/common"

This will store stash cache to \ ``ezpublish/cache/common.``

APC
~~~

This cache backend is using shard memory using APC's user cache feature,
as this is per server, it **does not support multi server
(`cluster <Clustering_25985700.html>`__) setups**.

Limitation

Icon

As APC user cache is not shared between processes, it is not possible to
clear the user cache from CLI, even if you set ``apc.enable_cli`` to On.
Hence publishing content from a command line script won't let you
properly clear SPI Persistence cache.

Please also note that the default value for \ ``apc.shm_size`` is 128MB.
However, 256MB is recommended for APC to work properly. For more details
please refer to the `APC configuration
manual <http://www.php.net/manual/en/apc.configuration.php#ini.apc.shm-size>`__.

 

**Available settings**

+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------------+
| ``ttl``         | The time to live of the cache in seconds, default set to 500 (8.3 minutes)                                                                       |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------------+
| ``namespace``   | A namespace to prefix cache keys with to avoid key conflicts with other eZ Publish sites on same eZ Publish installation, default is ``null``.   |
+-----------------+--------------------------------------------------------------------------------------------------------------------------------------------------+

Memcache
~~~~~~~~

This cache backend is using `Memcached, a distributed caching
solution <http://memcached.org/>`__, this is the only supported cache
solution for multi server (`cluster <Clustering_25985700.html>`__)
setups!

Note

Icon

Stash supports both the `php-memcache <http://php.net/memcache>`__ and
`php-memcached <http://php.net/memcached>`__ extensions. **However**
only php-memcache is officially tested on Redhat/Centos while
php-memcached is on Debian and Ubuntu. If you have both extensions
installed, Stash will automatically choose php-memcached.

+--------------------------------------+--------------------------------------+
| ``servers``                          | Array of Memcached servers, with     |
|                                      | host/IP, port and weight             |
|                                      |                                      |
|                                      | | ``server``: Host or IP of your     |
|                                      | Memcached server                     |
|                                      | | ``port``: Port where Memcached is  |
|                                      | listening to (defaults to 11211)     |
|                                      | | ``weight``: Weight of the server,  |
|                                      | when using several Memcached servers |
+--------------------------------------+--------------------------------------+
| ``prefix_key``                       | A namespace to prefix cache keys     |
|                                      | with to avoid key conflicts with     |
|                                      | other eZ Publish sites on same eZ    |
|                                      | Publish installation (default is an  |
|                                      | empty string).                       |
|                                      | Must be the same on all server with  |
|                                      | the same installation. `See          |
|                                      | Memcached prefix\_key                |
|                                      | option <http://www.php.net/manual/en |
|                                      | /memcached.constants.php#memcached.c |
|                                      | onstants.opt-prefix-key>`__.         |
|                                      | ✲                                    |
+--------------------------------------+--------------------------------------+
| ``compression``                      | default true. `See Memcached         |
|                                      | compression                          |
|                                      | option <http://www.php.net/manual/en |
|                                      | /memcached.constants.php#memcached.c |
|                                      | onstants.opt-compression>`__.        |
|                                      | ✲                                    |
+--------------------------------------+--------------------------------------+
| ``libketama_compatible``             | default false. `See Memcached        |
|                                      | libketama\_compatible                |
|                                      | option <http://www.php.net/manual/en |
|                                      | /memcached.constants.php#memcached.c |
|                                      | onstants.opt-libketama-compatible>`_ |
|                                      | _                                    |
|                                      | ✲                                    |
+--------------------------------------+--------------------------------------+
| ``buffer_writes``                    | default false. `See Memcached        |
|                                      | buffer\_writes                       |
|                                      | option <http://www.php.net/manual/en |
|                                      | /memcached.constants.php#memcached.c |
|                                      | onstants.opt-buffer-writes>`__ ✲     |
+--------------------------------------+--------------------------------------+
| ``binary_protocol``                  | default false. `See Memcached        |
|                                      | binary\_protocol                     |
|                                      | option <http://www.php.net/manual/en |
|                                      | /memcached.constants.php#memcached.c |
|                                      | onstants.opt-binary-protocol>`__ ✲   |
+--------------------------------------+--------------------------------------+
| ``no_block``                         | default false. `See Memcached        |
|                                      | no\_block                            |
|                                      | option <http://www.php.net/manual/en |
|                                      | /memcached.constants.php#memcached.c |
|                                      | onstants.opt-no-block>`__ ✲          |
+--------------------------------------+--------------------------------------+
| ``tcp_nodelay``                      | default false. `See Memcached        |
|                                      | tcp\_nodelay                         |
|                                      | option <http://www.php.net/manual/en |
|                                      | /memcached.constants.php#memcached.c |
|                                      | onstants.opt-tcp-nodelay>`__ ✲       |
+--------------------------------------+--------------------------------------+
| ``connection_timeout``               | default 1000. `See Memcached         |
|                                      | connection\_timeout                  |
|                                      | option <http://www.php.net/manual/en |
|                                      | /memcached.constants.php#memcached.c |
|                                      | onstants.opt-connection-timeout>`__  |
|                                      | ✲                                    |
+--------------------------------------+--------------------------------------+
| ``retry_timeout``                    | default 0. `See Memcached            |
|                                      | retry\_timeout                       |
|                                      | option <http://www.php.net/manual/en |
|                                      | /memcached.constants.php#memcached.c |
|                                      | onstants.opt-memcached-timeout>`__ ✲ |
+--------------------------------------+--------------------------------------+
| ``send_timeout``                     | default 0. `See Memcached            |
|                                      | send\_timeout                        |
|                                      | option <http://www.php.net/manual/en |
|                                      | /memcached.constants.php#memcached.c |
|                                      | onstants.opt-send-timeout>`__ ✲      |
+--------------------------------------+--------------------------------------+
| ``recv_timeout``                     | default 0. `See Memcached            |
|                                      | recv\_timeout                        |
|                                      | option <http://www.php.net/manual/en |
|                                      | /memcached.constants.php#memcached.c |
|                                      | onstants.opt-recv-timeout>`__ ✲      |
+--------------------------------------+--------------------------------------+
| ``poll_timeout``                     | default 1000. `See Memcached         |
|                                      | poll\_timeout                        |
|                                      | option <http://www.php.net/manual/en |
|                                      | /memcached.constants.php#memcached.c |
|                                      | onstants.opt-poll-timeout>`__ ✲      |
+--------------------------------------+--------------------------------------+
| ``cache_lookups``                    | default false. `See Memcached        |
|                                      | cache\_lookups                       |
|                                      | option <http://www.php.net/manual/en |
|                                      | /memcached.constants.php#memcached.c |
|                                      | onstants.opt-cache-lookups>`__ ✲     |
+--------------------------------------+--------------------------------------+
| **``server_failure_limit``**         | default 0. `See PHP Memcached        |
|                                      | documentation <http://www.php.net/ma |
|                                      | nual/en/memcached.constants.php#memc |
|                                      | ached.constants.opt-server-failure-l |
|                                      | imit>`__                             |
|                                      | ✲                                    |
+--------------------------------------+--------------------------------------+
| **``socket_send_size ``              | See `Memcached socket\_send\_size    |
| **                                   | option <http://www.php.net/manual/en |
|                                      | /memcached.constants.php#memcached.c |
|                                      | onstants.opt-socket-send-size>`__.   |
|                                      | ✲ ✸                                  |
+--------------------------------------+--------------------------------------+
| **``socket_recv_size``**             | See `Memcached socket\_recv\_size    |
|                                      | option <http://www.php.net/manual/en |
|                                      | /memcached.constants.php#memcached.c |
|                                      | onstants.opt-socket-recv-size>`__.   |
|                                      | ✲ ✸                                  |
+--------------------------------------+--------------------------------------+
| **``serializer``**                   | See `Memcached serializer            |
|                                      | option <http://www.php.net/manual/en |
|                                      | /memcached.constants.php#memcached.c |
|                                      | onstants.opt-serializer>`__.         |
|                                      | ✲ ✸                                  |
+--------------------------------------+--------------------------------------+
| **``hash``**                         | See `Memcached hash                  |
|                                      | option <http://www.php.net/manual/en |
|                                      | /memcached.constants.php#memcached.c |
|                                      | onstants.opt-hash>`__.               |
|                                      | ✲ ✸                                  |
+--------------------------------------+--------------------------------------+
| **``distribution``**                 | Specifies the method of distributing |
|                                      | item keys to the servers.            |
|                                      | See\ `Memcached distribution         |
|                                      | option <http://www.php.net/manual/en |
|                                      | /memcached.constants.php#memcached.c |
|                                      | onstants.opt-distribution>`__.       |
|                                      | ✲ ✸                                  |
+--------------------------------------+--------------------------------------+

 

| ✲ All settings but *servers* are only available with memcached php
extension, for more information on these settings and which version of
php-memcached they are available in,
see: \ `http://php.net/Memcached <http://php.net/Memcached>`__
| ✸ If you are on eZ Publish 5.1, make sure to update Stash and
StashBundle to get access to these settings.

 

Icon

| When using Memcache cache backend, **it's recommended to also use
``inMemory`` cache** (see example below).
| This will help reducing network traffic between your webserver and
your Memcached server, unless you have very long running cli processes
which then might end up acting on stale data.

Example with Memcache
^^^^^^^^^^^^^^^^^^^^^

.. code:: theme:

    stash:
        caches:
            default:
                # For eZ Publish Platform versions prior to 5.4/2014.07, use "handlers" instead of "drivers"!
                drivers: [ Memcache ]
                inMemory: true
                registerDoctrineAdapter: false
                Memcache:
                    prefix_key: ezdemo_
                    retry_timeout: 1
                    servers:
                        -
                            server: 127.0.0.1
                            port: 11211

Connection errors issue

Icon

If memcached does display connection errors when using the default
(ascii) protocol, switching to binary protocol (in the stash
configuration and memcached daemon) should resolve the issue.

Comments:
---------

+--------------------------------------------------------------------------+
| | Hi everybody,                                                          |
| | When using Memcache in multi fronts installation, if the cache         |
| mechanism doesn't work after checking your eZ Publish configuration .    |
| | Be sure to use the php5-memcache\ **d** (with "d")                     |
| |  It will save you probably 1 or 2 hours of debug ! |(wink)|            |
|                                                                          |
| ++                                                                       |
|                                                                          |
| |image3| Posted by Plopix at Apr 04, 2014 14:52                          |
+--------------------------------------------------------------------------+
| When using ``retry_timeout`` option as in the example above you will get |
| an exception like:                                                       |
|                                                                          |
| | [Stash\\Exception\\RuntimeException]                                   |
| | Memcached option Memcached::OPT\_RETRY\_TIMEOUT not accepted by        |
| memcached extension.                                                     |
|                                                                          |
| At least on Ubuntu 14.04 LTS + php5\_memcached 2.1.0-6build1 + memcached |
| 1.4.14-0ubuntu9                                                          |
|                                                                          |
|                                                                          |
|                                                                          |
| |image4| Posted by xserna at Oct 15, 2014 15:02                          |
+--------------------------------------------------------------------------+

Document generated by Confluence on Mar 03, 2015 15:12

.. |(wink)| image:: images/icons/emoticons/wink.png
.. |image1| image:: images/icons/contenttypes/comment_16.png
.. |image2| image:: images/icons/contenttypes/comment_16.png
.. |image3| image:: images/icons/contenttypes/comment_16.png
.. |image4| image:: images/icons/contenttypes/comment_16.png
