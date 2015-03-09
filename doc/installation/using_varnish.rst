#. `eZ Publish Platform 5.x <index.html>`__
#. `eZ Publish Platform
   Documentation <eZ-Publish-Platform-Documentation_1114149.html>`__
#. `Installation and Upgrade
   Guides <Installation-and-Upgrade-Guides_6292016.html>`__
#. `Installation <Installation_7438500.html>`__

eZ Publish Platform 5.x : Using Varnish
=======================================

Created and last modified by jerome.vieilledent@ez.no on Nov 27, 2014

eZ Publish 5 being built on top of Symfony 2, it uses standard HTTP
cache headers. By default the Symfony 2 reverse proxy, written in PHP,
is used to handle cache, but it can be easily replaced with any other
reverse proxy like Varnish.

Icon

**Version compatibility:** 5.4 / 2014.11

To use Varnish with 5.2 or 5.3, please see `Using Varnish with eZ
Publish 5.2-5.3 <Using-Varnish-with-eZ-Publish-5.2-5.3_25985748.html>`__

-  `Prerequisites <#UsingVarnish-Prerequisites>`__
-  `Recommended VCL base
   files <#UsingVarnish-RecommendedVCLbasefiles>`__
-  `Configure eZ Publish <#UsingVarnish-ConfigureeZPublish>`__

   -  `Update your Virtual Host <#UsingVarnish-UpdateyourVirtualHost>`__

      -  `On apache: <#UsingVarnish-Onapache:>`__
      -  `On nginx: <#UsingVarnish-Onnginx:>`__

   -  `Update YML
      configuration <#UsingVarnish-UpdateYMLconfiguration>`__

-  `Previous versions <#UsingVarnish-Previousversions>`__

Prerequisites
-------------

-  A working Varnish 3 or Varnish 4 setup.

Recommended VCL base files
--------------------------

For Varnish to work properly with eZ, you'll need to use one of the
provided files as a basis:

-  `eZ 5.4+ / 2014.09+ with Varnish
   3 <https://github.com/ezsystems/ezpublish-community/blob/master/doc/varnish/vcl/varnish3.vcl>`__
-  `eZ 5.4+ / 2014.09+ with Varnish
   4 <https://github.com/ezsystems/ezpublish-community/blob/master/doc/varnish/vcl/varnish4.vcl>`__

    **Note:** Http cache management is done with the help of
    `FOSHttpCacheBundle <http://foshttpcachebundle.readthedocs.org/>`__.
    One may need to tweak their VCL further on according to
    `FOSHttpCache
    documentation <http://foshttpcache.readthedocs.org/en/latest/varnish-configuration.html>`__
    in order to use features supported by it.

Configure eZ Publish
--------------------

Update your Virtual Host
~~~~~~~~~~~~~~~~~~~~~~~~

On apache:
^^^^^^^^^^

**my\_virtualhost.conf**

.. code:: theme:

    <VirthualHost *:80>
        # Configure your VirtualHost with rewrite rules and stuff
     
        # Force front controller NOT to use built-in reverse proxy.
        SetEnv USE_HTTP_CACHE 0
     
        # Configure IP of your Varnish server to be trusted proxy
        # Replace fake IP address below by your Varnish IP address
        SetEnv TRUSTED_PROXIES "193.22.44.22"
    </VirtualHost>

On nginx:
^^^^^^^^^

**mysite.com**

.. code:: theme:

    fastcgi_param USE_HTTP_CACHE 0
    # Configure IP of your Varnish server to be trusted proxy
    # Replace fake IP address below by your Varnish IP address
    fastcgi_param TRUSTED_PROXIES "193.22.44.22"

Update YML configuration
~~~~~~~~~~~~~~~~~~~~~~~~

**ezpublish.yml**

.. code:: theme:

    ezpublish:
        http_cache:
            # As of 5.4 only use "http"
            # "single_http" and "multiple_http" are deprecated but will still work.
            purge_type: http
     
        system:
            # Assuming that my_siteaccess_group your frontend AND backend siteaccesses
            my_siteaccess_group:
                http_cache:
                    # Fill in your Varnish server(s) address(es).
                    purge_servers: [http://my.varnish.server:6081]

Previous versions
-----------------

-  `Using Varnish with eZ Publish
   5.2-5.3 <Using-Varnish-with-eZ-Publish-5.2-5.3_25985748.html>`__
-  `Using Varnish with eZ Publish Platform
   5.4 <Using-Varnish-with-eZ-Publish-Platform-5.4_25985773.html>`__

Comments:
---------

+--------------------------------------------------------------------------+
| Shouldn't we maitain following if from the varnish default.vcl in our    |
| ezpublish.vcl?                                                           |
|                                                                          |
| `https://www.varnish-cache.org/trac/browser/bin/varnishd/default.vcl?rev |
| =3.0#L59 <https://www.varnish-cache.org/trac/browser/bin/varnishd/defaul |
| t.vcl?rev=3.0#L59>`__                                                    |
|                                                                          |
| If removed, i have problems with post requests, example, sending data in |
| a contact form...                                                        |
|                                                                          |
| |image5| Posted by desorden at Jan 29, 2014 15:24                        |
+--------------------------------------------------------------------------+
| Out of scope of ez5 itself, but if you need to install \ `Varnish Curl   |
| Vmod <https://github.com/varnish/libvmod-curl>`__, there is a good       |
| tutorial here (for Debian)                                               |
|                                                                          |
| `http://lassekarstensen.wordpress.com/2013/07/29/building-a-varnish-vmod |
| -on-debian/ <http://lassekarstensen.wordpress.com/2013/07/29/building-a- |
| varnish-vmod-on-debian/>`__                                              |
|                                                                          |
| It uses another module but the process is the same for all modules.      |
|                                                                          |
| |image6| Posted by desorden at Jan 29, 2014 15:27                        |
+--------------------------------------------------------------------------+
| Carlos: Thanks. I just added this link to the page as an example for     |
| Debian.                                                                  |
|                                                                          |
| |image7| Posted by jerome.vieilledent@ez.no at Jan 30, 2014 08:24        |
+--------------------------------------------------------------------------+
| This doc page should mention that the Apache environment                 |
| variable TRUSTED\_PROXIES should be set if your Varnish install(s) sits  |
| on a different server.  Otherwise you will get a nasty surprise when ESI |
| breaks.                                                                  |
|                                                                          |
| |image8| Posted by peterkeung at Aug 18, 2014 20:40                      |
+--------------------------------------------------------------------------+
| Peter: Added, thanks!                                                    |
|                                                                          |
| |image9| Posted by andre.romcke@ez.no at Nov 16, 2014 18:43              |
+--------------------------------------------------------------------------+

Document generated by Confluence on Mar 03, 2015 15:12

.. |image0| image:: images/icons/contenttypes/comment_16.png
.. |image1| image:: images/icons/contenttypes/comment_16.png
.. |image2| image:: images/icons/contenttypes/comment_16.png
.. |image3| image:: images/icons/contenttypes/comment_16.png
.. |image4| image:: images/icons/contenttypes/comment_16.png
.. |image5| image:: images/icons/contenttypes/comment_16.png
.. |image6| image:: images/icons/contenttypes/comment_16.png
.. |image7| image:: images/icons/contenttypes/comment_16.png
.. |image8| image:: images/icons/contenttypes/comment_16.png
.. |image9| image:: images/icons/contenttypes/comment_16.png
