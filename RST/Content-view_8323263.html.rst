#. `eZ Publish Platform 5.x <index.html>`__
#. `eZ Publish Platform
   Documentation <eZ-Publish-Platform-Documentation_1114149.html>`__
#. `Development & Administration Guides <6291674.html>`__
#. `Features <Features_12781009.html>`__
#. `MVC and Application <MVC-and-Application_2719826.html>`__

eZ Publish Platform 5.x : Content view
======================================

Created by jerome.vieilledent@ez.no, last modified by
sarah.haim-lubczanski@ez.no on Dec 02, 2014

-  `The ViewController <#Contentview-TheViewController>`__
-  `View selection <#Contentview-Viewselection>`__
-  `Location view template <#Contentview-Locationviewtemplate>`__

   -  `Available variables <#Contentview-Availablevariables>`__
   -  `Template inheritance <#Contentview-Templateinheritance>`__
   -  `Rendering content's
      fields <#Contentview-Renderingcontent'sfields>`__

      -  `Getting raw Field value <#Contentview-GettingrawFieldvalue>`__
      -  `Using the FieldType's template
         block <#Contentview-UsingtheFieldType'stemplateblock>`__

   -  `Rendering Content name <#Contentview-RenderingContentname>`__

      -  `Name property in
         ContentInfo <#Contentview-NamepropertyinContentInfo>`__
      -  `Translated name <#Contentview-Translatedname>`__

   -  `Exposing additional
      variables <#Contentview-Exposingadditionalvariables>`__

-  `Making links to other
   locations <#Contentview-Makinglinkstootherlocations>`__
-  `Render embedded content
   objects <#Contentview-Renderembeddedcontentobjects>`__

   -  `Using ez\_content
      controller <#Contentview-Usingez_contentcontroller>`__

      -  `Available arguments <#Contentview-Availablearguments>`__

-  `Render block <#Contentview-Renderblock>`__
-  `ESI <#Contentview-ESI>`__
-  ` Asynchronous rendering <#Contentview-Asynchronousrendering>`__

   -  `Display a default text <#Contentview-Displayadefaulttext>`__

The ViewController
------------------

eZ Publish comes with a native controller to display your content, known
as the **``ViewController``**. It is called each time you try to reach a
content from its **Url Alias** (*human readable, *\ *translatable* URI
generated for any content based on URL patterns defined per Content
Type) and is able to render any content previously edited in the admin
interface or via the `eZ Publish Public
API <eZ-Publish-Public-API_1736723.html>`__.

It can also be called directly by its direct URI :
``/content/location/<locationId>``

A content can also have different **view types** (full page, abstract in
a list, block in a landing page...). By default the view type is
**full** (for full page), but it can be anything (*line*, *block*...).

Important note regarding visibility

Icon

Location visibility flag, which you can change with hide/unhide in
admin, is not permission based and thus acts as a simple potential
filter. **It is not meant to restrict access to content**.

If you need to restrict access to a given content, use **Sections or
Object states**, which are permission based.

 

View selection
--------------

To display a content, the ViewController uses a view manager which
selects the appropriate template depending on matching rules.

Icon

For more information about the **view provider configuration**, please
`refer to the dedicated
page <View-provider-configuration_2720462.html>`__.

Icon

You can also `use your own custom controller to render a
content/location <How-to-use-a-custom-controller-to-display-a-content-or-location_13468497.html>`__.

Location view template
----------------------

A content view template is like any other template, with several
specific aspects.

Available variables
~~~~~~~~~~~~~~~~~~~

Variable name

Type

Description

**``location``**

`eZ\\Publish\\Core\\Repository\\Values\\Content\\Location <https://github.com/ezsystems/ezp-next/blob/master/eZ/Publish/Core/Repository/Values/Content/Location.php>`__\ ` <https://github.com/ezsystems/ezp-next/blob/master/eZ/Publish/Core/Repository/Values/Content/Content.php>`__

| The location object. Contains meta information on the content
(`ContentInfo <https://github.com/ezsystems/ezp-next/blob/master/eZ/Publish/Core/Repository/Values/Content/ContentInfo.php>`__)
| (only when accessing a location) 

``content``

`eZ\\Publish\\Core\\Repository\\Values\\Content\\Content <https://github.com/ezsystems/ezp-next/blob/master/eZ/Publish/Core/Repository/Values/Content/Content.php>`__

The content object, containing all fields and version information
(`VersionInfo <https://github.com/ezsystems/ezp-next/blob/master/eZ/Publish/Core/Repository/Values/Content/VersionInfo.php>`__)

``noLayout``

Boolean

| If true, indicates if the content/location is to be displayed without
any pagelayout (i.e. AJAX, sub-requests...).
| It's generally ``false`` when displaying a content in view type
**full**. 

``viewBaseLayout``

String

The base layout template to use when the view is requested to be
generated outside of the pagelayout (when ``noLayout`` is true).

Template inheritance
~~~~~~~~~~~~~~~~~~~~

Like any template, a content view template can use `template
inheritance <http://symfony.com/doc/current/book/templating.html#template-inheritance-and-layouts>`__.
However keep in mind that your content can be also requested via
`sub-requests <http://symfony.com/doc/current/book/templating.html#embedding-controllers>`__
(see below how to render embedded content objects). In this case your
template should probably not extend your main layout.

In this regard, it is recommended to use inheritance this way:

.. code:: theme:

    {% extends noLayout ? viewbaseLayout : "AcmeDemoBundle::pagelayout.html.twig" %}

    {% block content %}
    ...
    {% endblock %}

Rendering content's fields
~~~~~~~~~~~~~~~~~~~~~~~~~~

As stated above, a view template receives the requested Content object,
holding all fields.

In order to display the fields' value the way you want, you can either
manipulate the Field Value object itself or use a template.

Getting raw Field value
^^^^^^^^^^^^^^^^^^^^^^^

Having access to the Content object in the template, you can use `its
public
methods <https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/Core/Repository/Values/Content/Content.php>`__
to access to all the information you need. You can also
use \ `ez\_field\_value <ez_field_value_17105557.html>`__ helper to get
the Field value in the current language if translation is available.

.. code:: theme:

    {# With the following, myFieldValue will be in the content's main language, regardless the current language #}
    {% set myFieldValue = content.getFieldValue( 'some_field_identifier' ) %}
     
    {# Here myTranslatedFieldValue will be in the current language if a translation is available. If not, the content's main language will be used #}
    {% set myTranslatedFieldValue = ez_field_value( content, 'some_field_identifier' ) %}

Using the FieldType's template block
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

All built-in FieldTypes come with `a piece of Twig template
code <https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Bundle/EzPublishCoreBundle/Resources/views/content_fields.html.twig>`__
you can take advantage of by calling ``ez_render_field()`` helper.

.. code:: theme:

    {{ ez_render_field( content, 'some_field_identifier' ) }}

Refer to ```ez_render_field()`` reference
page <ez_render_field_12779554.html>`__ for further information.

Icon

As this makes use of reusable templates, **using ``ez_render_field()``
is the recommended way and is to be considered as a best practice**.

Rendering Content name
~~~~~~~~~~~~~~~~~~~~~~

The **name** of a content is its generic "title", generated by the
repository considering several rules in the FieldDefinition. It usually
consists in the normalized value of the first field.

There are 2 different ways to access to this special property:

-  Through the name property of ContentInfo (not translated).
-  Through VersionInfo with the TranslationHelper (translated).

Name property in ContentInfo
^^^^^^^^^^^^^^^^^^^^^^^^^^^^

This property is the actual content name, but **in main language only**
(so it is not translated).

.. code:: theme:

    <h2>Content name: {{ content.contentInfo.name }}</h2>

.. code:: theme:

    $contentName = $content->contentInfo->name;

Translated name
^^^^^^^^^^^^^^^

Icon

The TranslationHelper service is available as of version 5.2 / 2013.09

The *translated name* is held in ``VersionInfo`` object, in the names
property which consists of hash indexed by locale. You can easily
retrieve it in the right language via the ``TranslationHelper`` service.

.. code:: theme:

    <h2>Translated content name: {{ ez_content_name( content ) }}</h2>
    <h3>Also works from ContentInfo : {{ ez_content_name( content.contentInfo ) }}</h3>

You can refer to `ez\_content\_name() reference
page <ez_content_name_17105551.html>`__ for further information.

 

.. code:: theme:

    // Assuming we're in a controller action
    $translationHelper = $this->get( 'ezpublish.translation_helper' );
     
    // From Content
    $translatedContentName = $translationHelper->getTranslatedContentName( $content );
    // From ContentInfo
    $translatedContentName = $translationHelper->getTranslatedContentNameByContentInfo( $contentInfo );

Icon

The helper will respect the prioritized languages. 

If there is no translation for your prioritized languages, the helper
will always return the name in the main language.

You can also **force a locale** in a 2nd argument:

.. code:: theme:

    {# Force fre-FR locale. #}
    <h2>{{ ez_content_name( content, 'fre-FR' ) }}</h2>

.. code:: theme:

    // Assuming we're in a controller action
    $translatedContentName = $this->get( 'ezpublish.translation_helper' )->getTranslatedName( $content, 'fre-FR' );

Exposing additional variables
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

It is possible to expose additional variables in a content view
template. See \ `parameters injection in content
views <Parameters-injection-in-content-views_8323330.html>`__ or `use
your own custom controller to render a
content/location <How-to-use-a-custom-controller-to-display-a-content-or-location_13468497.html>`__.

Making links to other locations
-------------------------------

Linking to other locations is fairly easy and is done with
`native \ ``path()`` Twig
helper <http://symfony.com/doc/2.3/book/templating.html#linking-to-pages>`__
(or ``url()`` if you want to generate absolute URLs). You just have to
pass it the Location object and ``path()`` will generate the URLAlias
for you.

.. code:: theme:

    {# Assuming "location" variable is a valid eZ\Publish\API\Repository\Values\Content\Location object #}
    <a href="{{ path( location ) }}">Some link to a location</a>

If you don't have the Location object, but only its ID, you can generate
the URLAlias the following way:

.. code:: theme:

    <a href="{{ path( "ez_urlalias", {"locationId": 123} ) }}">Some link to a location, with its Id only</a>

As of 5.4 / 2014.11, you can also use the Content ID. In that case
generated link will point to the content main location.

.. code:: theme:

    <a href="{{ path( "ez_urlalias", {"contentId": 456} ) }}">Some link from a contentId</a>

Under the hood

Icon

In the backend, ``path()`` uses the Router to generate links.

This makes also easy to generate links from PHP, via the ``router``
service.

See also : `Cross SiteAccess
links <Cross-SiteAccess-links_21299772.html>`__

Render embedded content objects
-------------------------------

Rendering an embedded content from a Twig template is pretty straight
forward as you just need to **do a subrequest with ``ez_content``
controller**.

Using \ ``ez_content`` controller
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

This controller is exactly the same as \ `the ViewController presented
above <Content-view_8323263.html>`__ and has 2 main actions:

-  **``viewLocation``** to render a location (same as when accessing a
   content through an URLAlias)
-  **``viewContent``** to render a content

You can use this controller from templates with the following syntax:

**eZ Publish 5.1+ / Symfony 2.2+**

.. code:: theme:

    {{ render( controller( "ez_content:viewLocation", {"locationId": 123, "viewType": "line"} ) ) }}

 

The example above allows you to render a Location which ID is **123**,
with the view type \ **line**.

Icon

Reference of ``ez_content`` controller follow the syntax of *controllers
as a service*, `as explained in Symfony
documentation <http://symfony.com/doc/current/cookbook/controller/service.html>`__.

Available arguments
^^^^^^^^^^^^^^^^^^^

As any controller, you can pass arguments to ``ez_content:viewLocation``
or ``ez_content:viewContent`` to fit your needs.

Name

Description

Type

Default value

``locationId``

| Id of the location you want to render.
| **Only for ``ez_content:viewLocation``** 

integer

N/A

``contentId``

| Id of the content you want to render.
| **Only for ``ez_content:viewContent``** 

integer

N/A

``viewType``

| The view type you want to render your content/location in.
| Will be used by the ViewManager to select corresponding template,
according to defined rules. 

Example: full, line, my\_custom\_view, ...

string

full

``layout``

Indicates if the sub-view needs to use the main layout (see `available
variables in a view template <Content-view_8323263.html>`__)

 

boolean

false

``params``

Hash of variables you want to inject to sub-template, key being the
exposed variable name.

Icon

Available as of eZ Publish 5.1

.. code:: theme:

    {{ render(
          controller( 
              "ez_content:viewLocation", 
              {
                  "locationId": 123,
                  "viewType": "line",
                  "params": { "some_variable": "some_value" }
              }
          )
    ) }}

hash

empty hash

Render block
------------

| >= EZP 5.4 / >= 2014.11

You can specify which controller will be called for a specific block
view match, much like defining custom controllers for location view or
content view match.

Also, since there are two possible actions with which one can view a
block: ``ez_page:viewBlock`` and ``ez_page:viewBlockById``, it is
possible to specify a controller action with a signature matching either
one of original actions.

Example of configuration in ``ezpublish/config/ezpublish.yml``:

.. code:: theme:

    ezpublish:
        system:
            eng_frontend_group:
                block_view:
                    ContentGrid:
                        template: NetgenSiteBundle:block:content_grid.html.twig
                        controller: NetgenSiteBundle:Block:viewContentGridBlock
                        match:
                            Type: ContentGrid

ESI
---

Just as for regular Symfony controllers, you can take advantage of ESI
and use different cache levels:

**Using ESI (eZ Publish 5.1+ / Symfony 2.2+)**

.. code:: theme:

    {{ render_esi( controller( "ez_content:viewLocation", {"locationId": 123, "viewMode": "line"} ) ) }}

Icon

Only scalable variables can be sent via render\_esi (not object)

 

 Asynchronous rendering
-----------------------

Symfony also supports asynchronous content rendering with the help
of \ `hinclude.js <http://mnot.github.com/hinclude/>`__ library.

**Asynchronous rendering (eZ Publish 5.1+ / Symfony 2.2+)**

.. code:: theme:

    {{ render_hinclude( controller( "ez_content:viewLocation", {"locationId": 123, "viewMode": "line"} ) ) }}

Icon

Only scalable variables can be sent via render\_hinclude (not object)

Display a default text
~~~~~~~~~~~~~~~~~~~~~~

If you want to display a default text while a controller is loaded
asynchronously, you have to pass a second parameters to your
render\_hinclude twig function.

**Display a default text while asynchronous loading of a controller**

.. code:: theme:

    {{ render_hinclude( controller( 'EzCorporateDesignBundle:Header:userLinks' ), { 'default': "<div style='color:red'>loading</div>" }) }}

`See also :  How to use a custom controller to display a content or
location <How-to-use-a-custom-controller-to-display-a-content-or-location_13468497.html>`__

 

 

Icon

`hinclude.js <http://mnot.github.com/hinclude/>`__ needs to be properly
included in your layout to work.

Please `refer to Symfony
documentation <http://symfony.com/doc/current/book/templating.html#asynchronous-content-with-hinclude-js>`__
for all available options.

Comments:
---------

+--------------------------------------------------------------------------+
| When rendering embedded objects in a TWIG template, *objectParameters*   |
| will give you access to the parameters specified when embedding an       |
| object in the online editor, e.g. the image variation.                   |
|                                                                          |
| |image12| Posted by dfritschy at Mar 18, 2014 16:00                      |
+--------------------------------------------------------------------------+
| What about the fallback for ez\_field\_value(content, 'image')? In the   |
| case of the text, it falls back to the main language if it doesn't find  |
| a translation, but what about if the field is **not text** but **image** |
| type?                                                                    |
|                                                                          |
| |image13| Posted by sweetguy0883 at Jul 30, 2014 08:22                   |
+--------------------------------------------------------------------------+
| `Stiff Roy <https://doc.ez.no/display/~sweetguy0883>`__ It's not about   |
| text content, but value objects. ``ez_field_value()`` always return the  |
| appropriate value object for given field. If you ask for an image field, |
| you will get an \ ``eZ\Publish\Core\FieldType\Image\Value`` object. And  |
| no, it won't fallback to main language. If no appropriate language could |
| be found, it will return ``null``.                                       |
|                                                                          |
| Here is the `reference documentation for                                 |
| ``ez_field_value()`` <ez_field_value_17105557.html>`__.                  |
|                                                                          |
| |image14| Posted by jerome.vieilledent@ez.no at Jul 30, 2014 08:35       |
+--------------------------------------------------------------------------+
| `Jérôme                                                                  |
| Vieilledent <https://doc.ez.no/display/~jerome.vieilledent@ez.no>`__ I   |
| have my object in 2 languages, eng-GB and ger-DE (main language eng-GB). |
| I have a text field and an image field. in eng-GB siteaccess, both works |
| fine, but in ger-DE siteaccess the text field gets the fallback value    |
| from the eng-GB but the image field is black and doesn't get the         |
| fallback from the eng-GB. Any suggestion about it? Thanks... |(smile)|   |
|                                                                          |
| |image15| Posted by sweetguy0883 at Jul 30, 2014 09:20                   |
+--------------------------------------------------------------------------+
| `Stiff Roy <https://doc.ez.no/display/~sweetguy0883>`__ In order to have |
| more accurate answers, I suggest that you ask on the `Share              |
| Forums <http://share.ez.no/forums>`__ the same question.                 |
|                                                                          |
| |image16| Posted by sarah.haim-lubczanski@ez.no at Jul 30, 2014 09:58    |
+--------------------------------------------------------------------------+
| Hello,                                                                   |
|                                                                          |
| For the **render\_esi**, the documentation miss some critical            |
| informations, if you use a the '**ez\_content:viewLocation**\ ' instead  |
| of a custom controller  :                                                |
|                                                                          |
| -  The default TTL is **60 second**, which is really not relevant (so    |
|    good to know) : `HttpCache <HttpCache_6291892.html>`__                |
| -  You can set a TTL if needed for each ESI with\ ** 'cacheSettings':    |
|    {'smax-age': 3600}**                                                  |
|                                                                          |
| |image17| Posted by kaliop at Oct 17, 2014 08:07                         |
+--------------------------------------------------------------------------+
| `gilles guirand <https://doc.ez.no/display/~kaliop>`__ : Usage of        |
| ``ez_content:viewLocation`` is highly recommended, even if you want to   |
| use a custom controller (set your custom controller in your view         |
| rules).                                                                  |
|                                                                          |
| You can also set different cache values using a ResponseListener. You    |
| may use FOSHttpCacheBundle for this (which will be bundled with 5.4).    |
|                                                                          |
|     -  You can set a TTL if needed for each ESI                          |
|        with\ ** 'cacheSettings': {'smax-age': 3600}**                    |
|                                                                          |
| No, you cannot do that with ``ez_content:viewLocation``, currently only  |
| with ``ez_page:viewBlock``.                                              |
|                                                                          |
| |image18| Posted by jerome.vieilledent@ez.no at Oct 17, 2014 08:23       |
+--------------------------------------------------------------------------+
| Thanks for the quick answer :                                            |
|                                                                          |
| -  is it not possible to make this cacheSettings parameter available ?   |
|    (i mean, is there a blocker except the time to develop ?)             |
| -  is there a motivation to set a defaut TTL to 60sec ? (maybe to avoid  |
|    unexpected cache behaviour on first install / discovery of eZPublish) |
|                                                                          |
| |image19| Posted by kaliop at Oct 17, 2014 08:36                         |
+--------------------------------------------------------------------------+
| i'm fine with the default ttl setting. default settings should be        |
| conservative imho. Difficult to say what could be a good choice          |
| though...                                                                |
|                                                                          |
| |image20| Posted by desorden at Oct 17, 2014 08:39                       |
+--------------------------------------------------------------------------+
| `gilles guirand <https://doc.ez.no/display/~kaliop>`__ : It would be     |
| possible to add the cacheSettings parameters. PR accepted \ |(smile)|.   |
| As for the default TTL to 60sec, yes. This is to ensure TTL is not too   |
| long in case of issue with purging (safeguard clause basically). But you |
| know `you can change it in your semantic                                 |
| configuration <https://github.com/lolautruche/metalfrance/blob/master/sr |
| c/MetalFrance/SiteBundle/Resources/config/ezpublish.yml#L44-L48>`__,     |
| right ?                                                                  |
|                                                                          |
| |image21| Posted by jerome.vieilledent@ez.no at Oct 17, 2014 08:40       |
+--------------------------------------------------------------------------+
| Sure, right, but it starts to be a new top 5 cache issue with            |
| eZ5 \ |(smile)| . So maybe should add a huge red box somewhere in the    |
| documentation (under render\_esi) to advice to change this TTL with a    |
| more relevant value, depending on the project & the dynamic purge        |
| avaiable                                                                 |
|                                                                          |
| |image22| Posted by kaliop at Oct 17, 2014 09:21                         |
+--------------------------------------------------------------------------+

Document generated by Confluence on Mar 03, 2015 15:12

.. |image0| image:: images/icons/contenttypes/comment_16.png
.. |image1| image:: images/icons/contenttypes/comment_16.png
.. |image2| image:: images/icons/contenttypes/comment_16.png
.. |(smile)| image:: images/icons/emoticons/smile.png
.. |image4| image:: images/icons/contenttypes/comment_16.png
.. |image5| image:: images/icons/contenttypes/comment_16.png
.. |image6| image:: images/icons/contenttypes/comment_16.png
.. |image7| image:: images/icons/contenttypes/comment_16.png
.. |image8| image:: images/icons/contenttypes/comment_16.png
.. |image9| image:: images/icons/contenttypes/comment_16.png
.. |image10| image:: images/icons/contenttypes/comment_16.png
.. |image11| image:: images/icons/contenttypes/comment_16.png
.. |image12| image:: images/icons/contenttypes/comment_16.png
.. |image13| image:: images/icons/contenttypes/comment_16.png
.. |image14| image:: images/icons/contenttypes/comment_16.png
.. |image15| image:: images/icons/contenttypes/comment_16.png
.. |image16| image:: images/icons/contenttypes/comment_16.png
.. |image17| image:: images/icons/contenttypes/comment_16.png
.. |image18| image:: images/icons/contenttypes/comment_16.png
.. |image19| image:: images/icons/contenttypes/comment_16.png
.. |image20| image:: images/icons/contenttypes/comment_16.png
.. |image21| image:: images/icons/contenttypes/comment_16.png
.. |image22| image:: images/icons/contenttypes/comment_16.png
