#. `eZ Publish Platform 5.x <index.html>`__
#. `eZ Publish Platform
   Documentation <eZ-Publish-Platform-Documentation_1114149.html>`__
#. `Installation and Upgrade
   Guides <Installation-and-Upgrade-Guides_6292016.html>`__
#. `Upgrade <Upgrade_19234967.html>`__

eZ Publish Platform 5.x : Upgrading from 5.3 to 5.4
===================================================

Created and last modified by andre.romcke@ez.no on Jan 26, 2015

-  `Note on Paths <#Upgradingfrom5.3to5.4-NoteonPaths>`__
-  `Check for
   requirements <#Upgradingfrom5.3to5.4-Checkforrequirements>`__
-  `Upgrade steps <#Upgradingfrom5.3to5.4-Upgradesteps>`__

   -  `Step 1: Upgrade the legacy distribution
      files <#Upgradingfrom5.3to5.4-Step1:Upgradethelegacydistributionfiles>`__
   -  `Step 2: upgrade custom legacy
      extensions <#Upgradingfrom5.3to5.4-Step2:upgradecustomlegacyextensions>`__
   -  `Step 3: upgrade the
      database <#Upgradingfrom5.3to5.4-Step3:upgradethedatabase>`__
   -  `Step 4: Apply 5.4 configuration
      changes <#Upgradingfrom5.3to5.4-Step4:Apply5.4configurationchanges>`__

      -  `YAML files <#Upgradingfrom5.3to5.4-YAMLfiles>`__

         -  `ezpublish/config/config.yml <#Upgradingfrom5.3to5.4-ezpublish/config/config.yml>`__
         -  `ezpublish/config/config\_dev.yml <#Upgradingfrom5.3to5.4-ezpublish/config/config_dev.yml>`__
         -  `ezpublish/config/config\_prod.yml <#Upgradingfrom5.3to5.4-ezpublish/config/config_prod.yml>`__
         -  `ezpublish/config/routing.yml <#Upgradingfrom5.3to5.4-ezpublish/config/routing.yml>`__
         -  `ezpublish/config/parameters.yml.dist <#Upgradingfrom5.3to5.4-ezpublish/config/parameters.yml.dist>`__
         -  `ezpublish/config/ezpublish\*.yml <#Upgradingfrom5.3to5.4-ezpublish/config/ezpublish*.yml>`__

      -  `ezpublish/EzPublishKernel.php <#Upgradingfrom5.3to5.4-ezpublish/EzPublishKernel.php>`__
      -  `composer.json <#Upgradingfrom5.3to5.4-composer.json>`__
      -  `Varnish (if
         applicable) <#Upgradingfrom5.3to5.4-Varnish(ifapplicable)>`__
      -  `Update the DFS cluster
         configuration <#Upgradingfrom5.3to5.4-UpdatetheDFSclusterconfiguration>`__
      -  `Web server
         configuration <#Upgradingfrom5.3to5.4-Webserverconfiguration>`__
      -  `Final step: web server rewrite
         rules <#Upgradingfrom5.3to5.4-Finalstep:webserverrewriterules>`__

   -  `Step 5: Run composer
      update <#Upgradingfrom5.3to5.4-Step5:Runcomposerupdate>`__
   -  `Step 6: Regenerate the autoload array for
      extensions <#Upgradingfrom5.3to5.4-Step6:Regeneratetheautoloadarrayforextensions>`__
   -  `Step 7: Link assets <#Upgradingfrom5.3to5.4-Step7:Linkassets>`__
   -  `Step 8: Clear the
      caches <#Upgradingfrom5.3to5.4-Step8:Clearthecaches>`__

| 

This section describes how to upgrade your existing eZ Publish 5.3
installation to version 5.4. Make sure that you have a working backup of
the site before you do the actual upgrade, and make sure that the
installation you are performing the upgrade on is offline.

Note on Paths
-------------

-  */<ezp5-root>/*: The root directory where eZ Publish 5 is installed
   in, examples: "*/home/myuser/www*/" or "*/var/sites/ezpublish/*\ "
-  */<ezp5-root>/ezpublish\_legacy/*:  Root directory of "Legacy" (aka
   "Legacy Stack", refers to the eZ Publish 4.x installation which is
   bundled with eZ Publish 5) normally inside "*ezpublish\_legacy*/",
   example: "*/home/myuser/www/ezpublish\_legacy/*\ "

Check for requirements
----------------------

PHP 5.4.4 and higher is needed. Further information regarding system
requirements can be found on \ `Requirements Documentation
Page <https://confluence.ez.no/display/EZP/Requirements>`__.

Upgrade steps
-------------

Step 1: Upgrade the legacy distribution files
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

The easiest way to upgrade the distribution files is to unpack eZ
Publish 5.4 to a separate directory and then copy the directories that
contain site-specific files from the existing 5.3 installation into
"*/<ezp5-root>/*\ ". Make sure you copy the following directories:

-  ``ezpublish_legacy/design/<your designs>`` (do NOT include built-in
   designs: admin, base, standard or admin2)
-  ``ezpublish_legacy/var/<your_var_dir>/storage``
-  ``ezpublish_legacy/var/storage/packages``
-  ``ezpublish_legacy/settings/siteaccess/<your_siteaccesses>``
-  ``ezpublish_legacy/settings/override/*``
-  ``ezpublish_legacy/extension/*`` (not including the built-in /
   standalone ones: ezflow, ezjscore, ezoe, ezodf, ezie, ezmultiupload,
   ezmbpaex, ez\_network, ezprestapiprovider, ezscriptmonitor, ezsi,
   ezfind)
-  src/
-  ``ezpublish_legacy/config.php`` &
   ezpublish\_legacy/\ ``config.cluster.php``, if applicable
-  ``ezpublish/config/*.yml``

***NB:** Since writable directories and files have been replaced /
copied, their permissions might have changed. You may have to
reconfigure webserver user permissions on specific folders as explained
in the file \ `permissions chapter of the installation
process <https://confluence.ez.no/pages/viewpage.action?pageId=7438581#InstallingeZPublishonaLinux%2FUNIXbasedsystem-Settingupfolderpermission>`__.*

Step 2: upgrade custom legacy extensions
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

If you are using custom extensions, the sub-directories inside the
"extension" directory will also have to be copied from the existing 5.3
installation into "*/<ezp5-root>/ezpublish\_legacy/extension/*\ ".
However, make sure that you do not overwrite any extensions that are
included in eZ Publish distribution, which currently are (***Note:** In
eZ Publish Platform 5.4, extensions have version number 5.3 with
exception of ezdemo, ezoe, ezformtoken, ezjscore and ezfind*):

Note that upgrading the distribution files will overwrite the autoload
arrays for extensions. You will need to re-generate the autoload arrays
for active extensions later.

***Important: **\ If you plan to upgrade your eZ Website Interface, eZ
Flow or eZ Demo site package as well, then additional extensions will be
updated and the step for re-generate the autoload arrays can be skipped
until that is done (links to documentation for upgrading these site
packages can be found in the last step of this page).*

Step 3: upgrade the database
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Icon

This step assumes use of the built in database drivers, mysql (incl
mariadb) and PostgreSQL, for other databases supported via extension
please use scripts and documentation provided by extension.

Import to your database the changes provided in

``/<ezp5-root>/ezpublish_legacy/update/database/<mysql|postgresql>/5.4/dbupdate-5.3.0-to-5.4.0.sql``

| If the installation is using the DFS cluster, import the cluster
database changes provided in
| ``/<ezp5-root>/ezpublish_legacy/update/database/mysql/5.4/dbupdate-cluster-5.3.0-to-5.4.0.sql``

Step 4: Apply 5.4 configuration changes
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

YAML files
^^^^^^^^^^

| Since default configuration files have been overwritten during step
one, the few additions to those files that were made in 5.3 need to be
applied manually to the configuration files.
| All of those changes are \ **additions**, none of them replaces what
you already have.

For most of them, at least one, if not all hierarchy elements (monolog,
handler, framework, router...) will already be there. All you have to do
is **add the missing bits in the existing configuration block**\ s.

ezpublish/config/config.yml
'''''''''''''''''''''''''''

*trusted\_hosts* has been changed and *session.handler\_id* is added to
the *framework* block making Symfony pick what has been configured in
PHP instead.

.. code:: theme:

    framework:
        trusted_hosts:   ~

        session:
            handler_id:  ~

Additionally configuration for *swift\_mailer* has been added:

.. code:: theme:

    swiftmailer:
        transport: "%mailer_transport%"
        host:      "%mailer_host%"
        username:  "%mailer_user%"
        password:  "%mailer_password%"
        spool:     { type: memory }

ezpublish/config/config\_dev.yml
''''''''''''''''''''''''''''''''

In framework, set *router.strict\_requirements* to true.

.. code:: theme:

    framework:
        router:
            resource: "%kernel.root_dir%/config/routing_dev.yml"
            strict_requirements: true

ezpublish/config/config\_prod.yml
'''''''''''''''''''''''''''''''''

Remove *framework.router.strict\_requirements* completely.

ezpublish/config/routing.yml
''''''''''''''''''''''''''''

Add the liip imagine routes to the file:

.. code:: theme:

    _liip_imagine:
      resource: "@LiipImagineBundle/Resources/config/routing.xml"

ezpublish/config/parameters.yml.dist
''''''''''''''''''''''''''''''''''''

If you have added anything to ``parameters.yml``, we suggest that you
add your custom settings to ``parameters.yml.dist``, so that the
composer post-update script handles those, and generates their values
correctly.

*ezpublish\_legacy.default.view\_default\_layout* can be removed from
this file, and the following added:

.. code:: theme:

    parameters:
        mailer_transport:  smtp
        mailer_host:       127.0.0.1
        mailer_user:       ~
        mailer_password:   ~

composer will ask for your own values when you run *composer update*.

ezpublish/config/ezpublish\*.yml
''''''''''''''''''''''''''''''''

In all ezpublish.yml files (prod, dev, etc), replace the
"**handlers**\ " key in *stash.caches.\** with "**drivers**\ ".

.. code:: theme:

    stash:
         caches:
             default:
                drivers:

ezpublish/EzPublishKernel.php
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

It is not possible to just copy your old ``EzPublishKernel.php`` file
over from the previous installation, since quite a few changes were made
to this file in this release. We suggest that you simply update the new
kernel file with any changes you made in the previous version.

New bundles in this version
are \ *EzPublishIOBundle*, \ *FOSHttpCacheBundle*, \ *LiipImagineBundle*, \ *WhiteOctoberBreadcrumbsBundle*, \ *KnpMenuBundle*, \ *OneupFlysystemBundle*
and \ *SensioFrameworkExtraBundle*.

composer.json
^^^^^^^^^^^^^

If you had modified ``composer.json`` to add your own requirements, you
must re-apply those changes to the new version.

*Note: Besides requirements changes there are also changes to other
parts of composer.json, including improvements also found in
`5.3.3 <5.3.3-Release-Notes_23528625.html>`__*\ *and
`5.3.4 <5.3.4-Release-Notes_25985326.html>`__*\ *.*

Varnish (if applicable)
^^^^^^^^^^^^^^^^^^^^^^^

The recommended varnish (3 and 4) VCL configuration can now be found in
the ``doc/varnish`` folder. See also the \ `Using
Varnish <Using-Varnish_12124722.html>`__ page.

Update the DFS cluster configuration
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

If your legacy installation uses DFS clustering, you need to \ `create
the new stack configuration for
it <Upgrading-DFS-cluster-to-5.4_25985794.html>`__.

Web server configuration
^^^^^^^^^^^^^^^^^^^^^^^^

The officially recommended virtual configuration is now shipped in the
``doc`` folder, for both apache2 (``doc/apache2``) and nginx
(``doc/nginx``). Both are built to be easy to understand and use, but
aren't meant as drop-in replacements for your existing configuration.

One notable change is that ``SetEnvIf`` is now used to dynamically
change rewrite rules depending on the Symfony environment. It is
currently used for the assetic production rewrite rules.

Read more on the `Web servers <Web-servers_22937700.html>`__ page.

Final step: web server rewrite rules
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

This is reflected in the apache2 and nginx configuration files that are
shipped in the doc folder. The main change from legacy is that requests
for images can now be rewritten to \ ``web/index.php`` instead of
``ezpublish_legacy/index_cluster.php``.

Step 5: Run composer update
~~~~~~~~~~~~~~~~~~~~~~~~~~~

Run ``composer update --no-dev --prefer-dist`` to get the latest eZ
Publish dependencies.

At the end of the process, you will be asked for values for the
parameters previously added to \ ``parameters.yml.dist``.

Step 6: Regenerate the autoload array for extensions
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

To regenerate the autoload array, execute the following script from the
root of your eZ Publish Legacy directory:

.. code:: theme:

    cd ezpublish_legacy
    php bin/php/ezpgenerateautoloads.php --extension

Step 7: Link assets
~~~~~~~~~~~~~~~~~~~

Assets from the various bundles need to be made available for the
webserver through the web/ document root.

The following commands will first symlink eZ Publish 5 assets in
"Bundles" and the second will symlink assets (design files like images,
scripts and css, and files in var folder)  from eZ Publish Legacy:

.. code:: theme:

    php ezpublish/console assets:install --symlink
    php ezpublish/console ezpublish:legacy:assets_install --symlink
    php ezpublish/console assetic:dump --env=prod

Step 8: Clear the caches
~~~~~~~~~~~~~~~~~~~~~~~~

| Whenever an eZ Publish solution is upgraded, all caches must be
cleared in a proper way. This should be done from within a system shell:
| Navigate into the new eZ Publish directory.Run the script using the
following shell command:
``cd /<ezp5-root>/ezpublish_legacy/; php bin/php/ezcache.php --clear-all --purge``.
Purging ensures that the caches are physically removed. When the
"--purge" parameter is not specified, the caches will be expired but not
removed.
| Note: Sometimes the script is unable to clear all cache files because
of restrictive file/directory permission settings. Make sure that all
cache files have been cleared by inspecting the contents of the various
cache sub-directories within the "var" directory (typically the
"var/cache/" and "var/<name\_of\_siteaccess>/cache/" directories). If
there are any cache files left, you need to remove them manually.

Comments:
---------

+--------------------------------------------------------------------------+
|     It is not possible to just copy your                                 |
|     old \ ``EzPublishKernel.php`` file over from the previous            |
|     installation                                                         |
|                                                                          |
| If you choose to ignore this warning then take care: the ``new``         |
| instances must be kept in order. Specifically:                           |
| ``EzPublishCoreBundle() ``\ must appear after \ ``LiipImagineBundle()``, |
| as eZ overrides parameters in that bundle.                               |
|                                                                          |
| |image2| Posted by arnottg at Dec 09, 2014 15:01                         |
+--------------------------------------------------------------------------+
| "composer update --no-dev --prefer-dist" does not work (tried on windows |
| 7). It gives the following error :                                       |
|                                                                          |
| [InvalidArgumentException]                                               |
|                                                                          |
|   The "../ezpublish/../ezpublish\_legacy/design/" directory does not     |
| exist.                                                                   |
|                                                                          |
| (`see bug on Jira <https://jira.ez.no/browse/EZP-23710>`__)              |
|                                                                          |
| |image3| Posted by Hakim at Dec 10, 2014 07:42                           |
+--------------------------------------------------------------------------+

Document generated by Confluence on Mar 03, 2015 15:12

.. |image0| image:: images/icons/contenttypes/comment_16.png
.. |image1| image:: images/icons/contenttypes/comment_16.png
.. |image2| image:: images/icons/contenttypes/comment_16.png
.. |image3| image:: images/icons/contenttypes/comment_16.png
