#. `eZ Publish Platform 5.x <index.html>`__
#. `eZ Publish Platform
   Documentation <eZ-Publish-Platform-Documentation_1114149.html>`__
#. `Development & Administration Guides <6291674.html>`__
#. `Features <Features_12781009.html>`__
#. `eZ Publish REST API <eZ-Publish-REST-API_6292277.html>`__

eZ Publish Platform 5.x : Getting started with the REST API
===========================================================

Created by bertrand.dunogier@ez.no, last modified by
ricardo.correia@ez.no on Sep 24, 2013

Installation
------------

Nothing needs to be done for this to work. As long as your eZ Publish 5
is correctly configured, the REST API is available on your site using
the URI ``/api/ezp/v2/``. If you have installed eZ Publish in a
subfolder, prepend the path with this
subfolder: http://example.com/\ **su**\ **b/folder/ezpublish**/api/ezp/v2/.

Icon

Please note that the ``/api/ezp/v2`` prefix will be used in all REST
hrefs, but not in URIs.

Configuration
-------------

Authentication
~~~~~~~~~~~~~~

As explained in more detail in the `authentication
chapter <REST-API-Authentication_6292522.html>`__, two authentication
methods are currently supported: session, and basic. By default, basic
authentication is the active mode. It requires a login / password to be
sent using `basic HTTP
authentication <http://en.wikipedia.org/wiki/Basic_access_authentication>`__.
The alternative, session based authentication, uses a session cookie. 

To enable session based authentication, you need to
edit \ ``ezpublish/config/security.yml``, and comment out / remove the
configuration block about REST

**security.yml**

.. code:: theme:

    security:
        # ...
        firewalls:
            # ...
            ezpublish_rest:
                pattern: ^/api/ezp/v2
                ezpublish_http_basic:
                    realm: eZ Publish REST API

Testing the API
---------------

A standard web browser is not sufficient to fully test the API. You can
however try opening the root resource with it, using basic
authentication: http://admin:publish@example.com/api/ezp/v2/. Depending
on how your browser understands XML, it will either download the XML
file, or open it in the browser.

To test further, you can use browser extensions, like `Advanced REST
client for
Chrome <https://chrome.google.com/webstore/detail/advanced-rest-client/hgmloofddffdnphfgcellkdfbfbjeloo>`__
or \ `RESTClient for
Firefox <https://addons.mozilla.org/firefox/addon/restclient/>`__, or
dedicated tools. For command line users,
`HTTPie <https://github.com/jkbr/httpie>`__ is a good tool.

Javascript example
~~~~~~~~~~~~~~~~~~

One of the main reasons for this API is to help implementing Javascript
/ AJAX interaction. You can see here an example of an AJAX call that
retrieves ContentInfo (e.g. metadata) for a content.

**REST API with Javascript**

.. code:: theme:

    <pre id="rest-output"></pre>
    <script>
    var resource = '/api/ezp/v2/content/objects/59',
        log = document.getElementById( 'rest-output' );
    log.innerHTML = "Loading the content info from " + resource + "...";
       
    var request = new XMLHttpRequest();
    request.open('GET', resource, true);
    request.onreadystatechange = function () {
        if ( request.readyState === 4 ) {
            log.innerHTML = "HTTP response from " + resource + "\n\n" + request.getAllResponseHeaders() + "\n" + request.responseText;
        }
    };
    request.setRequestHeader('Accept', 'application/vnd.ez.api.ContentInfo+json');
    request.send();
    </script>

In order to test it, just save this code to some test.html file in the
web folder of your eZ Publish 5 installation. If you use the rewrite
rules, don't forget to allow this file to be served directly.

If necessary, change 59 with the content object id of an object from
your database. You will get the ContentInfo for object 59 in JSON
encoding.  

Note that by default, basic authentication is used. You can either add a
valid login/password in the URI, or submit them when asked to by the
browser. An alternative is to switch to session based authentication, as
explained earlier in this page. In that case, the session cookie will be
transparently sent together with the request, and every AJAX call will
have the same permissions as the currently logged in user.

Comments:
---------

+--------------------------------------------------------------------------+
| Tip: since eZP version 5.2, it is possible to use the REST API from the  |
| siteaccessed used for the Administration Interface (or any siteaccess    |
| which uses legacy\_mode: true) by setting up                             |
|                                                                          |
|     router:                                                              |
|                                                                          |
|         default\_router:                                                 |
|                                                                          |
|             legacy\_aware\_routes: [a\_rest\_api\_prefix\_]              |
|                                                                          |
| |image1| Posted by gaetano.giunta@ez.no at Jan 21, 2014 10:06            |
+--------------------------------------------------------------------------+

Document generated by Confluence on Mar 03, 2015 15:12

.. |image0| image:: images/icons/contenttypes/comment_16.png
.. |image1| image:: images/icons/contenttypes/comment_16.png
