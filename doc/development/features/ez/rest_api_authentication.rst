#. `eZ Publish Platform 5.x <index.html>`__
#. `eZ Publish Platform
   Documentation <eZ-Publish-Platform-Documentation_1114149.html>`__
#. `Development & Administration Guides <6291674.html>`__
#. `Features <Features_12781009.html>`__
#. `eZ Publish REST API <eZ-Publish-REST-API_6292277.html>`__

eZ Publish Platform 5.x : REST API Authentication
=================================================

Created by bertrand.dunogier@ez.no, last modified by andre.romcke@ez.no
on Feb 11, 2015

Since 5.0, two authentication methods are supported: session, and basic.

**Session based authentication** is meant to be used for AJAX
operations. It will let you re-use the visitor's session to execute
operations with their permissions.

**Basic authentication** is often used when writing cross-server
procedures, when one remote application executes operations on
one/several eZ Publish instances (remote publishing, maintenance, etc).

The default authentication method in 5.x is Basic authentication. As of
release 2015.01, Session has been changed to be default.

Session based authentication
----------------------------

This authentication method requires a Session cookie to be sent with
each request.

If this authentication method is used with a web browser, this session
cookie is automatically available as soon as your visitor logs in. Add
it as a cookie to your REST requests, and the user will be
authenticated.

Setting it up
~~~~~~~~~~~~~

Icon

Not needed as of 2015.01 release as default is now Session.

To enable session based authentication, you need to
edit \ ``ezpublish/config/security.yml``, and comment out / remove the
configuration block about Basic Auth (shown in the following section).

Important

Icon

As of 5.3 / 2014.04, you also need to add the following configuration in
your ``ezpublish/config/security.yml``:

.. code:: theme:

    --- a/ezpublish/config/security.yml
    +++ b/ezpublish/config/security.yml
    @@ -33,6 +33,7 @@ security:
             ezpublish_front:
                 pattern: ^/
                 anonymous: ~
    +            ezpublish_rest_session: ~
                 form_login:
                     require_previous_session: false
                 logout: ~

 

Logging in
~~~~~~~~~~

It is also possible to create a session for the visitor if he isn't
logged in yet. This is done by sending
a \ **``POST``** request to ``/user/sessions``. Logging out is done
using a \ **``DELETE``** request on the same resource.

More information

Icon

`Session based authentication chapter of the REST
specifications <https://github.com/ezsystems/ezp-next/blob/master/doc/specifications/rest/REST-API-V2.rst#123%C2%A0%C2%A0%C2%A0session-based-authentication>`__

HTTP Basic authentication
-------------------------

To enable HTTP Basic authentication, you need to
edit \ ``ezpublish/config/security.yml``, and add/uncomment the
following block. Note that this is enabled by default.

**ezpublish.yml**

.. code:: theme:

            ezpublish_rest:
                pattern: ^/api/ezp/v2
                stateless: true
                ezpublish_http_basic:
                    realm: eZ Publish REST API

Basic authentication requires the password to be sent, based 64 encoded,
with each request, as explained in \ `RFC
2617 <http://tools.ietf.org/html/rfc2617>`__.

Most HTTP client libraries as well as REST libraries do support this
method one way or another.

**Raw HTTP request with basic authentication**

.. code:: theme:

    GET / HTTP/1.1
    Host: api.example.com
    Accept: application/vnd.ez.api.Root+json
    Authorization: Basic QWxhZGRpbjpvcGVuIHNlc2FtZQ==

Comments:
---------

+--------------------------------------------------------------------------+
| A note for people playing around with using the Symfony firewall(s) with |
| different access rules for different pats of APIs: if you use            |
| "ezpublish" as autehnticator for a new firewall you define for a part of |
| the site, you will get symfony exceptions unless you reste the           |
| check\_path and login\_path variables, eg:                               |
|                                                                          |
| ::                                                                       |
|                                                                          |
|             xxx_rest_withsession:                                        |
|                                                                          |
| ::                                                                       |
|                                                                          |
|                 pattern: ^/api/xxx_rest_session/v1                       |
|                                                                          |
| ::                                                                       |
|                                                                          |
|                 ezpublish:                                               |
|                                                                          |
| ::                                                                       |
|                                                                          |
|                     check_path:                                          |
|                                                                          |
| ::                                                                       |
|                                                                          |
|                     login_path:                                          |
|                                                                          |
| |image1| Posted by gaetano.giunta@ez.no at Mar 17, 2014 14:06            |
+--------------------------------------------------------------------------+

Document generated by Confluence on Mar 03, 2015 15:12

.. |image0| image:: images/icons/contenttypes/comment_16.png
.. |image1| image:: images/icons/contenttypes/comment_16.png
