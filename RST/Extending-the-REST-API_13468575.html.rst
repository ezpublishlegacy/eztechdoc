#. `eZ Publish Platform 5.x <index.html>`__
#. `eZ Publish Platform
   Documentation <eZ-Publish-Platform-Documentation_1114149.html>`__
#. `Development & Administration Guides <6291674.html>`__
#. `Features <Features_12781009.html>`__
#. `eZ Publish REST API <eZ-Publish-REST-API_6292277.html>`__

eZ Publish Platform 5.x : Extending the REST API
================================================

Created and last modified by bertrand.dunogier@ez.no on Nov 24, 2014

 

The eZ Publish 5 REST API comes with a framework that makes it quite
easy to extend the API for your own needs.

Icon

While most of what can be found here will still apply in the future, the
structure of the REST API and its components will evolve before the
actual release.

-  `Requirements <#ExtendingtheRESTAPI-Requirements>`__

   -  `Controller <#ExtendingtheRESTAPI-Controller>`__
   -  `Route <#ExtendingtheRESTAPI-Route>`__

-  `Controller action <#ExtendingtheRESTAPI-Controlleraction>`__
-  `ValueObjectVisitor <#ExtendingtheRESTAPI-ValueObjectVisitor>`__
-  `Input parser <#ExtendingtheRESTAPI-Inputparser>`__

Requirements
------------

As of version 2013.7 / 5.2, REST routes are required to use the eZ
Publish 5 REST API prefix, ``/api/ezp/v2``. You can create new resources
below this prefix.

To do so, you will/may need to create

-  a Controller that will handle your route actions
-  a Route, in your bundle's routing file
-  a Controller action
-  Optionally, a ``ValueObjectVisitor`` (if your Controller returns an
   object that doesn't already have a converter)
-  Optionally, an ``InputParser``

Controller
~~~~~~~~~~

To create a REST controller, you need to extend the
``ezpublish_rest.controller.base`` service, as well as the
``eZ\Publish\Core\REST\Server\Controller`` class.

Let's create a very simple controller, that has a ``sayHello()`` method,
that takes a name as an argument.

**My/Bundle/RestBundle/Controller/DefaultController.php**

.. code:: theme:

    namespace My\Bundle\RestBundle\Rest\Controller;
     
    use eZ\Publish\Core\REST\Server\Controller as BaseController;
     
    class DefaultController extends BaseController
    {
        public function sayHello( $name )
        {
            // @todo Implement me
        }
    }

Route
~~~~~

As said earlier, your REST routes are required to use the REST URI
prefix. To do so, the easiest way is to import your routing file using
this prefix.

**ezpublish/config/routing.yml**

.. code:: theme:

    myRestBundle_rest_routes:
        resource: "@MyRestBundle/Resources/config/routing_rest.yml"
        prefix:   %ezpublish_rest.path_prefix%

Using a distinct file for REST routes allows you to use the prefix for
all this file's routes without affecting other routes from your bundle.

Next, you need to create the REST route. We need to define the route's
`controller as a
service <http://symfony.com/doc/current/cookbook/controller/service.html>`__
since our controller was defined as such.

**My/Bundle/RestBundle/Resources/config/routing\_rest.yml**

.. code:: theme:

    myRestBundle_hello_world:
        pattern: /my_rest_bundle/hello/{name}
        defaults:
            _controller: myRestBundle.controller.default:sayHello
        methods: [GET]

Icon

Due to `|image0|\ EZP-23016 <https://jira.ez.no/browse/EZP-23016>`__ -
Custom REST API routes (v2) are not accessible from the legacy backend
Backlog , custom REST routes must be prefixed with ``ezpublish_rest_``,
or they won't be detected correctly.

Controller action
-----------------

Unlike standard Symfony 2 controllers, the REST ones don't return an
``HttpFoundation\Response`` object, but a ``ValueObject``. This object
will during the kernel run be converted, using a ValueObjectVisitor, to
a proper Symfony 2 response. One benefit is that when multiple
controllers return the same object, such as a Content or a Location, the
visitor will be re-used.

Let's say that our Controller will return a
``My\Bundle\RestBundle\Rest\Values\Hello``

**My/Bundle/RestBundle/Rest/Values/Hello.php**

.. code:: theme:

    namespace My\Bundle\RestBundle\Rest\Values;
     
    class Hello
    {
        public $name;
     
        public function __construct( $name )
        {
            $this->name = $name;
        }
    }

We will return an instance of this class from our ``sayHello()``
controller method.

**My/Bundle/RestBundle/Rest/Controller/DefaultController.php**

.. code:: theme:

    namespace My\Bundle\RestBundle\Controller;

    use eZ\Publish\Core\REST\Server\Controller as BaseController;
    use My\Bundle\RestBundle\Rest\Values\Hello as HelloValue;

    class DefaultController extends BaseController
    {
        public function sayHello( $name )
        {
            return new HelloValue( $name );
        }
    }

And that's it. Outputting this object in the Response requires that we
create a ValueObjectVisitor.

ValueObjectVisitor
------------------

A ValueObjectVisitor will take a Value returned by a REST controller,
whatever the class, and will transform it into data that can be
converted, either to json or XML. Those visitors are registered as
services, and tagged with
``ezpublish_rest.output.value_object_visitor``. The tag attribute says
which class this Visitor applies to.

Let's create the service for our ValueObjectVisitor first.

**My/Bundle/RestBundle/Resources/config/services.yml**

.. code:: theme:

    services:
        myRestBundle.value_object_visitor.hello:
            parent: ezpublish_rest.output.value_object_visitor.base
            class: My\Bundle\RestBundle\Rest\ValueObjectVisitor\Hello
            tags:
                - { name: ezpublish_rest.output.value_object_visitor, type: My\Bundle\RestBundle\Rest\Values\Hello }

| Let's create our visitor next. It must extend
the \ ``eZ\Publish\Core\REST\Common\Output\ValueObjectVisitor`` abstract
class, and implement the ``visit()`` method.
| It will receive as arguments:

-  ``$visitor``: The output visitor. Can be used to set custom response
   headers ( ``setHeader( $name, $value )``), HTTP status code (
   ``setStatus( $statusCode )`` )...
-  ``$generator``: The actual Response generator. It provides you with a
   DOM like API.
-  ``$data``: the visited data, the exact object you returned from the
   controller 

**My/Bundle/RestBundle/Rest/Controller/Default.php**

.. code:: theme:

    namespace My\Bundle\RestBundle\Rest\ValueObjectVisitor;

    use eZ\Publish\Core\REST\Common\Output\ValueObjectVisitor;
    use eZ\Publish\Core\REST\Common\Output\Generator;
    use eZ\Publish\Core\REST\Common\Output\Visitor;

    class Hello extends ValueObjectVisitor
    {
        public function visit( Visitor $visitor, Generator $generator, $data )
        {
            $generator->startValueElement( 'Hello', $data->name );
            $generator->endValueElement( 'Hello' );
        }
    }

Do not hesitate to look into the built-in ValueObjectVisitors,
in \ ``eZ/Publish/Core/REST/Server/Output/ValueObjectVisitor``, for more
examples.

Input parser
------------

What we have seen above covers requests that don't require an input
payload, such as GET or DELETE. If you need to provide your controller
with parameters, either in JSON or XML, the parameter struct requires an
Input Parser so that the payload can be converted to an actual
ValueObject.

Each payload is dispatched to its Input Parser based on the request's
Content-Type header. For example, a request with a Content-Type of
``application/vnd.ez.api.ContentCreate`` will be parsed by
``eZ\Publish\Core\REST\Server\Input\Parser\ContentCreate``. This parser
will build and return a ``ContentCreateStruct`` that can then be used to
create content with the Public API.

Those input parsers are provided with a pre-parsed version of the input
payload, as an associative array, and don't have to care about the
actual format (XML or JSON).

Let's see what it would look like with a Content-Type of
application/vnd.my.Greetings, that would send this as XML:

**application/vnd.my.Greetings+xml**

.. code:: theme:

    <?xml version="1.0" encoding="utf-8"?>
    <Greetings>
        <name>John doe</name>
    </Greetings>

First, we need to create a service with the appropriate tag in
services.yml.

**My/Bundle/RestBundle/Resources/config/services.yml**

.. code:: theme:

    services:
        myRestBundle.input_parser.Greetings:
            parent: ezpublish_rest.input.parser
            class: My\Bundle\RestBundle\Rest\InputParser\Greetings
            tags:
                - { name: ezpublish_rest.input.parser, mediaType: application/vnd.my.Greetings }

The mediaType attribute of the ezpublish\_rest.input.parser tag maps our
Content Type to the input parser.

Let's implement our parser. It must
extend eZ\\Publish\\Core\\REST\\Server\\Input\\Parser, and implement the
``parse()`` method. It accepts as an argument the input payload,
``$data``, as an array, and an instance of \ ``ParsingDispatcher`` that
can be used to forward parsing of embedded content.

For convenience, we will consider that our input parser returns an
instance of our ``Value\Hello`` class.

**My/Bundle/RestBundle/Rest/InputParser/Greetings.php**

.. code:: theme:

    namespace My\Bundle\RestBundle\Rest\InputParser;
     
    use eZ\Publish\Core\REST\Common\Input\BaseParser;
    use eZ\Publish\Core\REST\Common\Input\ParsingDispatcher;
    use My\Bundle\RestBundle\Rest\Value\Hello;
    use eZ\Publish\Core\REST\Common\Exceptions;


    class Greetings extends BaseParser
    {
        /**
         * @return My\Bundle\RestBundle\Rest\Value\Hello
         */
        public function parse( array $data, ParsingDispatcher $parsingDispatcher )
        {
            // re-using the REST exceptions will make sure that those already have a ValueObjectVisitor
            if ( !isset( $data['name'] ) )
                throw new Exceptions\Parser( "Missing or invalid 'name' element for Greetings." );


            return new Hello( $data['name'] );
        }
    }

**My/Bundle/RestBundle/Resources/config/services.yml**

.. code:: theme:

    services:
        myRestBundle.controller.default:
            class: My\Bundle\RestBundle\Rest\Controller\Default
            parent: ezpublish_rest.controller.base

Do not hesitate to look into the built-in InputParsers, in
``eZ/Publish/Core/REST/Server/Input/Parser``, for more examples.

Comments:
---------

+--------------------------------------------------------------------------+
| On the "ValueObjectVisitor" topic (second code example):                 |
|                                                                          |
| **My/Bundle/RestBundle/Rest/Controller/Default.php**                     |
|                                                                          |
|                                                                          |
|                                                                          |
| +----------------------------------------------------------------------- |
| ---+                                                                     |
| | ``namespace`` ``My\Bundle\RestBundle\Rest\ValueObjectVisitor;``        |
|    |                                                                     |
| |                                                                        |
|    |                                                                     |
| | ``use`` ``eZ\Publish\Core\REST\Common\Output\ValueObjectVisitor;``     |
|    |                                                                     |
| | ``use`` ``eZ\Publish\Core\REST\Common\Output\Generator;``              |
|    |                                                                     |
| | ``use`` ``eZ\Publish\Core\REST\Common\Output\Visitor;``                |
|    |                                                                     |
| |                                                                        |
|    |                                                                     |
| | ``class`` ``Hello ``\ ``extends`` ``ValueObjectVisitor``               |
|    |                                                                     |
| | ``{``                                                                  |
|    |                                                                     |
| | ``    ``\ ``public`` ``function``                                      |
|    |                                                                     |
| | ``visit( Visitor ``\ ``$visitor``\ ``, Generator ``\ ``$generator``\ ` |
| `, |                                                                     |
| |  ``\ ``$data``                                                         |
|    |                                                                     |
| | ``)``                                                                  |
|    |                                                                     |
| | ``    ``\ ``{``                                                        |
|    |                                                                     |
| | ``        ``\ ``$this``\ ``->generator->startValueElement( ``\ ``'Hell |
| o' |                                                                     |
| | ``\ ``, ``\ ``$data``\ ``->name );``                                   |
|    |                                                                     |
| | ``        ``\ ``$this``\ ``->generator->endValueElement( ``\ ``'Hello' |
| `` |                                                                     |
| | ``);``                                                                 |
|    |                                                                     |
| | ``    ``\ ``}``                                                        |
|    |                                                                     |
| | ``}``                                                                  |
|    |                                                                     |
| +----------------------------------------------------------------------- |
| ---+                                                                     |
|                                                                          |
| Is the file path correct?                                                |
|                                                                          |
| |image12| Posted by marcos.loureiro@ez.no at Jul 11, 2013 15:34          |
+--------------------------------------------------------------------------+
| Moreover $this->generator is wrong.. you have to use directly            |
| $generator->. But got an error:                                          |
|                                                                          |
| .. code:: theme:                                                         |
|                                                                          |
|     <errorDescription>Output visiting failed: Invalid start: Trying to o |
| pen valueElement inside document, valid parent nodes are: objectElement, |
|  hashElement, list.</errorDescription>                                   |
|                                                                          |
| So i replace code via                                                    |
|                                                                          |
| .. code:: theme:                                                         |
|                                                                          |
|     <?php                                                                |
|                                                                          |
|     namespace Ez\RestBundle\Rest\ValueObjectVisitor;                     |
|                                                                          |
|     use eZ\Publish\Core\REST\Common\Output\ValueObjectVisitor;           |
|     use eZ\Publish\Core\REST\Common\Output\Generator;                    |
|     use eZ\Publish\Core\REST\Common\Output\Visitor;                      |
|                                                                          |
|     class Hello extends ValueObjectVisitor                               |
|     {                                                                    |
|         public function visit( Visitor $visitor, Generator $generator, $ |
| data )                                                                   |
|         {                                                                |
|             $generator->startObjectElement( 'Test' );                    |
|                                                                          |
|             $generator->startValueElement( 'Hello', $data->name );       |
|             $generator->endValueElement( 'Hello' );                      |
|                                                                          |
|             $generator->endObjectElement( 'Test' );                      |
|         }                                                                |
|     }                                                                    |
|                                                                          |
| and it works..                                                           |
|                                                                          |
| Maybe to complete this tutorial, if you would like to generate your      |
| result with json, you just have to pass to header                        |
| Accept: application/vnd.ez.api.Test+json                                 |
|                                                                          |
| Got an other issue; your controller is wrong \ |(smile)| If you create   |
| on service                                                               |
|                                                                          |
| .. code:: theme:                                                         |
|                                                                          |
|     myRestBundle.controller.default:                                     |
|         class: Ez\RestBundle\Rest\Controller\DefaultController           |
|         parent: ezpublish_rest.controller.base                           |
|                                                                          |
| you have to create your DefaultController.php which contains             |
|                                                                          |
| .. code:: theme:                                                         |
|                                                                          |
|     <?php                                                                |
|                                                                          |
|     namespace Ez\RestBundle\Rest\Controller;                             |
|                                                                          |
|     use eZ\Publish\Core\REST\Server\Controller as BaseController;        |
|     use Ez\RestBundle\Rest\Values\Hello as HelloValue;                   |
|                                                                          |
|     class DefaultController extends BaseController                       |
|     {                                                                    |
|         public function sayHello( $name )                                |
|         {                                                                |
|             return new HelloValue( $name );                              |
|         }                                                                |
|     }                                                                    |
|                                                                          |
| Promise, i'm done for now \ |(wink)|                                     |
|                                                                          |
| |image13| Posted by philippe.vincent-royol@ez.no at Oct 07, 2013 19:49   |
+--------------------------------------------------------------------------+
| One more thing: when adding your rest routes, in                         |
| ezpublish/config/routing.yml, it is important to put them ABOVE the      |
| routes form the EzPublishRestBundle, as those ones contain a last        |
| "catchall" route which will prevent the new ones to be triggered         |
|                                                                          |
| |image14| Posted by gaetano.giunta@ez.no at Jan 17, 2014 17:52           |
+--------------------------------------------------------------------------+
| If you want a custom REST route to be recognized from the legacy         |
| backend, it MUST be prefixed with ``ezpublish_rest_``, so, in your       |
| routing\_rest.yml, this will not work:                                   |
|                                                                          |
| **My/Bundle/RestBundle/Resources/config/routing\_rest.yml**              |
| .. code:: theme:                                                         |
|                                                                          |
|     my_custom_bundle_rest_route:                                         |
|         pattern: /customroute                                            |
|         defaults:                                                        |
|             _controller: my_custom_bundle.rest.controller.action:getStuf |
| f                                                                        |
|         methods: [GET]                                                   |
|                                                                          |
| but this will:                                                           |
|                                                                          |
| **My/Bundle/RestBundle/Resources/config/routing\_rest.yml**              |
| .. code:: theme:                                                         |
|                                                                          |
|     ezpublish_rest_my_custom_bundle_rest_route:                          |
|         pattern: /customroute                                            |
|         defaults:                                                        |
|             _controller: my_custom_bundle.rest.controller.action:getStuf |
| f                                                                        |
|         methods: [GET]                                                   |
|                                                                          |
| |image15| Posted by jgamez at Jun 16, 2014 14:28                         |
+--------------------------------------------------------------------------+
| `Jérôme Gamez <https://doc.ez.no/display/~jgamez>`__ there is a          |
| parameter you can use for that:                                          |
|                                                                          |
| .. code:: diff-line-pre                                                  |
|                                                                          |
|     legacy_aware_routes                                                  |
|                                                                          |
| |image16| Posted by gaetano.giunta@ez.no at Jun 16, 2014 14:36           |
+--------------------------------------------------------------------------+
| `Gaetano Giunta <https://doc.ez.no/display/~gaetano.giunta@ez.no>`__ :   |
| What ``legacy_aware_routes`` have to do with REST ?                      |
|                                                                          |
| |image17| Posted by jerome.vieilledent@ez.no at Jun 16, 2014 14:51       |
+--------------------------------------------------------------------------+
| `Jérôme Gamez <https://doc.ez.no/display/~jgamez>`__ AFAICT, you need    |
| above all to use the right prefix:                                       |
|                                                                          |
| .. code:: theme:                                                         |
|                                                                          |
|     myRestBundle_rest_routes:                                            |
|         resource: "@MyRestBundle/Resources/config/routing_rest.yml"      |
|         prefix:   %ezpublish_rest.path_prefix%                           |
|                                                                          |
| Besides, you should use ``path`` instead of ``pattern`` to be forward    |
| compatible with Symfony 3.0 \ |(wink)|                                   |
|                                                                          |
| |image18| Posted by jerome.vieilledent@ez.no at Jun 16, 2014 14:53       |
+--------------------------------------------------------------------------+
| `Gaetano                                                                 |
| Giunta <https://doc.ez.no/display/~gaetano.giunta@ez.no>`__: Sadly,      |
| setting the \ ``legacy_aware_routes`` parameter didn't work for me.      |
|                                                                          |
| `Jérôme                                                                  |
| Vieilledent <https://doc.ez.no/display/~jerome.vieilledent@ez.no>`__: I  |
| will exchange ``pattern`` with ``path``, thank you for the hint! I have  |
| imported the routes like you said, and stated in the docs above, but     |
| still no luck. Only prefixing my distinct routes                         |
| with \ ``ezpublish_rest_ ``\ worked so far to make them available for    |
| the legacy backend. For the non-legacy environment, everything worked    |
| fine without the "special" route names.                                  |
|                                                                          |
| |image19| Posted by jgamez at Jun 16, 2014 15:02                         |
+--------------------------------------------------------------------------+
| Ah my bad, sorry \ `Gaetano                                              |
| Giunta <https://doc.ez.no/display/~gaetano.giunta@ez.no>`__... Using     |
| ``legacy_aware_routes`` should indeed work. I think an issue should be   |
| reported \ |(wink)|                                                      |
|                                                                          |
| |image20| Posted by jerome.vieilledent@ez.no at Jun 16, 2014 15:16       |
+--------------------------------------------------------------------------+

Document generated by Confluence on Mar 03, 2015 15:12

.. |image0| image:: https://jira.ez.no/images/icons/issuetypes/bug.png
.. |image1| image:: images/icons/contenttypes/comment_16.png
.. |(smile)| image:: images/icons/emoticons/smile.png
.. |(wink)| image:: images/icons/emoticons/wink.png
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
