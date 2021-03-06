#. `eZ Publish Platform 5.x <index.html>`__
#. `eZ Publish Platform
   Documentation <eZ-Publish-Platform-Documentation_1114149.html>`__
#. `Installation and Upgrade
   Guides <Installation-and-Upgrade-Guides_6292016.html>`__
#. `Requirements <Requirements_7438502.html>`__

eZ Publish Platform 5.x : Install notes for eZ Publish on RHEL 6
================================================================

Created by andrea.melo@ez.no, last modified by ricardo.correia@ez.no on
May 21, 2013

 

Required RPMs
-------------

 

+--------------------------------------+--------------------------------------+
| php-pear-Net-Curl                    | Required by ezfind                   |
+--------------------------------------+--------------------------------------+
| php-pear-Date                        | Red Hat's rpm for datetime           |
+--------------------------------------+--------------------------------------+
| php-mbstring                         | Required by ezini                    |
+--------------------------------------+--------------------------------------+
| php-pecl-apc                         | The supported rpm equivalent to the  |
|                                      | pear install                         |
+--------------------------------------+--------------------------------------+
| php-process                          | Required for eZ scripts and cron     |
|                                      | jobs                                 |
+--------------------------------------+--------------------------------------+
| php-mcrypt                           |                                      |
+--------------------------------------+--------------------------------------+
| php-xml                              |                                      |
+--------------------------------------+--------------------------------------+
| php-pgsql                            | PostgreSQL support                   |
+--------------------------------------+--------------------------------------+
| php-mysql                            | MySQL support                        |
+--------------------------------------+--------------------------------------+
| php-mbstring                         | **Note:** Available from the         |
|                                      | optional rpm channel                 |
+--------------------------------------+--------------------------------------+

RHEL 6 and CentOS 6: EPEL
-------------------------

| Some of the listed rpms are only available through EPEL. Extra
Packages for Enterprise Linux (EPEL) is a Fedora Special Interest Group
that creates, maintains, and manages a high quality set of additional
packages for Enterprise Linux, including, but not limited to, Red Hat
Enterprise Linux (RHEL), CentOS and Scientific Linux (SL).
| `http://fedoraproject.org/wiki/EPEL#How\_can\_I\_use\_these\_extra\_packages.3F <http://fedoraproject.org/wiki/EPEL#How_can_I_use_these_extra_packages.3F>`__

::

    $ rpm -Uvh http://fedora.uib.no/epel/6/x86_64/epel-release-6-5.noarch.rpm

Best practice will be to disable EPEL by default and only enable it for
specific rpm installs with the yum option "``--enablerepo=epel``\ ". To
disable it, set "``enabled=0``\ " in "``/etc/yum.repos.d/epel.repo``\ ".

Red Hat Network
---------------

RHEL 6.1: The Certificate-based RHN
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

| If upgrading from RHEL 6 to RHEL 6.1, you would like to use the new
subscription system:
| For a first-time certificate-based RHN registration:

#. Run the command

   ::

       subscription-manager register

#. Log into
   `https://access.redhat.com/management/consumers/ <https://access.redhat.com/management/consumers/>`__

   #. Click on the registered system in the consumer list
   #. Find the list of available subscriptions
   #. Subscribe to the relevant subscriptions

#. Run the command

   ::

       subscription-manager subscribe --auto

#. Run the command

   ::

       yum update

   and all subscribed repos will be configured

    

With the certificate-based RHN, additional channels are not added
through manual configuration. Additional rpm repositories are listed in
``/etc/yum.repos.d/redhat.repo``, but are disabled by default. Yum
install using the ``--enablerepo`` option and notice that the
repositories may look different based on the installed product.

::

    $ yum --enablerepo=rhel-6-server-optional-rpms install php-process

 

RHEL 6.0: The classic RHN
~~~~~~~~~~~~~~~~~~~~~~~~~

-  Log into Red Hat Network
-  Click on "Channels" in the menu bar.
-  Click "Red Hat Optional Server 6", "target systems" and enable this
   channel for your server

Document generated by Confluence on Mar 03, 2015 15:12
