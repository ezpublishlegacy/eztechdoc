#. `eZ Publish Platform 5.x <index.html>`__
#. `eZ Publish Platform
   Documentation <eZ-Publish-Platform-Documentation_1114149.html>`__
#. `Development & Administration Guides <6291674.html>`__
#. `Features <Features_12781009.html>`__
#. `MVC and Application <MVC-and-Application_2719826.html>`__
#. `Templating <Templating_8323395.html>`__

eZ Publish Platform 5.x : Image alias generation
================================================

Created by sarah.haim-lubczanski@ez.no, last modified by
andre.romcke@ez.no on Feb 10, 2015

Version compatibility

Icon

This feature is available since **eZ Publish 5.4 / 2014.11**

Description
-----------

Image alias generation is now using
`LiipImagineBundle <https://github.com/liip/LiipImagineBundle>`__, with
underlying `Imagine library from
avalanche123 <http://imagine.readthedocs.org/en/latest/>`__.

This bundle allows to use either GD, Imagick or Gmagick PHP extensions
and allows to define flexible filters in PHP.

Image variations are managed by the ``IOService`` and are completely
independent from ``ezimage`` FieldType. They are generated only once and
cleared on demand (e.g. content removal).

` <https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/image/image_alias_imagine.md#configuration>`__\ Configuration
---------------------------------------------------------------------------------------------------------------------------------------------

Image variation (aka "Image alias") definition follows the same format
as before, in ``ezpublish.yml`` or any imported semantic configuration
file. It's `dynamic <Configuration_2720538.html>`__, so can be
configured per site access and all the other scopes.

.. code:: theme:

    # Example
    ezpublish:
        system:
            my_siteaccess:
                image_variations:
                    small:
                        reference: null
                        filters:
                            - { name: geometry/scaledownonly, params: [100, 160] }
                    medium:
                        reference: null
                        filters:
                            - { name: geometry/scaledownonly, params: [200, 290] }
                    listitem:
                        reference: null
                        filters:
                            - { name: geometry/scaledownonly, params: [130, 190] }
                    articleimage:
                        reference: null
                        filters:
                            - { name: geometry/scalewidth, params: [770] }

Icon

**Important:** Each variation name **must be unique**. It may contain
``_`` or ``-`` or numbers, but no space.

-  ``reference``: Name of a reference variation to base the variation
   on. If ``null`` (or ``~``, which means ``null`` un YAML), the
   variation will take the original image for reference. It can be any
   available variation configured in ``ezpublish`` namespace, or a
   ``filter_set`` defined in ``liip_imagine`` namespace.

-  ``filters``: array of filter definitions (hashes containing ``name``
   and ``params`` keys). See possible values below.

` <https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/image/image_alias_imagine.md#available-filters>`__\ Available filters
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

In addition to `filters exposed by
LiipImagineBundle <https://github.com/liip/LiipImagineBundle/blob/master/Resources/doc/configuration.rst>`__,
the following are available:

+--------------------------------+--------------------------------------------+------------------------------------------------------------------------------------------------------------+
| Filter name                    | Parameters                                 | Description                                                                                                |
+================================+============================================+============================================================================================================+
| geometry/scaledownonly         | [width, height]                            | Generates a thumbnail that will not exceed width/height.                                                   |
+--------------------------------+--------------------------------------------+------------------------------------------------------------------------------------------------------------+
| geometry/scalewidthdownonly    | [width]                                    | Generates a thumbnail that will not exceed width.                                                          |
+--------------------------------+--------------------------------------------+------------------------------------------------------------------------------------------------------------+
| geometry/scaleheightdownonly   | [height]                                   | Generates a thumbnail that will not exceed height.                                                         |
+--------------------------------+--------------------------------------------+------------------------------------------------------------------------------------------------------------+
| geometry/scalewidth            | [width]                                    | Alters image width. Proportion will be kept.                                                               |
+--------------------------------+--------------------------------------------+------------------------------------------------------------------------------------------------------------+
| geometry/scaleheight           | [height]                                   | Alters image height. Proportion will be kept.                                                              |
+--------------------------------+--------------------------------------------+------------------------------------------------------------------------------------------------------------+
| geometry/scale                 | [width, height]                            | Alters image size, not exceeding provided width and height. Proportion will be kept.                       |
+--------------------------------+--------------------------------------------+------------------------------------------------------------------------------------------------------------+
| geometry/scaleexact            | [width, height]                            | Alters image size to fit exactly provided width and height. Proportion will not be kept.                   |
+--------------------------------+--------------------------------------------+------------------------------------------------------------------------------------------------------------+
| geometry/scalepercent          | [widthPercent, heightPercent]              | Scales width and height with provided percent values. Proportion will not be kept.                         |
+--------------------------------+--------------------------------------------+------------------------------------------------------------------------------------------------------------+
| geometry/crop                  | [width, height, startX, startY]            | Crops the image. Result will have provided width/height, starting at provided startX/startY                |
+--------------------------------+--------------------------------------------+------------------------------------------------------------------------------------------------------------+
| border                         | [thickBorderX, thickBorderY, color=#000]   | Adds a border around the image. Thickness is defined in px. Color is "#000" by default.                    |
+--------------------------------+--------------------------------------------+------------------------------------------------------------------------------------------------------------+
| filter/noise                   | [radius=0]                                 | Smooths the contours of an image (``imagick``/``gmagick`` only). ``radius`` is in pixel.                   |
+--------------------------------+--------------------------------------------+------------------------------------------------------------------------------------------------------------+
| filter/swirl                   | [degrees=60]                               | Swirls the pixels of the center of an image (``imagick``/``gmagick`` only). ``degrees`` defaults to 60°.   |
+--------------------------------+--------------------------------------------+------------------------------------------------------------------------------------------------------------+
| resize                         | {size: [width, height]}                    | Simple resize filter (provided by LiipImagineBundle).                                                      |
+--------------------------------+--------------------------------------------+------------------------------------------------------------------------------------------------------------+
| colorspace/gray                | N/A                                        | Converts an image to grayscale.                                                                            |
+--------------------------------+--------------------------------------------+------------------------------------------------------------------------------------------------------------+

    Icon

    *Tip:* It is possible to combine filters from the list above to `the
    ones provided in
    LiipImagineBundle <https://github.com/liip/LiipImagineBundle/blob/master/Resources/doc/filters.rst>`__
    and custom ones.

     

` <https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/image/image_alias_imagine.md#discarded-filters>`__\ Discarded filters
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

The following filters have been discarded due to incompatibility:

-  ``flatten``. Obsolete, images are automatically flattened.
-  ``bordercolor``
-  ``border/width``
-  ``colorspace/transparent``
-  ``colorspace``

` <https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/image/image_alias_imagine.md#custom-filters>`__\ Custom filters
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Please refer to `LiipImagineBundle documentation on custom
filters <https://github.com/liip/LiipImagineBundle/blob/master/Resources/doc/filters.rst#load-your-custom-filters>`__.
`Imagine library
documentation <http://imagine.readthedocs.org/en/latest/>`__ may also be
useful.

Post-Processors
~~~~~~~~~~~~~~~

LiipImagineBundle supports \ `post-processors on image
aliases <https://github.com/liip/LiipImagineBundle/blob/master/Resources/doc/filters.rst#post-processors>`__.
It is possible to specify them in image alias configuration:

.. code:: theme:

    ezpublish:
        system:
            my_siteaccess:
                image_variations:
                    articleimage:
                        reference: null
                        filters:
                            - { name: geometry/scalewidth, params: [770] }
                        post_processors:
                            jpegoptim: {}

Please refer to \ `post-processors documentation in
LiipImagineBundle <https://github.com/liip/LiipImagineBundle/blob/master/Resources/doc/filters.rst#post-processors>`__ for
details.

` <https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/image/image_alias_imagine.md#drivers>`__\ Drivers
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

LiipImagineBundle supports GD (default), Imagick and GMagick PHP
extensions and only work on image blobs (no command line tool is
needed). See the `bundle's documentation to learn more on that
topic <https://github.com/liip/LiipImagineBundle/blob/master/Resources/doc/configuration.rst>`__.

` <https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/image/image_alias_imagine.md#upgrade>`__\ Upgrade
---------------------------------------------------------------------------------------------------------------------------------

-  Instantiate ``LiipImagineBundle`` in your kernel class
-  If you were using ImageMagick, please install
   `Imagick <http://php.net/imagick>`__ or
   `Gmagick <http://php.net/gmagick>`__ PHP extensions and activate the
   driver in ``liip_imagine ``\ (`see LiipImagineBundle configuration
   documentation for more
   information <https://github.com/liip/LiipImagineBundle/blob/master/Resources/doc/configuration.rst>`__):

   .. code:: theme:

       # ezpublish.yml or config.yml
       liip_imagine:
           # Driver can either "imagick", "gmagick" or "gd", depending on the PHP extension you're using.
           driver: imagick

   Icon

   GD will be used by default if no driver is specified.

Comments:
---------

+--------------------------------------------------------------------------+
| Liip has changed the documentation files format (.md -> .rst). So, the   |
| actual links don't work.                                                 |
|                                                                          |
| |image2| Posted by lymathon at Feb 05, 2015 14:14                        |
+--------------------------------------------------------------------------+
| `Mathieu Maury <https://doc.ez.no/display/~lymathon>`__ Thanks for the   |
| information, I updated the links.                                        |
|                                                                          |
| |image3| Posted by sarah.haim-lubczanski@ez.no at Feb 10, 2015 15:58     |
+--------------------------------------------------------------------------+

Document generated by Confluence on Mar 03, 2015 15:12

.. |image0| image:: images/icons/contenttypes/comment_16.png
.. |image1| image:: images/icons/contenttypes/comment_16.png
.. |image2| image:: images/icons/contenttypes/comment_16.png
.. |image3| image:: images/icons/contenttypes/comment_16.png
