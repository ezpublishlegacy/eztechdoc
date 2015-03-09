#. `eZ Publish Platform 5.x <index.html>`__
#. `eZ Publish Platform
   Documentation <eZ-Publish-Platform-Documentation_1114149.html>`__
#. `Development & Administration Guides <6291674.html>`__
#. `Features <Features_12781009.html>`__
#. `MVC and Application <MVC-and-Application_2719826.html>`__
#. `Configuration <Configuration_2720538.html>`__

eZ Publish Platform 5.x : Dynamic settings injection
====================================================

Created by sarah.haim-lubczanski@ez.no, last modified by
jerome.vieilledent@ez.no on Nov 07, 2014

5.4 / 2014.11

-  `Description <#Dynamicsettingsinjection-Description>`__
-  `Usage <#Dynamicsettingsinjection-Usage>`__

   -  `Syntax <#Dynamicsettingsinjection-Syntax>`__
   -  `DynamicSettingParser <#Dynamicsettingsinjection-DynamicSettingParser>`__

-  `Limitations <#Dynamicsettingsinjection-Limitations>`__
-  `Examples <#Dynamicsettingsinjection-Examples>`__

   -  `Injecting an eZ
      parameter <#Dynamicsettingsinjection-InjectinganeZparameter>`__
   -  `Before 5.4 <#Dynamicsettingsinjection-Before5.4>`__
   -  `After, with setter injection
      (preferred) <#Dynamicsettingsinjection-After,withsetterinjection(preferred)>`__
   -  `After, with constructor
      injection <#Dynamicsettingsinjection-After,withconstructorinjection>`__
   -  `Injecting 3rd party
      parameters <#Dynamicsettingsinjection-Injecting3rdpartyparameters>`__

Description
-----------

| Before 5.4, if one wanted to implement a service needing
siteaccess-aware settings (e.g. language settings),
|  they needed to inject the whole ``ConfigResolver``
(``ezpublish.config.resolver``) and get the needed settings from it.

| This was not very convenient nor explicit.
|  Goal of this feature is to allow developers to inject these dynamic
settings explicitly from their service definition (yml, xml,
annotation...).

Usage
-----

Syntax
~~~~~~

Static container parameters follows the ``%<parameter_name>%`` syntax in
Symfony.

| Dynamic parameters have the following:
``$<parameter_name>[; <namespace>[; <scope>]]$``, default namespace
being ``ezsettings``,
|  and default scope being current siteaccess.

Icon

For more information, see `ConfigResolver
documentation <https://confluence.ez.no/display/EZP/Configuration#Configuration-DynamicconfigurationwiththeConfigResolver>`__.

DynamicSettingParser
~~~~~~~~~~~~~~~~~~~~

| This feature also introduces a *DynamicSettingParser* service that can
be used for adding support of the dynamic settings syntax.
|  This service has ``ezpublish.config.dynamic_setting.parser`` for ID
and implements
| ``eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\DynamicSettingParserInterface``.

Limitations
-----------

A few limitations still remain:

-  It is not possible to use dynamic settings in your semantic
   configuration (e.g. ``config.yml`` or ``ezpublish.yml``) as they are
   meant primarily for parameter injection in services.
-  It is not possible to define an array of options having dynamic
   settings. They will not be parsed. Workaround is to use separate
   arguments/setters.
-  Injecting dynamic settings in request listeners is **not
   recommended**, as it won't be resolved with the correct scope
   (request listeners are **instantiated before SiteAccess match**).
   Workaround is to inject the ConfigResolver instead, and resolving the
   your setting in your ``onKernelRequest`` method (or equivalent).

Examples
--------

Injecting an eZ parameter
~~~~~~~~~~~~~~~~~~~~~~~~~

Defining a simple service needing ``languages`` parameter (i.e.
prioritized languages).

Note

Icon

Internally, ``languages`` parameter is defined as
``ezsettings.<siteaccess_name>.languages``, ``ezsettings`` being eZ
internal *namespace*.

**Before 5.4
**
~~~~~~~~~~~~

.. code:: theme:

    parameters:
        acme_test.my_service.class: Acme\TestBundle\MyServiceClass

    services:
        acme_test.my_service:
            class: %acme_test.my_service.class%
            arguments: [@ezpublish.config.resolver]

    namespace Acme\TestBundle;

**
**

.. code:: theme:

    use eZ\Publish\Core\MVC\ConfigResolverInterface;

    class MyServiceClass
    {
        /**
     * Prioritized languages
     *
     * @var array
     */
        private $languages;

        public function __construct( ConfigResolverInterface $configResolver )
        {
            $this->languages = $configResolver->getParameter( 'languages' );
        }
    }

**After, with setter injection (preferred)**
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code:: theme:

    parameters:
        acme_test.my_service.class: Acme\TestBundle\MyServiceClass

    services:
        acme_test.my_service:
            class: %acme_test.my_service.class%
            calls:
                - [setLanguages, ["$languages$"]]

.. code:: theme:

    namespace Acme\TestBundle;

    class MyServiceClass
    {
        /**
     * Prioritized languages
     *
     * @var array
     */
        private $languages;

        public function setLanguages( array $languages = null )
        {
            $this->languages = $languages;
        }
    }

 

 

Icon

**Important**: Ensure you always add ``null`` as a default value,
especially if the argument is type-hinted.

**After, with constructor injection**
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code:: theme:

    parameters:
        acme_test.my_service.class: Acme\TestBundle\MyServiceClass

    services:
        acme_test.my_service:
            class: %acme_test.my_service.class%
            arguments: ["$languages$"]

 

 

.. code:: theme:

    namespace Acme\TestBundle;

    class MyServiceClass
    {
        /**
     * Prioritized languages
     *
     * @var array
     */
        private $languages;

        public function __construct( array $languages )
        {
            $this->languages = $languages;
        }
    }

 

 

Tip

Icon

Setter injection for dynamic settings should always be preferred, as it
makes it possible to update your services that depend on them when
ConfigResolver is updating its scope (e.g. when previewing content in a
given SiteAccess). **However, only one dynamic setting should be
injected by setter**.

**Constructor injection will make your service be reset in that case.**

Injecting 3rd party parameters
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

 

.. code:: theme:

    parameters:
        acme_test.my_service.class: Acme\TestBundle\MyServiceClass
        # "acme" is our parameter namespace.
        # Null is the default value.
        acme.default.some_parameter: ~
        acme.ezdemo_site.some_parameter: foo
        acme.ezdemo_site_admin.some_parameter: bar
     
    services:
        acme_test.my_service:
            class: %acme_test.my_service.class%
            # The following argument will automatically resolve to the right value, depending on the current SiteAccess.
            # We specify "acme" as the namespace we want to use for parameter resolving.
            calls:
                - [setSomeParameter, ["$some_parameter;acme$"]]

.. code:: theme:

    namespace Acme\TestBundle;
    class MyServiceClass
    {
        private $myParameter;
        public function setSomeParameter( $myParameter = null )
        {
            // Will be "foo" for ezdemo_site, "bar" for ezdemo_site_admin, or null if another SiteAccess.
            $this->myParameter = $myParameter;
        }
    }

 

::

     

Document generated by Confluence on Mar 03, 2015 15:12
