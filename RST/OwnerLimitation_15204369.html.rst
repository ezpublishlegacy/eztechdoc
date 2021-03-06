#. `eZ Publish Platform 5.x <index.html>`__
#. `eZ Publish Platform
   Documentation <eZ-Publish-Platform-Documentation_1114149.html>`__
#. `Reference <Reference_10158191.html>`__
#. `Limitations reference <Limitations-reference_15204365.html>`__

eZ Publish Platform 5.x : OwnerLimitation
=========================================

Created by andre.romcke@ez.no, last modified by ricardo.correia@ez.no on
Jul 25, 2013

A limitation to specify that only owner of content gets a certain access
right.

+-------------------+----------------------------------------------------------------------------------------------------+
| Identifier        | ``Owner``                                                                                          |
+-------------------+----------------------------------------------------------------------------------------------------+
| Value Class       | ``eZ\Publish\API\Repository\Values\User\Limitation\OwnerLimitation``                               |
+-------------------+----------------------------------------------------------------------------------------------------+
| Type Class        | ``eZ\Publish\Core\Limitation\OwnerLimitationType``                                                 |
+-------------------+----------------------------------------------------------------------------------------------------+
| Criterion used    | ``eZ\Publish\API\Repository\Values\Content\Query\Criterion\UserMetadata( UserMetadata::OWNER )``   |
+-------------------+----------------------------------------------------------------------------------------------------+
| Role Limitation   | no                                                                                                 |
+-------------------+----------------------------------------------------------------------------------------------------+

Possible values
               

Value

UI value

Description

1

"self"

Only user which is owner gets access (see "*Legacy compatibility notes"*
#2)

2

"session"

Same as "self" (see "*Legacy compatibility notes"* #1)

Legacy compatibility notes:
                           

#. Owner("session") is deprecated and works exactly like "self" in
   Public API since it has no knowledge of user Sessions
#. User is no longer auto assumed to be owner of himself and get access
   to edit him/herself when Owner limitation is used in Public
   API\ **\***

**\*** Workaround for Owner limitation on user object:

| To make sure user gets access to himself when using Owner limitation
across 4.x and 5.x, the solution is to change the user to be owner of
himself.
| This is accomplished using a privileged user to do the following API
calls:

.. code:: theme:

    $user = $userService->loadUser( $userId );
    $contentMetadataUpdateStruct = $contentService->newContentMetadataUpdateStruct();
    $contentMetadataUpdateStruct->ownerId = $user->id;
    $contentService->updateContentMetadata( $user->getVersionInfo()->getContentInfo(), $contentMetadataUpdateStruct );

Document generated by Confluence on Mar 03, 2015 15:13
