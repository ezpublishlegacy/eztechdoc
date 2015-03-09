#. `eZ Publish Platform 5.x <index.html>`__
#. `eZ Publish Platform
   Documentation <eZ-Publish-Platform-Documentation_1114149.html>`__
#. `Development & Administration Guides <6291674.html>`__
#. `Features <Features_12781009.html>`__
#. `MVC and Application <MVC-and-Application_2719826.html>`__

eZ Publish Platform 5.x : Authentication
========================================

Created by sarah.haim-lubczanski@ez.no, last modified by
jerome.vieilledent@ez.no on Jul 01, 2014

(>= EZP 5.3, >= EZP Community 2014.01)

-  `Authentication using Symfony Security
   component <#Authentication-AuthenticationusingSymfonySecuritycomponent>`__

   -  `Security controller <#Authentication-Securitycontroller>`__

      -  `Redirection after
         login <#Authentication-Redirectionafterlogin>`__

   -  `Configuration <#Authentication-Configuration>`__
   -  `Access control <#Authentication-Accesscontrol>`__
   -  `Remember me <#Authentication-Rememberme>`__
   -  `Login handlers / SSO <#Authentication-Loginhandlers/SSO>`__
   -  `Integration with
      Legacy <#Authentication-IntegrationwithLegacy>`__

-  `Authentication with Legacy SSO
   Handlers <#Authentication-AuthenticationwithLegacySSOHandlers>`__
-  `Upgrade notes <#Authentication-Upgradenotes>`__

Version compatibility

Icon

This documentation page is compatible with \ **eZ Publish 5.3 /
2014.01**

Prior to these versions, authentication was made through legacy stack
only, using the venerable \ ``user/login`` module, with the help of
a \ ``PreAuthenticatedProvider``.

Authentication using Symfony Security component
-----------------------------------------------

 `Native and
universal \ ``form_login`` <http://symfony.com/doc/2.3/book/security.html#using-a-traditional-login-form>`__ is
used, in conjunction to an extended \ ``DaoAuthenticationProvider`` (DAO
stands for \ *Data Access Object*),
the \ ``RepositoryAuthenticationProvider``. Native behavior
of \ ``DaoAuthenticationProvider`` has been preserved, making it
possible to still use it for pure Symfony applications.

Security controller
~~~~~~~~~~~~~~~~~~~

A \ ``SecurityController`` is used to manage all security related
actions and is thus used to display login form. It is pretty straight
forward and follows all standards explained in \ `Symfony security
documentation <http://symfony.com/doc/2.3/book/security.html#using-a-traditional-login-form>`__.

Base template used
is \ ``EzPublishCoreBundle:Security:login.html.twig`` and stands as
follows:

.. code:: theme:

    {% extends layout %}

    {% block content %}
        {% block login_content %}
            {% if error %}
                <div>{{ error.message|trans }}</div>
            {% endif %}

            <form action="{{ path( 'login_check' ) }}" method="post">
            {% block login_fields %}
                <label for="username">{{ 'Username:'|trans }}</label>
                <input type="text" id="username" name="_username" value="{{ last_username }}" />

                <label for="password">{{ 'Password:'|trans }}</label>
                <input type="password" id="password" name="_password" />

                <input type="hidden" name="_csrf_token" value="{{ csrf_token }}" />

                {#
                    If you want to control the URL the user
                    is redirected to on success (more details below)
                    <input type="hidden" name="_target_path" value="/account" />
                #}

                <button type="submit">{{ 'Login'|trans }}</button>
            {% endblock %}
            </form>
        {% endblock %}
    {% endblock %}

The layout used by default
is \ ``%ezpublish.content_view.viewbase_layout%`` (empty layout) but can
be configured easily as well as the login template:

**ezpublish.yml**

.. code:: theme:

    ezpublish:
        system:
            my_siteaccess:
                user:
                    layout: "AcmeTestBundle::layout.html.twig"
                    login_template: "AcmeTestBundle:User:login.html.twig"

Redirection after login
^^^^^^^^^^^^^^^^^^^^^^^

By default, Symfony redirects to the \ `URI configured
in \ ``security.yml`` as ``default_target_path`` <http://symfony.com/doc/2.3/reference/configuration/security.html>`__.
If not set, it will default to \ ``/``.

This setting can be set by SiteAccess,
via \ ```default_page`` setting <EzPublishCoreBundle-Configuration_12124768.html#EzPublishCoreBundleConfiguration-EzPublishCoreBundleConfiguration-Defaultpage>`__.

Configuration
~~~~~~~~~~~~~

To use Symfony authentication with eZ Publish, the configuration goes as
follows:

**ezpublish/config/security.yml**

.. code:: theme:

    security:
        firewalls:
            ezpublish_front:
                pattern: ^/
                anonymous: ~
                form_login:
                    require_previous_session: false
                logout: ~

**ezpublish/config/routing.yml**

.. code:: theme:

    login:
        path:   /login
        defaults:  { _controller: ezpublish.security.controller:loginAction }
    login_check:
        path:   /login_check
    logout:
        path:   /logout

Note

Icon

You can fully customize the routes and/or the controller used for login.
However, ensure to match ``login_path``, ``check_path`` and logout.path
from ``security.yml``.

See `security configuration
reference <http://symfony.com/doc/2.3/reference/configuration/security.html>`__
and `standard login form
documentation <http://symfony.com/doc/2.3/book/security.html#using-a-traditional-login-form>`__.

 

Access control
~~~~~~~~~~~~~~

See the `documentation on access
control <http://doc.ez.no/eZ-Publish/Technical-manual/5.x/Concepts-and-basics/Access-control>`__

Remember me
~~~~~~~~~~~

It is possible to use the \ ``remember_me`` functionality. For this you
can refer to the \ `Symfony cookbook on this
topic <http://symfony.com/doc/2.3/cookbook/security/remember_me.html>`__.

If you want to use this feature, you must at least extend the login
template in order to add the required checkbox:

.. code:: theme:

    {# your_login_template.html.twig #}
    {% extends "EzPublishCoreBundle:Security:login.html.twig" %}

    {% block login_fields %}
        {{ parent() }}
        <input type="checkbox" id="remember_me" name="_remember_me" checked />
        <label for="remember_me">Keep me logged in</label>
    {% endblock %}

Login handlers / SSO
~~~~~~~~~~~~~~~~~~~~

Symfony provides native support for \ `multiple user
providers <http://symfony.com/doc/2.3/book/security.html#using-multiple-user-providers>`__.
This makes it easy to integrate any kind of login handlers, including
SSO and existing 3rd party bundles
(e.g. `FR3DLdapBundle <https://github.com/Maks3w/FR3DLdapBundle>`__, \ `HWIOauthBundle <https://github.com/hwi/HWIOAuthBundle>`__, \ `FOSUserBundle <https://github.com/FriendsOfSymfony/FOSUserBundle>`__, \ `BeSimpleSsoAuthBundle <http://github.com/BeSimple/BeSimpleSsoAuthBundle>`__...).

Further explanation can be found in the \ `multiple user providers
cookbook
entry <How-to-authenticate-a-user-with-multiple-user-providers_19891606.html>`__.

Integration with Legacy
~~~~~~~~~~~~~~~~~~~~~~~

-  When \ **not** in legacy mode,
   legacy \ ``user/login`` and ``user/logout`` views are deactivated.
-  Authenticated user is injected in legacy kernel.

Authentication with Legacy SSO Handlers
---------------------------------------

To be able to use your legacy SSO (Single Sign-on) handlers, use the
following config in your ``ezpublish/config/security.yml``:

**Use your legacy SSO handlers**

.. code:: theme:

    security:
        firewalls:
            ezpublish_front:
                pattern: ^/
                anonymous: ~
                # Adding the following entry will activate the use of old SSO handlers.
                ezpublish_legacy_sso: ~ 

Icon

If you need to\ `create your legacy SSO Handler, please read this
entry <http://share.ez.no/learn/ez-publish/using-a-sso-in-ez-publish>`__

Upgrade notes
-------------

Icon

Follow the notes below if you upgrade from 5.2 to 5.3 / 2013.11 to
2014.01

-  In \ ``ezpublish/config/security.yml``, you must
   remove \ ``ezpublish: true`` from ``ezpublish_front`` firewall.
-  In \ ``ezpublish/config/routing.yml``, you must
   add \ ``login``, \ ``login_check`` and ``logout`` routes (see above
   in [Configuration][])
-  In your templates, change your links pointing
   to \ ``/user/login`` and ``/user/logout`` to appropriate
   login/login\_check/logout routes:

*Before:*

.. code:: theme:

    <a href="{{ path( 'ez_legacy', {'module_uri': '/user/login'} ) }}">Login</a>

    <form action="{{ path( 'ez_legacy', {'module_uri': '/user/login'} ) }}" method="post">

    <a href="{{ path( 'ez_legacy', {'module_uri': '/user/logout'} ) }}">Logout</a>

*After:*

.. code:: theme:

    <a href="{{ path( 'login' ) }}">Login</a>

    <form action="{{ path( 'login_check' ) }}" method="post">

    <a href="{{ path( 'logout' ) }}">Logout</a>

Document generated by Confluence on Mar 03, 2015 15:12
