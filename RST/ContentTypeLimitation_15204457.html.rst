#. `eZ Publish Platform 5.x <index.html>`__
#. `eZ Publish Platform
   Documentation <eZ-Publish-Platform-Documentation_1114149.html>`__
#. `Reference <Reference_10158191.html>`__
#. `Limitations reference <Limitations-reference_15204365.html>`__

eZ Publish Platform 5.x : ContentTypeLimitation
===============================================

Created by andre.romcke@ez.no, last modified by ricardo.correia@ez.no on
Jul 25, 2013

A limitation to specify if user has access to ``Content`` with a
specific ``ContentType``.

+-------------------+------------------------------------------------------------------------------+
| Identifier        | ``Class``                                                                    |
+-------------------+------------------------------------------------------------------------------+
| Value Class       | ``eZ\Publish\API\Repository\Values\User\Limitation\ContentTypeLimitation``   |
+-------------------+------------------------------------------------------------------------------+
| Type Class        | ``eZ\Publish\Core\Limitation\ContentTypeLimitationType``                     |
+-------------------+------------------------------------------------------------------------------+
| Criterion used    | ``eZ\Publish\API\Repository\Values\Content\Query\Criterion\ContentTypeId``   |
+-------------------+------------------------------------------------------------------------------+
| Role Limitation   | no                                                                           |
+-------------------+------------------------------------------------------------------------------+

Possible values
               

Value

UI value

Description

``<ContentType_id>``

``<ContentType_name>``

All valid ``ContentType`` ids can be set as value(s)

Document generated by Confluence on Mar 03, 2015 15:13
