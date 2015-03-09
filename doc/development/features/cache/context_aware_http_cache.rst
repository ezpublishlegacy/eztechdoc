#. `eZ Publish Platform 5.x <index.html>`__
#. `eZ Publish Platform
   Documentation <eZ-Publish-Platform-Documentation_1114149.html>`__
#. `Development & Administration Guides <6291674.html>`__
#. `Features <Features_12781009.html>`__
#. `Cache <Cache_6291890.html>`__

eZ Publish Platform 5.x : Context aware HTTP cache
==================================================

Created by jerome.vieilledent@ez.no, last modified by
sarah.haim-lubczanski@ez.no on Jan 19, 2015

Icon

If you are looking for 5.2/5.3 Context aware HTTP cache, see the page
`Context aware HTTP cache in eZ Publish
5.2-5.3 <Context-aware-HTTP-cache-in-eZ-Publish-5.2-5.3_25985739.html>`__

-  `Use case <#ContextawareHTTPcache-Usecase>`__
-  `Credits <#ContextawareHTTPcache-Credits>`__
-  `Feature <#ContextawareHTTPcache-Feature>`__
-  `Http cache clear <#ContextawareHTTPcache-Httpcacheclear>`__
-  `Symfony reverse
   proxy <#ContextawareHTTPcache-Symfonyreverseproxy>`__
-  `Varnish <#ContextawareHTTPcache-Varnish>`__
-  `User context hash <#ContextawareHTTPcache-Usercontexthash>`__
-  `Workflow <#ContextawareHTTPcache-Workflow>`__
-  `User hash generation <#ContextawareHTTPcache-Userhashgeneration>`__

   -  `User hash generation with Varnish
      3 <#ContextawareHTTPcache-UserhashgenerationwithVarnish3>`__
   -  `Default options for FOSHttpCacheBundle defined in
      eZ <#ContextawareHTTPcache-DefaultoptionsforFOSHttpCacheBundledefinedineZ>`__

This feature is available as of \ **eZ Publish 5.2**

Use case
--------

Being based on Symfony 2, eZ Publish 5 uses HTTP cache from version 5.0
`extended with content
awareness <Context-aware-HTTP-cache_14712846.html>`__. However this
cache management is only available for anonymous users due to HTTP
restrictions.

It is of course possible to make HTTP cache vary thanks to
the \ ``Vary`` response header, but this header can only be based on one
of the request headers (e.g. ``Accept-Encoding``). Thus, to make the
cache vary on a specific context (e.g. a hash based on a user roles and
limitations), this context must be present in the original request.

Credits
-------

This feature is based on \ `Context aware HTTP caching
post <http://asm89.github.io/2012/09/26/context-aware-http-caching.html>`__ by `asm89 <https://github.com/asm89>`__.

Feature
-------

As the response can vary on a request header, the base solution is to
make the kernel do a sub-request in order to retrieve the context
(aka **user hash**). Once the \ *user hash* has been retrieved, it's
injected in the original request in the \ ``X-User-Hash`` custom header,
making it possible to \ *vary* the HTTP response on this header:

.. code:: theme:

    <?php
    use Symfony\Component\HttpFoundation\Response;

    // ...

    // Inside a controller action
    $response = new Response();
    $response->setVary( 'X-User-Hash' );

This solution is implemented in Symfony reverse proxy (aka *HttpCache*)
and is also accessible to dedicated reverse proxies like Varnish.

Icon

Note that sharing ESIs across SiteAccesses is not possible by design
(see `|image0|\ EZP-22535 <https://jira.ez.no/browse/EZP-22535>`__ -
Cached ESI can not be shared across pages/siteaccesses due to "pathinfo"
property Closed for technical details)

Http cache clear
----------------

5.4 / 2014.11

As of v5.4 / v2014.11, usage of
`FOSHttpCacheBundle <http://foshttpcachebundle.readthedocs.org/>`__ has
been introduced, impacting the following features:

-  Http cache purge
-  User context hash

Varnish proxy client from FOSHttpCache lib is now used for clearing eZ
Http cache, even when using Symfony HttpCache. A single ``BAN`` request
is sent to registered purge servers, containing a ``X-Location-Id``
header. This header contains all Location IDs for which objects in cache
need to be cleared.

Symfony reverse proxy
---------------------

Symfony reverse proxy (aka HttpCache) is supported out of the box, all
you have to do is to activate it.

Varnish
-------

Icon

Please refer to \ `Using Varnish with eZ Publish Platform
5.4 <Using-Varnish-with-eZ-Publish-Platform-5.4_25985773.html>`__

User context hash
-----------------

`FOSHttpCacheBundle *User Context feature* is
used <http://foshttpcachebundle.readthedocs.org/en/latest/features/user-context.html>`__
is activated by default.

As the response can vary on a request header, the base solution is to
make the kernel do a sub-request in order to retrieve the context (aka
**user context hash**). Once the *user hash* has been retrieved, it's
injected in the original request in the ``X-User-Hash`` header, making
it possible to *vary* the HTTP response on this header:

Icon

Name of the `user hash header is configurable in
FOSHttpCacheBundle <http://foshttpcachebundle.readthedocs.org/en/latest/reference/configuration/user-context.html>`__.
By default eZ Publish sets it to ``**X-User-Hash**``.

.. code:: theme:

    <?php 
    use Symfony\Component\HttpFoundation\Response;
     
    // ...
     
    // Inside a controller action
    $response = new Response();
    $response->setVary( 'X-User-Hash' );

 

This solution is `implemented in Symfony reverse proxy (aka
*HttpCache*) <http://foshttpcachebundle.readthedocs.org/en/latest/features/symfony-http-cache.html>`__
and is also accessible to `dedicated reverse proxies like
Varnish <http://foshttpcache.readthedocs.org/en/latest/varnish-configuration.html>`__.

Workflow
--------

Icon

Please refer to `FOSHttpCacheBundle documentation on how user context
feature
works <http://foshttpcachebundle.readthedocs.org/en/latest/features/user-context.html#how-it-works>`__.

User hash generation
--------------------

Icon

Please refer to `FOSHttpCacheBundle documentation on how user hashes are
being
generated <http://foshttpcachebundle.readthedocs.org/en/latest/features/user-context.html#generating-hashes>`__.

eZ Publish already interferes in the hash generation process, by adding
current user permissions and limitations. One can also interfere in this
process by `implementing custom context
provider(s) <http://foshttpcachebundle.readthedocs.org/en/latest/reference/configuration/user-context.html#custom-context-providers>`__.

User hash generation with Varnish 3
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Described behavior comes out of the box with Symfony reverse proxy, but
it's of course possible ot use Varnish to achieve the same.

.. code:: theme:

    # Varnish 3 style for eZ Publish 5.4 / 2014.11
    # Our Backend - We assume that eZ Publish Web server listen on port 80 on the same machine.
    backend ezpublish {
        .host = "127.0.0.1";
        .port = "80";
    }

    # Called at the beginning of a request, after the complete request has been received
    sub vcl_recv {

        # Set the backend
        set req.backend = ezpublish;

        # ...

        # Retrieve client user hash and add it to the forwarded request.
        call ez_user_hash;

        # If it passes all these tests, do a lookup anyway;
        return (lookup);
    }

    # Sub-routine to get client user hash, for context-aware HTTP cache.
    # Don't forget to correctly set the backend host for the Curl sub-request.
    sub ez_user_hash {

        # Prevent tampering attacks on the hash mechanism
        if (req.restarts == 0
            && (req.http.accept ~ "application/vnd.fos.user-context-hash"
                || req.http.x-user-context-hash
            )
        ) {
            error 400;
        }

        if (req.restarts == 0 && (req.request == "GET" || req.request == "HEAD")) {
            # Anonymous user => Set a hardcoded anonymous hash
            if (req.http.Cookie !~ "eZSESSID" && !req.http.authorization) {
                set req.http.X-User-Hash = "38015b703d82206ebc01d17a39c727e5";
            }
            # Pre-authenticate request to get shared cache, even when authenticated
            else {
                set req.http.x-fos-original-url    = req.url;
                set req.http.x-fos-original-accept = req.http.accept;
                set req.http.x-fos-original-cookie = req.http.cookie;
                # Clean up cookie for the hash request to only keep session cookie, as hash cache will vary on cookie.
                set req.http.cookie = ";" + req.http.cookie;
                set req.http.cookie = regsuball(req.http.cookie, "; +", ";");
                set req.http.cookie = regsuball(req.http.cookie, ";(eZSESSID[^=]*)=", "; \1=");
                set req.http.cookie = regsuball(req.http.cookie, ";[^ ][^;]*", "");
                set req.http.cookie = regsuball(req.http.cookie, "^[; ]+|[; ]+$", "");

                set req.http.accept = "application/vnd.fos.user-context-hash";
                set req.url = "/_fos_user_context_hash";

                # Force the lookup, the backend must tell not to cache or vary on all
                # headers that are used to build the hash.

                return (lookup);
            }
        }

        # Rebuild the original request which now has the hash.
        if (req.restarts > 0
            && req.http.accept == "application/vnd.fos.user-context-hash"
        ) {
            set req.url         = req.http.x-fos-original-url;
            set req.http.accept = req.http.x-fos-original-accept;
            set req.http.cookie = req.http.x-fos-original-cookie;

            unset req.http.x-fos-original-url;
            unset req.http.x-fos-original-accept;
            unset req.http.x-fos-original-cookie;

            # Force the lookup, the backend must tell not to cache or vary on the
            # user hash to properly separate cached data.

            return (lookup);
        }
    }

    sub vcl_fetch {

        # ...

        if (req.restarts == 0
            && req.http.accept ~ "application/vnd.fos.user-context-hash"
            && beresp.status >= 500
        ) {
            error 503 "Hash error";
        }
    }

    sub vcl_deliver {
        # On receiving the hash response, copy the hash header to the original
        # request and restart.
        if (req.restarts == 0
            && resp.http.content-type ~ "application/vnd.fos.user-context-hash"
            && resp.status == 200
        ) {
            set req.http.x-user-hash = resp.http.x-user-hash;

            return (restart);
        }

        # If we get here, this is a real response that gets sent to the client.

        # Remove the vary on context user hash, this is nothing public. Keep all
        # other vary headers.
        set resp.http.Vary = regsub(resp.http.Vary, "(?i),? *x-user-hash *", "");
        set resp.http.Vary = regsub(resp.http.Vary, "^, *", "");
        if (resp.http.Vary == "") {
            remove resp.http.Vary;
        }

        # Sanity check to prevent ever exposing the hash to a client.
        remove resp.http.x-user-hash;
    }

 

Default options for FOSHttpCacheBundle defined in eZ
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

The following configuration is defined in eZ by default for
FOSHttpCacheBundle. You may override these settings.

.. code:: theme:

    fos_http_cache: 
        proxy_client: 
            # "varnish" is used, even when using Symfony HttpCache.
            default: varnish
            varnish: 
                # Means http_cache.purge_servers defined for current SiteAccess.
                servers: [$http_cache.purge_servers$]

        user_context: 
            enabled: true
            # User context hash is cached during 10min
            hash_cache_ttl: 600
            user_hash_header: X-User-Hash

 

::

     

Document generated by Confluence on Mar 03, 2015 15:12

.. |image0| image:: https://jira.ez.no/images/icons/issuetypes/bug.png
