#. `eZ Publish Platform 5.x <index.html>`__
#. `eZ Publish Platform
   Documentation <eZ-Publish-Platform-Documentation_1114149.html>`__
#. `Reference <Reference_10158191.html>`__

eZ Publish Platform 5.x : FieldTypes reference
==============================================

Created by ricardo.correia@ez.no, last modified by andre.romcke@ez.no on
Nov 12, 2014

| This page contains ``FieldTypes`` reference introduced with eZ Publish
5.x.
| ``FiledTypes`` were known as ``DataTypes`` in eZ Publish 4.x, and are
still used in "Dual kernel" eZ Publish 5.x. If you would like more
details please refer to the `4.x
DataTypes <http://doc.ez.no/eZ-Publish/Technical-manual/4.x/Reference/Datatypes>`__
reference documentation page.

Icon

For the general FieldType documentation see `Field Type API and best
practices <Field-Type-API-and-best-practices_2719880.html>`__.

If you are looking for the documentation on how to implement a custom
FieldType, see `eZ Publish 5 Field Type
Tutorial <eZ-Publish-5-Field-Type-Tutorial_19890704.html>`__.

A FieldType is the smallest possible entity of storage. It determines
how a specific type of information should be validated, stored,
retrieved, formatted and so on. eZ Publish comes with a collection of
fundamental datatypes that can be used to build powerful and complex
content structures. In addition, it is possible to extend the system by
creating custom FieldTypes for special needs. Custom FieldTypes have to
be programmed in PHP. However, the built in FieldTypes are usually
sufficient enough for typical scenarios. The following table gives an
overview of the supported FieldTypes that come with eZ Publish.

 

FieldType

Description

Searchable in Legacy Storage engine

``Author``

Field type used to store a list of authors, consisting of author name,
and author email.

No.

``BinaryFile``

Field type used to store a file.

Yes.

``Checkbox``

Field type which stores boolean values.

Yes.

``Country``

This field type stores country names as a string.

Yes.

``DateAndTime``

Field type used to store a full date including time information.

Yes.

``Date``

Field type used to store a date information.

Yes.

``EmailAddress``

This field type is used to validate and store an email address.

Yes.

``Float``

Field type used to validate and store a decimal value.

No.

``Image``

Field type used to validate and store an image.

No.

``Integer``

Field type which validates and stores an integer value.

Yes.

`ISBN <The-ISBN-FieldType_21299977.html>`__

Handles International Standard Book Number (ISBN) in 10-digit or
13-digit format.

Yes.

``Keyword``

Field type used to store keywords.

No.

``MapLocation``

Field type used to store map coordinates.

Yes, with MapLocationDistance criterion.

Matrix

Available via community Bundle:
`https://github.com/ezcommunity/EzMatrixFieldTypeBundle <https://github.com/ezcommunity/EzMatrixFieldTypeBundle>`__

 

``Media``

Validates and stores a media file.

Yes.

``Null``

This field type is used for fallback for missing field types and for
testing purposes.

No.

``Page``

Field type used to manage display zones and blocks in a page (formerly
known as *eZ Flow* datatype).

No.

Price

Available via community Bundle:
`https://github.com/ezcommunity/EzPriceBundle <https://github.com/ezcommunity/EzPriceBundle>`__

 

``Rating``

Field type which stores a rating.

No.

``Relation``

Field type which validates and stores a relation to a content object.

Yes, with both Field and FieldRelation criterions.

``RelationList``

Field type that validates and stores a list of relations to content
objects.

Yes, with FieldRelation criterion.

``Selection``

Field type which validates and stores a single selection or multiple
choices from a list of options.

Yes.

Selection2

Available via community Bundle:
`https://github.com/netgen/NetgenEnhancedSelectionBundle <https://github.com/netgen/NetgenEnhancedSelectionBundle>`__

 

Tags

Available via community Bundle:
`https://github.com/netgen/TagsBundle <https://github.com/netgen/TagsBundle>`__

 

``TextBlock``

Validates and stores a larger block of text.

Yes.

``TextLine``

This field type validates and stores a single line of text.

Yes.

``Time``

Field type used to store a time information.

Yes.

``Url``

Field type used to store an URL / address.

No.

``User``

Field type that validates and stores information about a user.

No.

``XmlText``

Field type that validates and stores multiple lines of formatted text..

Yes.

 

Known missing field types
^^^^^^^^^^^^^^^^^^^^^^^^^

The following FieldTypes are configured
using \ `Null <The-Null-FieldType_12781027.html>`__ FieldType to avoid
exceptions if they exists in your database, but their functionality is
currently not known to be implemented out of the box or by the
community:

`|image0|\ EZP-20112 <https://jira.ez.no/browse/EZP-20112>`__ - Shop
FieldTypes are not supported by Public API Backlog

`|image1|\ EZP-20115 <https://jira.ez.no/browse/EZP-20115>`__ - eZ
Identifier FieldType not supported by Public API Backlog

`|image2|\ EZP-20114 <https://jira.ez.no/browse/EZP-20114>`__ -
Deprecated FieldTypes (ezenum, ezinisetting, ezpackage) not supported by
Public API Backlog

`|image3|\ EZP-20116 <https://jira.ez.no/browse/EZP-20116>`__ - eZ
SubtreeSubscription FieldType not supported by Public API Backlog

`|image4|\ EZP-20117 <https://jira.ez.no/browse/EZP-20117>`__ - eZ
Survey FieldType not supported by Public API Backlog

`|image5|\ EZP-20118 <https://jira.ez.no/browse/EZP-20118>`__ - eZ
Password Expiry FieldType not supported by Public API Backlog

 

 

 

Document generated by Confluence on Mar 03, 2015 15:13

.. |image0| image:: https://jira.ez.no/images/icons/issuetypes/story.png
.. |image1| image:: https://jira.ez.no/images/icons/issuetypes/story.png
.. |image2| image:: https://jira.ez.no/images/icons/issuetypes/story.png
.. |image3| image:: https://jira.ez.no/images/icons/issuetypes/story.png
.. |image4| image:: https://jira.ez.no/images/icons/issuetypes/story.png
.. |image5| image:: https://jira.ez.no/images/icons/issuetypes/story.png
