#. `eZ Publish Platform 5.x <index.html>`__
#. `eZ Publish Platform
   Documentation <eZ-Publish-Platform-Documentation_1114149.html>`__
#. `Developer Cookbook <Developer-Cookbook_11403951.html>`__
#. `Using Composer <Using-Composer_23527865.html>`__

eZ Publish Platform 5.x : Composer for Frontend Developers
==========================================================

Created and last modified by sarah.haim-lubczanski@ez.no on Sep 29, 2014

If you are web designer, or working on the CSS on your website, this
documentation is all you need to know about Composer.

**Composer**

`Composer <https://getcomposer.org/>`__ is an opensource PHP packaging
system to manage dependencies.

This makes it easy to adapt package installs and updates to your
workflow, allowing you to test new/updated packages in a development
environment, put the changes in your version control system (git,
Subversion, Mercurial, etc.), pull in those changes on a staging
environment and, when approved, put it in production.

 

Troubleshooting
===============

You may experience some latency in dependency resolution : everything is
going normally.

If you are interested by the process, do your Composer commands with the
--verbose option activated.

Option verbose -v
~~~~~~~~~~~~~~~~~

Increase the verbosity of messages: 1 for normal output, 2 for more
verbose output and 3 for debug

Usage:
^^^^^^

.. code:: theme:

    php -d memory_limit=-1 composer.phar <command> --verbose (-v|vv|vvv)

Useful commands
===============

install
-------

The install command reads the composer.lock file from the current
directory, processes it, and downloads and installs all the libraries
and dependencies outlined in that file. If the file does not exist it
will look for composer.json and do the same.

Usage
~~~~~

.. code:: theme:

    php -d memory_limit=-1 composer.phar install --dry-run --prefer-dist

In this example the dry-run option is mentioned to prevent you to do
anything critical. (This option outputs the operations but will not
execute anything and implicitly enables the verbose mode).

Documentation with complete usage:
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code:: theme:

    php -d memory_limit=-1 composer.phar install [--prefer-source] [--prefer-dist] [--dry-run] [--dev] [--no-dev] [--no-plugins] [--no-custom-installers] [--no-scripts] [--no-progress] [-v|vv|vvv|--verbose] [-o|--optimize-autoloader] [packages1] ... [packagesN]

update
------

 The update command reads the composer.json file from the current
directory, processes it, and updates, removes or installs all the
dependencies.

Interesting options:
~~~~~~~~~~~~~~~~~~~~

To limit the update operation to a few packages, you can list the
package(s) you want to update as such:

.. code:: theme:

    php -d memory_limit=-1 composer.phar update vendor/package1 foo/mypackage 

 You may also use an asterisk (\*) pattern to limit the update operation
to package(s) from a specific vendor:

.. code:: theme:

    php -d memory_limit=-1 composer.phar update vendor/package1 foo/* 

 

 

 

 

 

 

Document generated by Confluence on Mar 03, 2015 15:13
