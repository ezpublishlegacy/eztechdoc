#. `eZ Publish Platform 5.x <index.html>`__
#. `eZ Publish Platform
   Documentation <eZ-Publish-Platform-Documentation_1114149.html>`__
#. `Reference <Reference_10158191.html>`__
#. `FieldTypes reference <FieldTypes-reference_10158198.html>`__

eZ Publish Platform 5.x : The BinaryFile FieldType
==================================================

Created by ricardo.correia@ez.no, last modified by petar.spanja@ez.no on
May 23, 2014

This FieldType represents and handles a binary file. It also counts the
number of times the file has been downloaded from the
``content/download`` module.

Name

Internal name

Expected input

Output

``BinaryFile``

``ezbinaryfile``

``Mixed``

``Mixed``

**Table of contents:**

-  `Description <#TheBinaryFileFieldType-Description>`__
-  `BinaryFile Value Object
   API <#TheBinaryFileFieldType-BinaryFileValueObjectAPI>`__
-  `BinaryFile hash
   format <#TheBinaryFileFieldType-BinaryFilehashformat>`__
-  `REST API specifics <#TheBinaryFileFieldType-RESTAPIspecifics>`__

   -  `Reading content: url
      property <#TheBinaryFileFieldType-Readingcontent:urlproperty>`__
   -  `Creating content: data
      property <#TheBinaryFileFieldType-Creatingcontent:dataproperty>`__

Description
-----------

--------------

This ``FieldType`` allows the storage and retrieval of a single file. It
is capable of handling virtually any file type and is typically used for
storing legacy document types such as PDF files, Word documents,
spreadsheets, etc. The maximum allowed file size is determined by the
"Max file size" class attribute edit parameter and the
"``upload_max_filesize``\ " directive in the main PHP configuration file
("php.ini").

BinaryFile Value Object API
---------------------------

--------------

``eZ\Publish\Core\FieldType\BinaryFile\Value`` offers the following
properties.

Icon

Note that both ``BinaryFile`` and Media Value and Type inherit from the
``BinaryBase`` abstract field type, and share common properties.

Attribute

Type

Description

Example

``id``

string

Binary file identifier. This ID depends on the \ `IO
Handler <Binary-files-clustering_12781005.html>`__ that is being used.
With the native, default handlers (FileSystem and Legacy), the ID is the
file path, relative to the binary file storage root dir
(``var/<vardir>/storage/original`` by default). **This attribute has
been introduced in eZ Publish 5.2.**

application/63cd472dd7819da7b75e8e2fee507c68.pdf

``fileName``

string

The human readable file name, as exposed to the outside. Used when
sending the file for download in order to name the file.

20130116\_whitepaper\_ezpublish5 light.pdf

``fileSize``

int

File size, in bytes

1077923

``mimeType``

string

The file's mime type.

application/pdf

``uri``

string

The binary file's HTTP uri. If the URI doesn't include a host or
protocol, it applies to the request domain. **This attribute has been
introduced in eZ Publish 5.2.**

/var/ezdemo\_site/storage/original/application/63cd472dd7819da7b75e8e2fee507c68.pdf

``downloadCount``

integer

Number of times the file was downloaded

0

``path``

string

**\*deprecated\*
** Renamed to ``id`` starting from eZ Publish 5.2. Can still be used,
but it is recommended not to use it anymore as it will be removed.

 

BinaryFile hash format
----------------------

--------------

The hash format mostly matches the value object. It has the following
keys:

-  ``id``
-  ``path`` (for backwards compatibility)
-  ``fileName``
-  ``fileSize``
-  ``mimeType``
-  ``uri``
-  ``downloadCount``

REST API specifics
------------------

--------------

Used in the REST API, a BinaryFile field will mostly serialize the hash
described above. However there are a couple specifics worth mentioning.

Reading content: url property
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

When reading the contents of a field of this type, an extra key is
added: url. This key gives you the absolute file URL, protocol and host
included.

Example: \ `http://example.com/var/ezdemo\_site/storage/original/application/63cd472dd7819da7b75e8e2fee507c68.pdf <http://example.com/var/ezdemo_site/storage/original/application/63cd472dd7819da7b75e8e2fee507c68.pdf>`__

Creating content: data property
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

When creating BinaryFile content with the REST API, it is possible to
provide data as a base64 encoded string, using the "``data``\ "
fieldValue key:

.. code:: theme:

    <field>
        <fieldDefinitionIdentifier>file</fieldDefinitionIdentifier>
        <languageCode>eng-GB</languageCode>
        <fieldValue>
            <value key="fileName">My file.pdf</value>
            <value key="fileSize">17589</value>
            <value key="data"><![CDATA[/9j/4AAQSkZJRgABAQEAZABkAAD/2wBDAAIBAQIBAQICAgICAgICAwUDAwMDAwYEBAMFBwYHBwcG
    ...
    ...]]></value>
        </fieldValue>
    </field>

Document generated by Confluence on Mar 03, 2015 15:13
