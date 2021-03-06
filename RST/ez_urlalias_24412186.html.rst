#. `eZ Publish Platform 5.x <index.html>`__
#. `eZ Publish Platform
   Documentation <eZ-Publish-Platform-Documentation_1114149.html>`__
#. `Reference <Reference_10158191.html>`__
#. `Twig functions <Twig-functions_12779535.html>`__

eZ Publish Platform 5.x : ez\_urlalias
======================================

Created by sarah.haim-lubczanski@ez.no, last modified by
jerome.vieilledent@ez.no on Nov 03, 2014

Description
-----------

``ez_urlalias`` is a not a real Twig helper, but a \ **special route
name** for generating URLs for a location, from the given parameters.

Prototype and Arguments
-----------------------

**path(** eZ\\Publish\\API\\Repository\\Values\\Content\\Location\|string
name[, array parameters][, bool absolute] \ **)**

Argument name

Type

Description

name

| string \| \\eZ\\Publish\\API\\Repository\\Values\\Content\\Location

The name of the route or a Location instance

parameters

array

An hash of parameters:

-  ``locationId``
-  ``contentId`` (as of 5.4 / 2014.11) 

absolute

boolean

Whether to generate an absolute URL

Working with Location
---------------------

Linking to other locations is fairly easy and is done with
`native \ ``path()`` Twig
helper <http://symfony.com/doc/2.3/book/templating.html#linking-to-pages>`__
(or ``url()`` if you want to generate absolute URLs). You just have to
pass it the Location object and ``path()`` will generate the URLAlias
for you.

.. code:: theme:

    {# Assuming "location" variable is a valid eZ\Publish\API\Repository\Values\Content\Location object #}
    <a href="{{ path( location ) }}">Some link to a location</a>

 

I don't have the Location object
--------------------------------

Generating a link from a Location ID
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code:: theme:

    <a href="{{ path( "ez_urlalias", {"locationId": 123} ) }}">Some link to a location, with its Id only</a>

 

Generating a link from a Content ID
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Link generation from contentId is available as of 5.4 / 2014.11.

.. code:: theme:

    <a href="{{ path( "ez_urlalias", {"contentId": 456} ) }}">Some link from a contentId</a>

 

**Important: Links generated from a Content ID will point to its main
location.**

Error management
----------------

For Location alias setup 301 redirect to Location's current URL when:

#. alias is history
#. alias is custom with forward flag true
#. requested URL is not case-sensitive equal with the one loaded

 

Under the hood

Icon

In the backend, ``path()`` uses the Router to generate links.

This makes also easy to generate links from PHP, via the ``router``
service.

Document generated by Confluence on Mar 03, 2015 15:13
