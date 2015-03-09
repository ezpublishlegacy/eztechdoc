#. `eZ Publish Platform 5.x <index.html>`__
#. `eZ Publish Platform
   Documentation <eZ-Publish-Platform-Documentation_1114149.html>`__
#. `Installation and Upgrade
   Guides <Installation-and-Upgrade-Guides_6292016.html>`__
#. `Installation <Installation_7438500.html>`__
#. `Normal installation <Normal-installation_7438509.html>`__

eZ Publish Platform 5.x : Installing eZ Publish on a Linux-UNIX based system
============================================================================

Created by andrea.melo@ez.no, last modified by
sarah.haim-lubczanski@ez.no on Sep 29, 2014

Icon

The requirements for doing a normal installation must be met, read the
"`Requirements for doing a normal
installation <Requirements-for-doing-a-normal-installation_7438584.html>`__\ "
section first!

This section will guide you through the following steps:

-  1 `Setting up a database
   5.X <#InstallingeZPublishonaLinux-UNIXbasedsystem-SettingupadatabaseYellow5.x>`__

   -  1.1 `MySQL <#InstallingeZPublishonaLinux-UNIXbasedsystem-MySQL>`__
   -  1.2
      `PostgreSQL <#InstallingeZPublishonaLinux-UNIXbasedsystem-PostgreSQL>`__

-  2 `Downloading eZ Publish
   5.X <#InstallingeZPublishonaLinux-UNIXbasedsystem-DownloadingeZPublishYellow5.x>`__
-  3 `Unpacking eZ Publish
   5.X <#InstallingeZPublishonaLinux-UNIXbasedsystem-UnpackingeZPublishYellow5.x>`__
-  4 `Setting up folder permission
   5.X <#InstallingeZPublishonaLinux-UNIXbasedsystem-SettingupfolderpermissionYellow5.x>`__
-  5 `Install Composer
   5.X <#InstallingeZPublishonaLinux-UNIXbasedsystem-InstallComposerYellow5.x>`__

   -  5.1 `For 5.3 and higher : get latest versions of packages >= 5.3 /
      2014.05 <#InstallingeZPublishonaLinux-UNIXbasedsystem-For5.3andhigher:getlatestversionsofpackagesRed>=5.3/2014.05>`__
   -  5.2 `For 5.2 : for Symfony and its dependencies
      5.2 <#InstallingeZPublishonaLinux-UNIXbasedsystem-For5.2:forSymfonyanditsdependenciesGreen5.2>`__

-  6 `For all 5.x versions : Install Zetacomponents for a pure legacy
   setup
   5.X <#InstallingeZPublishonaLinux-UNIXbasedsystem-Forall5.xversions:InstallZetacomponentsforapurelegacysetupYellow5.x>`__
-  7 `Before 5.2 : Link assets <
   5.2 <#InstallingeZPublishonaLinux-UNIXbasedsystem-Before5.2:Linkassets<5.2>`__
-  8 `Initiating the setup wizard
   5.X <#InstallingeZPublishonaLinux-UNIXbasedsystem-InitiatingthesetupwizardYellow5.x>`__

Icon

Follow the status labels for the right version : ***5.X*** ******5.0
***5.1\ ***5.2************  ***>= 5.3 / 2014.05***

Setting up a database\ ***5.X***
--------------------------------

A **database must be created** before running the setup wizard. The
following text explains how to set up a database using either MySQL or
PostgreSQL.

MySQL
~~~~~

#. Log in as the root user (or any other MySQL user that has the
   ``CREATE``, ``CREATE USER`` and ``GRANT OPTION``
   `privileges <http://dev.mysql.com/doc/refman/5.1/en/privileges-provided.html>`__):

   .. code:: theme:

       # mysql --host=<mysql_host> --port=<port> -u <mysql_user> -p<mysql_password>

   Icon

   Note that if MySQL is installed on the same server, the
   "``--host``\ " parameter can be omitted. If the "``--port``\ "
   parameter is omitted, the default port for MySQL traffic will be used
   (port 3306).

   | The MySQL client should display a "mysql>" prompt.

#. Create a new database:

   ::

       mysql> CREATE DATABASE <database> CHARACTER SET utf8;

#. Grant access permissions:

   ::

       mysql> GRANT ALL ON <database>.* TO <user>@<ezp_host> IDENTIFIED BY '<password>';

   Icon

   Note that if the specified user account does not exist, it will be
   created.

   Reference

   Description

   <mysql\_host>

   The hostname of the MySQL database server.

   <port>

   The port number that will be used to connect to the MySQL database
   server.

   <mysql\_user>

   The MySQL user (if no user is set up, use "``root``\ ").

   <mysql\_password>

   The password that belongs to the ``<mysql_user>``.

   <database>

   The name of the database, for example "``my_new_database``\ ".

   <user>

   The username that will be used to access the database.

   <ezp\_host>

   The hostname of the server on which eZ Publish will be running. (may
   be "``localhost``\ " if MySQL is installed on the same server).

   <password>

   The password you wish to set in order to limit access to the
   database.

PostgreSQL
~~~~~~~~~~

#. Log in as the postgres user (or any other PostgreSQL user that has
   sufficient
   `privileges <http://www.postgresql.org/docs/current/interactive/sql-grant.html>`__
   to create roles and databases):

   ::

       $ psql -h <psql_host> -p <port> -U <psql_user> -W

   Icon

   Note that if PostgreSQL is installed on the same server, the
   "``-h``\ " parameter can be omitted. If the "``-p``\ " parameter is
   omitted, the default port for PostgreSQL traffic will be used (in
   most cases, port 5432).

   The PostgreSQL client will ask you to specify the password that
   belongs to the ``<psql_user>``. If the password is correct, the
   client should display a "``<psql_user>=#``\ " prompt.

#. Create a new database:

   ::

       postgres=# CREATE DATABASE <database> ENCODING='utf8';

#. Create a new user:

   ::

       postgres=# CREATE USER <user> PASSWORD '<password>';

#. Grant access permissions:

   ::

       postgres=# GRANT ALL PRIVILEGES ON DATABASE <database> TO <user>;

    

   Import the
   "`pgcrypto <http://www.postgresql.org/docs/8.3/static/pgcrypto.html>`__\ "
   module into the new database:

   ::

       postgres=# \c <database>
       <database>=# \i '<path_to_pgcrypto>'

   Reference

   Description

   <psql\_host>

   The hostname of the PostgreSQL database server.

   <port>

   The port number that will be used to connect to the PostgreSQL
   database server.

   <psql\_user>

   The PostgreSQL user (if no user is set up, use "``postgresql``\ ").

   <database>

   The name of the database, for example "``my_new_database``\ ".

   <user>

   The username that will be used to access the database.

   <password>

   The password you wish to set in order to limit access to the
   database.

   <path\_to\_pgcrypto>

   The path to the "``pgcrypto.sql``\ " file, for example
   "``/usr/share/pgsql/contrib/pgcrypto.sql``\ ".

   **
   Note for version 9.1+ of PostgreSQL users:**\ The following changes
   might be necessary for these users:

   ::

       postgres=# \c <database>
       <database>=# CREATE EXTENSION pgcrypto;

Downloading eZ Publish ***5.X***
--------------------------------

Icon

The latest community version of eZ Publish can be downloaded from
`http://share.ez.no/downloads <http://share.ez.no/downloads>`__

Enterprise version is available in your `support
portal <https://support.ez.no>`__ or via partner portal.

Unpacking eZ Publish ***5.X***
------------------------------

| Use your favorite tool to unpack the downloaded eZ Publish
distribution to a web-served directory (a directory that is reachable
using a web browser), or in case of virtual host mode it can be any
folder.
| The following example shows how to do this using the tar utility (to
unpack a tar.gz file, assuming that the "tar" and the "gzip" utilities
are installed on the system):

::

    $ tar zxvf ezpublish-<version_number>-gpl.tar.gz -C <web_served_directory>

Reference

Description

``<version_number>``

The version number of eZ Publish that was downloaded.

``<web_served_directory>``

Full path to a directory that is served by the web server. This can be
the path to the document root of the web server, or a personal
web-directory (usually called "``public_html``\ " or "``www``\ ", and
located inside a user's home directory).

 

The extraction utility will unpack eZ Publish into a sub-directory
called "``ezpublish-<version_number>``\ ". Feel free to rename this
directory to something more meaningful, for example "``my_site``\ ".

Setting up folder permission\ ***5.X***
---------------------------------------

Important

Icon

In the 3 first folder permission setup options, always ensure to run
application scripts and the web server with the appropriate UNIX user
(must be same as you setup rights for below).

As for Apache you can control which user to use in your Apache
configuration. Using
`PHP-FPM <http://php.net/manual/en/install.fpm.php>`__ or `SuExec
module <http://httpd.apache.org/docs/2.2/en/suexec.html>`__, you can
even specify a user per virtual host.

Several cache, log and config folders must be writable both by the web
server and the command line user, use *one* of the following
alternatives to do this:

-  | **Using ACL on a system that supports chmod +a**
   | These shell commands will give proper permission to the web server
   and command line users.

   ***5.3 / 2014.05 and higher: >= 5.3 / 2014.05
   ***

   ::

           $ cd /<ezp5-root>/
           $ sudo chmod +a "www-data allow delete,write,append,file_inherit,directory_inherit" \
             ezpublish/{cache,logs,config,sessions} ezpublish_legacy/{design,extension,settings,var} web
           $ sudo chmod +a "`whoami` allow delete,write,append,file_inherit,directory_inherit" \
             ezpublish/{cache,logs,config,sessions} ezpublish_legacy/{design,extension,settings,var} web

   ***5.0, 5.1 and 5.2: ***5.0 ***5.1\ ***5.2*********
   ***

   ::

           $ cd /<ezp5-root>/
           $ sudo chmod +a "www-data allow delete,write,append,file_inherit,directory_inherit" \
             ezpublish/{cache,logs,config} ezpublish_legacy/{design,extension,settings,var} web
           $ sudo chmod +a "`whoami` allow delete,write,append,file_inherit,directory_inherit" \
             ezpublish/{cache,logs,config} ezpublish_legacy/{design,extension,settings,var} web

   **
   **

-  | **Using ACL on a system that does not support chmod +a
   **\ Some systems don't support chmod +a, but do support another
   utility called setfacl. You may need to enable ACL support on your
   partition and install setfacl before using it (as is the case with
   Ubuntu).
   | ******5.3 / 2014.05*** and higher: ***>= 5.3 / 2014.05***
   ***

   ::

           $ cd /<ezp5-root>/
           $ sudo setfacl -R -m u:www-data:rwx -m u:www-data:rwx \
             ezpublish/{cache,logs,config,sessions} ezpublish_legacy/{design,extension,settings,var} web
           $ sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx \
             ezpublish/{cache,logs,config,sessions} ezpublish_legacy/{design,extension,settings,var} web

   ***5.0, 5.1 and 5.2: ******5.0 ***5.1\ ***5.2************
   ***

   ::

           $ cd /<ezp5-root>/
           $ sudo setfacl -R -m u:www-data:rwx -m u:www-data:rwx \
             ezpublish/{cache,logs,config} ezpublish_legacy/{design,extension,settings,var} web
           $ sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx \
             ezpublish/{cache,logs,config} ezpublish_legacy/{design,extension,settings,var} web

-  | **Using chown on systems that don't support ACL**
   | Some systems don't support ACL at all. You will either need to set
   your web server's user as the owner of the required directories.
   | ******5.3 / 2014.05*** and higher: ***>= 5.3 / 2014.05***
   ***

   ::

           $ cd /<ezp5-root>/
           $ sudo chown -R www-data:www-data ezpublish/{cache,logs,config,sessions} ezpublish_legacy/{design,extension,settings,var} web
           $ sudo find {ezpublish/{cache,logs,config,sessions},ezpublish_legacy/{design,extension,settings,var},web} -type d | sudo xargs chmod -R 775
           $ sudo find {ezpublish/{cache,logs,config,sessions},ezpublish_legacy/{design,extension,settings,var},web} -type f | sudo xargs chmod -R 664

   ***5.0, 5.1 and 5.2: ******5.0 ***5.1\ ***5.2************
   ***

   ::

           $ cd /<ezp5-root>/
           $ sudo chown -R www-data:www-data ezpublish/{cache,logs,config} ezpublish_legacy/{design,extension,settings,var} web
           $ sudo find {ezpublish/{cache,logs,config},ezpublish_legacy/{design,extension,settings,var},web} -type d | sudo xargs chmod -R 775
           $ sudo find {ezpublish/{cache,logs,config},ezpublish_legacy/{design,extension,settings,var},web} -type f | sudo xargs chmod -R 664

-  | **Using chmod**
   | If you can't use ACL and aren't allowed to change owner, you can
   use chmod, making the files writable by everybody. Note that this
   method really isn't recommended as it allows any user to do anything.
   | ******5.3 / 2014.05*** and higher: ***>= 5.3 / 2014.05***
   ***

   ::

           $ cd /<ezp5-root>/
           $ sudo find {ezpublish/{cache,logs,config,sessions},ezpublish_legacy/{design,extension,settings,var},web} -type d | sudo xargs chmod -R 777
           $ sudo find {ezpublish/{cache,logs,config,sessions},ezpublish_legacy/{design,extension,settings,var},web} -type f | sudo xargs chmod -R 666

   ***5.0, 5.1 and 5.2: ******5.0 ***5.1\ ***5.2************
   ***

   ::

           $ cd /<ezp5-root>/
           $ sudo find {ezpublish/{cache,logs,config},ezpublish_legacy/{design,extension,settings,var},web} -type d | sudo xargs chmod -R 777
           $ sudo find {ezpublish/{cache,logs,config},ezpublish_legacy/{design,extension,settings,var},web} -type f | sudo xargs chmod -R 666

Install Composer ***5.X***
--------------------------

If you use a version control system, take care of versioning the
composer.lock file.

Install `Composer <http://getcomposer.org/>`__ by running one of the
following command from you eZ Publish root folder :

If you **have curl** installed:

::

    curl -sS https://getcomposer.org/installer | php

If you **don't have curl** installed:

::

    php -r "eval('?>'.file_get_contents('https://getcomposer.org/installer'));"

For 5.3 and higher : get latest versions of packages ***>= 5.3 / 2014.05***
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

When Composer is installed, run update to get latest versions of
packages before you continue with installation.

Icon

Learn more on how to keep system further up to date  `Using
Composer <Using-Composer_23527865.html>`__

For 5.2 : for Symfony and its dependencies ************5.2************
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

| Use composer for Symfony and its dependencies only, not for eZ Publish
and it's dependencies.

**Symfony**

Symfony is a set of reusable **PHP components**...and a **PHP
framework** for web projects. Symfony is the PHP framework under the
platform to make developers lives easier.

Icon

See `the architecture
documentation <https://doc.ez.no/pages/viewpage.action?pageId=11403666>`__
to understand the role of Symfony in eZ Publish Platform.

 

For all 5.x versions : Install Zetacomponents for a pure legacy setup ***5.X***
-------------------------------------------------------------------------------

As of eZ Publish 5.2, if you plan to use eZ Publish legacy **only,** as
standalone (as in pointing apache to ezpublish\_legacy folder or
extracting only ezpublish\_legacy), then Zetacomponents must be
installed if you don't already have it via PEAR.

After Composer installation (see above for Composer installation
instructions) run the following command **from
the \ *ezpublish\_legacy/* folder :**

::

    php composer.phar install

Icon

Composer will need GD to run.

 

Before 5.2 : Link assets *********< 5.2\ ***************
--------------------------------------------------------

Icon

The download file should already have generated these assets for you as
of 5.2 / 2013.07 during composer install, but in case file has been
extracted on Windows, make sure to run these commands.

To be able to run eZ Publish 5 correctly, assets need to be exposed in
the public "``web``\ " folder.

The following commands will first symlink eZ Publish 5 assets in
"Bundles" and the second will symlink assets (design files like images,
scripts and css, and files in var folder)  from eZ Publish Legacy

::

    cd /<ezp5-root>
    php ezpublish/console assets:install --relative --symlink web
    php ezpublish/console ezpublish:legacy:assets_install --relative --symlink web
    php ezpublish/console assetic:dump --env=prod web

Icon

**Note**: In both cases "``web``\ " is the default folder and can be
skipped from the command. For symlinks on the first two commands you can
either use --relative, --symlink, or none to get the command to copy
assets. However make sure to also update "symfony-assets-install" in
composer.json if you prefer something else then --relative which is the
default.

Further information about alternative options is available with ``-h``
on each command, just like it is with the console itself using
"``php ezpublish/console ``\ ``-h``".

Warning regarding APC usercache

Icon

If you are planning to use APC usercache for eZ Publish Persistence
cache, please be sure to check the available notes
`here <https://confluence.ez.no/display/EZP/Persistence+cache+configuration#Persistencecacheconfiguration-APC>`__,
before entering the setup wizard chapter.

Initiating the setup wizard ***5.X***
-------------------------------------

The setup wizard can be started using a web browser immediately after
the previous steps (described in this section) are completed. It will be
automatically run the first time someone tries to access/browse the
"``/ezsetup``\ " url.

 

Comments:
---------

+--------------------------------------------------------------------------+
| FYI for dev environment assets should be deployed with:                  |
|                                                                          |
| .. code:: p1                                                             |
|                                                                          |
|     php ezpublish/console assetic:dump --env=dev                         |
|                                                                          |
|                                                                          |
|                                                                          |
|                                                                          |
|                                                                          |
|                                                                          |
|                                                                          |
| |image4| Posted by gof at Jul 27, 2014 09:59                             |
+--------------------------------------------------------------------------+
| Afaik that is only the case if your installing using dev environment and |
| intended to use that after install, a bit of improvement potential on    |
| the whole assetic/assets handling, this is tracked within the Symfony DX |
| (Developer experience) efforts btw so might improve in the next          |
| releases.                                                                |
|                                                                          |
|                                                                          |
|                                                                          |
| So, specify the env you use for web browsing in setup wizard and the     |
| site.                                                                    |
|                                                                          |
| |image5| Posted by andre.romcke@ez.no at Sep 08, 2014 14:52              |
+--------------------------------------------------------------------------+
| In the "Setting up folder permission"-section, it would be nice if it    |
| was more clealy defined what is the user and what is a group in the      |
| example, instead of just overrall usage of www-data (especially the      |
| setcfacl commands). Thanks                                               |
|                                                                          |
| |image6| Posted by nmharald at Sep 16, 2014 12:28                        |
+--------------------------------------------------------------------------+
| Seeing a 404 on ezsetup? Don't forget the htaccess/virtualhost           |
| configuration: \ `Apache <Apache_22937704.html>`__                       |
|                                                                          |
| |image7| Posted by arnottg at Dec 10, 2014 17:58                         |
+--------------------------------------------------------------------------+

Document generated by Confluence on Mar 03, 2015 15:12

.. |image0| image:: images/icons/contenttypes/comment_16.png
.. |image1| image:: images/icons/contenttypes/comment_16.png
.. |image2| image:: images/icons/contenttypes/comment_16.png
.. |image3| image:: images/icons/contenttypes/comment_16.png
.. |image4| image:: images/icons/contenttypes/comment_16.png
.. |image5| image:: images/icons/contenttypes/comment_16.png
.. |image6| image:: images/icons/contenttypes/comment_16.png
.. |image7| image:: images/icons/contenttypes/comment_16.png
