#. `eZ Publish Platform 5.x <index.html>`__
#. `eZ Publish Platform
   Documentation <eZ-Publish-Platform-Documentation_1114149.html>`__
#. `Reference <Reference_10158191.html>`__
#. `Limitations reference <Limitations-reference_15204365.html>`__

eZ Publish Platform 5.x : ParentUserGroupLimitation
===================================================

Created by andre.romcke@ez.no, last modified by ricardo.correia@ez.no on
Jul 25, 2013

A limitation to specify that only users with at least one common
*direct* user group with owner of parent location of content gets a
certain access right, used by ``content/create`` permission.

+-------------------+----------------------------------------------------------------------------------+
| Identifier        | ``ParentGroup``                                                                  |
+-------------------+----------------------------------------------------------------------------------+
| Value Class       | ``eZ\Publish\API\Repository\Values\User\Limitation\ParentUserGroupLimitation``   |
+-------------------+----------------------------------------------------------------------------------+
| Type Class        | ``eZ\Publish\Core\Limitation\ParentUserGroupLimitationType``                     |
+-------------------+----------------------------------------------------------------------------------+
| Criterion used    | n/a                                                                              |
+-------------------+----------------------------------------------------------------------------------+
| Role Limitation   | no                                                                               |
+-------------------+----------------------------------------------------------------------------------+

Possible values
               

Value

UI value

Description

1

"self"

Only user which has at least one common *direct* user group with owner
of parent location gets access

 

| 

Document generated by Confluence on Mar 03, 2015 15:13
