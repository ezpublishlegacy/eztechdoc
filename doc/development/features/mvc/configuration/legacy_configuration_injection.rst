#. `eZ Publish Platform 5.x <index.html>`__
#. `eZ Publish Platform
   Documentation <eZ-Publish-Platform-Documentation_1114149.html>`__
#. `Development & Administration Guides <6291674.html>`__
#. `Features <Features_12781009.html>`__
#. `MVC and Application <MVC-and-Application_2719826.html>`__
#. `Configuration <Configuration_2720538.html>`__

eZ Publish Platform 5.x : Legacy configuration injection
========================================================

Created by andre.romcke@ez.no, last modified by
sarah.haim-lubczanski@ez.no on Feb 18, 2015

 

For better integration between 5.x (symfony based) kernel and legacy
(4.x) kernel, injection is used to inject settings,
`session <Legacy-session-injection_8323285.html>`__ and `current
siteaccess <Legacy-siteaccess-injection_8323272.html>`__ from 5.x into
legacy using an
event: \ `kernel.event\_subscriber <Legacy-kernel-event_8323280.html>`__

-  `Injected
   settings <#Legacyconfigurationinjection-Injectedsettings>`__

   -  `Database
      settings <#Legacyconfigurationinjection-Databasesettings>`__
   -  `Storage
      settings <#Legacyconfigurationinjection-Storagesettings>`__
   -  `Image settings <#Legacyconfigurationinjection-Imagesettings>`__
   -  `Using ImageMagick
      filters <#Legacyconfigurationinjection-UsingImageMagickfilters>`__
   -  `Extending injected
      settings <#Legacyconfigurationinjection-Extendinginjectedsettings>`__
   -  `Site settings <#Legacyconfigurationinjection-Sitesettings>`__

-  `Injected Behavior <#Legacyconfigurationinjection-InjectedBehavior>`__

   -  `eZFormToken (CSRF)
      integration <#Legacyconfigurationinjection-eZFormToken(CSRF)integration>`__
   -  `ezpEvent (Cache clear)
      integration <#Legacyconfigurationinjection-ezpEvent(Cacheclear)integration>`__

| 

Injected settings
-----------------

| Several settings are injected to avoid having to duplicate settings
across new and old kernel, this is done
in eZ\\Bundle\\EzPublishLegacyBundle\\LegacyMapper\\Configuration.
| For mappings below, yml settings prefixed with ezpublish are system
settings, while the rest are settings you can define per siteaccess.

For versions 5.1, 5.2 and 5.3

Icon

When viewing *ini* settings in the Administration Interface, settings
for other siteaccess may be incorrectly displayed if the configuration
has been modified in Symfony configuration.

 

Database settings
~~~~~~~~~~~~~~~~~

The settings for "Server", "Port", "User", "Password", "Database" and
"DatabaseImplementation" are set based on the current settings in your
yml files, either from the explicit settings defined below, or the "dsn"

**Mapping**:

yml

site.ini [DatabaseSettings]

server

Server

port

Port

user

User

password

Password

database\_name

Database

type

DatabaseImplementation

 

Storage settings
~~~~~~~~~~~~~~~~

The settings for "VarDir" and "StorageDir" are set based on current
settings in your yml files as shown below.

**Mapping:**

yml

site.ini [FileSettings]

var\_dir

VarDir

storage\_dir

StorageDir

 

Image settings
~~~~~~~~~~~~~~

Some of the settings for image sub system are set based on your yml
files as shown below.

**Mapping:**

yml

image.ini

ezpublish.image.temporary\_dir

[FileSettings]\\TemporaryDir

ezpublish.image.published\_images\_dir

[FileSettings]\\PublishedImages

ezpublish.image.versioned\_images\_dir

[FileSettings]\\VersionedImages

image\_variations

[FileSettings]\\AliasList

ezpublish.image.imagemagick.enabled

[ImageMagick]\\IsEnabled

ezpublish.image.imagemagick.executable\_path

[ImageMagick]\\ExecutablePath

ezpublish.image.imagemagick.executable

[ImageMagick]\\Executable

imagemagick.pre\_parameters

[ImageMagick]\\PreParameters

imagemagick.post\_parameters

[ImageMagick]\\PostParameters

ezpublish.image.imagemagick.filters

[ImageMagick]\\Filters

Image aliases : image\_variations

Icon

Note : for image\_variations the *small* value is referenced in ezoe
configuration and this configuration needs to be changed if the small
variation is removed.

 

Using ImageMagick filters
~~~~~~~~~~~~~~~~~~~~~~~~~

The following block shows a valid ImageMagick filter usage example for
``ezpublish.yml``:

**ImageMagick filters usage example**

.. code:: theme:

    ezpublish:
        imagemagick:
            filters:
                geometry/scale: "-geometry {1}x{2}"

Since ImageMagick filter usage changed from eZ Publish 4.x versions you
can find the list of filters existing by default to use eZ Publish 5.x:

ImageMagick filters list for yml

``sharpen: "-sharpen 0.5"``

``geometry/scale: "-geometry {1}x{2}"``

``geometry/scalewidth: "-geometry {1}"``

``geometry/scaleheight: "-geometry x{1}"``

``geometry/scaledownonly: "-geometry {1}x{2}>"``

``geometry/scalewidthdownonly: "-geometry {1}>"``

``geometry/scaleheightdownonly: "-geometry x{1}>"``

``geometry/scaleexact: "-geometry {1}x{2}!"``

``geometry/scalepercent: "-geometry {1}x{2}"``

``geometry/crop: "-crop {1}x{2}+{3}+{4}"``

``filter/noise: "-noise {1}"``

``filter/swirl: "-swirl {1}"``

``colorspace/gray: "-colorspace GRAY"``

``colorspace/transparent: "-colorspace Transparent"``

``colorspace: "-colorspace {1}"``

``border: "-border {1}x{2}"``

``border/color: "-bordercolor rgb({1},{2},{3})"``

``border/width: "-borderwidth {1}"``

``flatten: "-flatten"``

``resize: "-resize {1}"``

For more details on setting ImageMagick filters on image.ini please
refer to the `[imagemagick] /
filters <http://doc.ez.no/eZ-Publish/Technical-manual/4.x/Reference/Configuration-files/image.ini/ImageMagick/Filters>`__
documentation.

Extending injected settings
~~~~~~~~~~~~~~~~~~~~~~~~~~~

It's possible to add your own kernel event subscriber and also inject
your own settings by following how it is done
in LegacyMapper\\Configuration, and then at the end merge it with
existing injected settings, like so:

**injected-settings**

.. code:: theme:

            $event->getParameters()->set(
                "injected-settings",
                $settings + (array)$event->getParameters()->get( "injected-settings" )
            );

Site settings
~~~~~~~~~~~~~

You can inject the site.ini SiteAccessSettings in your ezpublish.yml
file.

yml

site.ini[SiteAccessSettings]

location\_id

PathPrefix

excluded\_uri\_prefixes

PathPrefixExclude

 

[SiteSettings]

location\_id

IndexPage

 

DefaultPage

 

RootNode

**ezpublish.yml**  Expand source

.. code:: theme:

    ezpublish:
        system:
            ezdemo_site_group:
                content:
                    tree_root:
                        # Root locationId. Default is top locationId
                        location_id: 123
                        # Every URL aliases starting with those prefixes will be considered
                        # being outside of the subtree starting at root_location.
                        # Default value is an empty array.
                        # Prefixes are not case sensitive.
                        excluded_uri_prefixes: [ /media, /images ]

Injected Behavior
-----------------

In addition to injected settings, some injection of behavior is
also performed.

eZFormToken (CSRF) integration
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Icon

This feature is only available as of eZ Publish 5.1 (2013.01)

If your config.yml setting
have \ *framework.csrf\_protection.enabled* set to *true*, then
both \ *kernel.secret* and \ *framework.csrf\_protection.field\_name*
will be sent to ezxFormToken class so csrf protection in legacy uses the
same token and form field name.

By making sure all your Symfony forms uses the
provided \ `csrf <http://symfony.com/doc/current/book/forms.html#forms-csrf>`__ `protection <http://symfony.com/doc/current/reference/forms/types/csrf.html>`__,
forms with *intention=legacy* can be set up to send data to legacy
kernel:

.. code:: theme:

    $formOptions = array( 'intention' => 'legacy' );
    $form = $this->createFormBuilder( null, $formOptions )
        ->...
        ->getForm();

Icon

``framework.csrf_protection.field_name`` shouldn't be changed as that
would prevent eZFormToken from working with most AJAX custom code

ezpEvent (Cache clear) integration
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

A listener is set up for both content/cache and content/cache/all to
make sure Symfony (Internal proxy or Varnish with custom vcl) HTTP cache
is cleared when cache is cleared in eZ Publish admin interface. 

 

Document generated by Confluence on Mar 03, 2015 15:12
