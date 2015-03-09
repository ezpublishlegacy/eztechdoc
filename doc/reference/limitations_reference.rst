#. `eZ Publish Platform 5.x <index.html>`__
#. `eZ Publish Platform
   Documentation <eZ-Publish-Platform-Documentation_1114149.html>`__
#. `Reference <Reference_10158191.html>`__

eZ Publish Platform 5.x : Limitations reference
===============================================

Created and last modified by andre.romcke@ez.no on Jun 30, 2014

Intro
-----

Limitations are the building blocks of the permission system in 5.x,
they provide the limitations you can apply to a given access right to
limit the right to certain conditions.

Limitations consists of two parts:

-  ``Limitation`` (Value)
-  ``LimitationType``

Certain limitations are also "RoleLimitations", meaning they can be used
to limit the rights of a Role assignment, this is currently ``Subtree``
and ``Section`` limitation.

| The ``Limitation`` represent the value, while ``LimitationType`` deals
with the business logic surrounding how it actually works and is
enforced.
| LimitationTypes have two modes of operation in regards to permission
logic (see ``eZ\Publish\SPI\Limitation\Type`` interface for more info):

+--------------------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| Method             | Used when                                                                                                                                                                                       |
+--------------------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| ``evaluate``       | Evaluating if user has access to a given object in a certain context (for instance a context can be Locations when object is ``Content``), under the condition of the ``Limitation`` value(s)   |
+--------------------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+
| ``getCriterion``   | Generates a ``Criterion`` using ``Limitation`` value and current user which ``SearchService`` by default applies to search criteria for filtering search based on permissions                   |
+--------------------+-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------+

List of Limitations
-------------------

Limitation

Description

`BlockingLimitation <BlockingLimitation_23528187.html>`__

Generic limitation that always tells permission system that user have no
access, causing it to continue to next policy.

`ContentTypeLimitation <ContentTypeLimitation_15204457.html>`__

Limits content access depending on it's ContentType.

`LanguageLimitation <LanguageLimitation_15204483.html>`__

Limits content access depending on it's Language.

`LocationLimitation <LocationLimitation_15204475.html>`__

Limits content access depending on it's Location.

`NewObjectStateLimitation <NewObjectStateLimitation_23528113.html>`__

Limits content ObjetSate assignment access depending on new state.

`NewSectionLimitation <NewSectionLimitation_15204429.html>`__

Limits content section assignment access depending on new section.

`ObjectStateLimitation <ObjectStateLimitation_15204488.html>`__

Limits content access depending on it's ObjectStates.

`OwnerLimitation <OwnerLimitation_15204369.html>`__

Limits content access depending on it's owner, as in only access if your
owner of the content.

`ParentContentTypeLimitation <ParentContentTypeLimitation_15204459.html>`__

Limits content (create) access depending on parent location ContentType,
as in only access if parent is in this/these type of content.

`ParentDepthLimitation <ParentDepthLimitation_15204490.html>`__

Limits content (create) access depending on parent location depth, as in
only access if parent is in a given depth of the tree structure.

`ParentOwnerLimitation <ParentOwnerLimitation_15204423.html>`__

Limits content (create) access depending on parent location content
owner, as in only access if your your owner of parent.

`ParentUserGroupLimitation <ParentUserGroupLimitation_15204470.html>`__

Limits content (create) access depending on parent location content
owner user group, as in only access if your your in same user group as
owner of parent.

`SectionLimitation <SectionLimitation_15204431.html>`__

Limits content access depending on it's Section.

`SiteAccessLimitation <SiteAccessLimitation_15204439.html>`__

Limits access to an action depending on siteacces, typically used for
user/login, NOTE: this limitation is planned for 5.3 and it's new login
system

`SubtreeLimitation <SubtreeLimitation_15204479.html>`__

Limits content access depending on it's section.

`UserGroupLimitation <UserGroupLimitation_15204468.html>`__

Limits content access depending on it's owner user group, as in only
access if your your in same user group as owner.

Document generated by Confluence on Mar 03, 2015 15:13
