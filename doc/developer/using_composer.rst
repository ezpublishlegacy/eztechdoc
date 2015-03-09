#. `eZ Publish Platform 5.x <index.html>`__
#. `eZ Publish Platform
   Documentation <eZ-Publish-Platform-Documentation_1114149.html>`__
#. `Developer Cookbook <Developer-Cookbook_11403951.html>`__

eZ Publish Platform 5.x : Using Composer
========================================

Created by andre.romcke@ez.no, last modified by
sarah.haim-lubczanski@ez.no on Jan 12, 2015

eZ Publish Platform 5.3 and higher

Icon

This page only applies to eZ Publish Platform 5.3 and higher, for
earlier versions of the Enterprise version of eZ Publish consult
S\ *ervice Portal user guide* available for download at
`support.ez.no <http://support.ez.no>`__. This page is also generic
about using Composer, for instructions specific to a release, see
`release notes <eZ-Publish-5.x-Releases_12781017.html>`__.

 

| Keeping your system up-to-date is important, to make sure your it is
running optimally and securely. The update mechanism in eZ Publish
Platform is using the *de facto* standard PHP packaging system called
`Composer <https://getcomposer.org/>`__.
| This makes it easy to adapt package installs and updates to your
workflow, allowing you to test new/updated packages in a development
environment, put the changes in your version control system (git,
Subversion, Mercurial, etc.), pull in those changes on a staging
environment and, when approved, put it in production.

 

 

-  `Installing Composer <#UsingComposer-InstallingComposer>`__
-  `Prerequisite to using
   composer <#UsingComposer-Prerequisitetousingcomposer>`__

   -  `Setting up Authentication tokens for access to commercial
      updates <#UsingComposer-SettingupAuthenticationtokensforaccesstocommercialupdates>`__

      -  `Optional: Save authentication information in auth.json to
         avoid repeatedly typing
         it <#UsingComposer-Optional:Saveauthenticationinformationinauth.jsontoavoidrepeatedlytypingit>`__

-  `Update workflow Using
   composer <#UsingComposer-UpdateworkflowUsingcomposer>`__

   -  `1. Running composer update and version changes in
      development <#UsingComposer-1.Runningcomposerupdateandversionchangesindevelopment>`__
   -  `2. Installing versioned updates on other development machines
      and/or staging ->
      production <#UsingComposer-2.Installingversionedupdatesonotherdevelopmentmachinesand/orstaging->production>`__

-  `General notes on use of
   composer <#UsingComposer-Generalnotesonuseofcomposer>`__

   -  `Installing additional eZ packages via
      composer <#UsingComposer-InstallingadditionaleZpackagesviacomposer>`__
   -  `Using Composer with
      Legacy <#UsingComposer-UsingComposerwithLegacy>`__
   -  `Dump autoload <#UsingComposer-Dumpautoload>`__

**Composer**

`Composer <https://getcomposer.org/>`__ is an opensource PHP packaging
system to manage dependencies.

This makes it easy to adapt package installs and updates to your
workflow, allowing you to test new/updated packages in a development
environment, put the changes in your version control system (git,
Subversion, Mercurial, etc.), pull in those changes on a staging
environment and, when approved, put it in production.

Installing Composer
===================

 

| This step is only needed once per machine (per project by default, but
installing globally on the machine is also possible. For alternatives
see: \ `https://getcomposer.org/download/ <https://getcomposer.org/download/>`__).
| Composer is a command line tool, so the main way to install it is via
command-line, example:

**composer download in current folder:**

.. code:: theme:

    php -r "readfile('https://getcomposer.org/installer');" | php

NB: this should be executed in the root directory of your eZ Publish
installation.

Prerequisite to using composer
==============================

Setting up Authentication tokens for access to commercial updates
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Out of the box composer uses a packaging repository called
`packagist.org <https://packagist.org/>`__ to find all open source
packages and their updates. Additional commercial packages are available
for the eZ Publish Platform at
`updates.ez.no/bul/ <https://updates.ez.no/bul/>`__ *(which is password
protected, you will need to set up authentication tokens as described
below to get access)*.

To get access to these updates log in to your service portal on
`support.ez.no <https://support.ez.no>`__. If your project is configured
for eZ Publish Platform 5.3 or higher, you will see the following on the
*"Maintenance and Support agreement details"* screen:

|image0|

#. Click "Create token"
#. Fill in a label describing the use of the token. This will allow you
   to revoke access later

   -  Example, if you need to provide access to updates to a third party
      a good to example would be "53-upgrade-project-by-partner-x"

#. Copy the password, **you will not get access to this again**!

When running composer to get updates, you will be asked for a Username
and Password. Use:

as Username: your Installation key found higher up on the *"Maintenance
and Support agreement details"* page in the support portal

as Password: the token password you retrieved in step 3. 

Optional: Save authentication information in auth.json to avoid repeatedly typing it
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Composer will ask to do this for you on updates, however if it is
disabled you can create \ ``auth.json`` file manually in one of the
following ways:

*Option A: *\ Store your credentials in project directory:

.. code:: theme:

    composer config http-basic.updates.ez.no <installation-key> <token-password>

*Option B:* If you rather want to install it globally
in \ `COMPOSER\_HOME <https://getcomposer.org/doc/03-cli.md#composer-home>`__ directory
for machine-wide use:

.. code:: theme:

    composer config --global http-basic.updates.ez.no <installation-key> <token-password>

Update workflow Using composer
==============================

This section describes a best practice for use of composer, essentially
it suggests treating updates like other code/configuration/\* changes on
your project tackling them on a development machine before staging them
for roll out on staging/production.  

1. Running composer update and version changes in development
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Updating eZ Publish Platform via composer is nothing different then
`updating other projects via
composer <https://getcomposer.org/doc/03-cli.md#update>`__, but for
illustration here is how you update your project locally:

**composer update**

.. code:: theme:

    php -d memory_limit=-1 composer.phar update --no-dev --prefer-dist

Tip

Icon

Tip: This will load in all updated packages, from eZ as well as third
party libraries both used by eZ and others you may have added. So when
updating like this it is recommended to take note of what was updated so
you have an idea of what you should test before putting the updates into
production.

At this stage you might need to manually clear Symfony's ``prod``
environment class cache (cached interfaces and lazy services) in case
the classes/interfaces in it has changed, this can be done in the
following way:

**optional prod class cache clearing**

.. code:: theme:

    rm -f ezpublish/cache/prod/*.php

When update has completed, and local install is verified to work, make
sure to version (assuming you use a version control system like *git*)
changes done to \ ``composer.lock`` file. This is the file that contains
**all details of which versions are currently used** and makes sure the
same version is used among all developers, staging and eventually
production when current changes are approved for production (assuming
you have a workflow for this).

 

Tip

Icon

Tip2: In large development teams make sure people don't blindly update
and install third party components, this might easily lead to version
conflicts on composer.lock file and can be tiring to fix-up if happening
frequently. A workflow involving composer install and unit test
execution on proposed changes can help avoid most of this,
like available via Github/Bitbucket Pull Request workflow.

2. Installing versioned updates on other development machines and/or staging -> production
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Installing eZ Publish Platform packages via Composer is nothing
different then \ `installing vanilla packages via
Composer <https://getcomposer.org/doc/03-cli.md#install>`__, and for
illustration here is how you install versioned updates:

**composer install (package installation)**

.. code:: theme:

    php -d memory_limit=-1 composer.phar install --no-dev --prefer-dist

Tip

Icon

Tip: Here the importance of composer.lock comes in as this command will
tell composer to install packages in exactly same version as defined in
composer.lock. If you don't keep track of composer.lock it will instead
just install always latests version of a package, hence not allow you to
stage updates before moving it towards production.

General notes on use of composer
================================

Installing additional eZ packages via composer
----------------------------------------------

Also requiring eZ Publish Platform packages via composer is nothing
different then \ `requiring vanilla packages via
Composer <https://getcomposer.org/doc/03-cli.md#require>`__, and for
illustration here is how you install a eZ package:

**composer install (package installation)**

.. code:: theme:

    php -d memory_limit=-1 composer.phar require --prefer-dist ezsystems/ezfind-ls:5.3.*

Using Composer with Legacy
--------------------------

| (eZ Publish) Legacy by design places all important customizable
folders within it's own structure. This is not ideal with Composer, as
installation and updates might cause them to become as provided by
packages again.
| To make sure you are safe from this, and to allow you to version these
custom folders independently,\ **it is recommended that you use
symlinks** and keep your custom settings, extensions and design
**outside of the ezpublish\_legacy folder**. To not have to manually
deal with these symlinks it is recommended to use Composer
``post-install-cmd`` and ``post-update-command`` script commands to make
this automated.

Affected extensions

Icon

All extensions not provided via composer is affected by this, currently
the following extensions from eZ is not provided via composer and needs
to be setup like proposed in this section: *eznetwork,
ezrecommendation*\ and\ *ezma*.

 

Below is a illustration on how this can be setup, see `Composer
documentation for further
info <https://getcomposer.org/doc/articles/scripts.md>`__.

**Example on composer.json symlinking**

.. code:: theme:

    {
        "scripts": {
            "post-install-cmd": [
                "MyVendor\\MyClass::symlinkLegacyFolders"
            ],
            "post-update-cmd": [
                "MyVendor\\MyClass::symlinkLegacyFolders"
            ]
        }
    }

Icon

This functionality is desirable to have out of the box in the future, so
community contributions on this topic is welcome to find a good standard
convention and script to handle it.

Dump autoload
-------------

Avoid to use the following command:

``php -d memory_limit=-1 composer.phar dump-autoload --optimize``

Warning

Icon

It causes a PHP Warning "Ambiguous class resolution". For further
information `this issue to Stash Github
repository. <https://github.com/tedious/Stash/issues/181>`__

The dumped file will be too big and can cause an overhead for any
request, even Cache.

 

 

 

Attachments:
------------

| |image1| `Screen Shot 2014-06-02 at 12.54.06
.png <attachments/23527865/23887880.png>`__ (image/png)

Document generated by Confluence on Mar 03, 2015 15:13

.. |image0| image:: attachments/23527865/23887880.png?effects=drop-shadow
.. |image1| image:: images/icons/bullet_blue.gif
