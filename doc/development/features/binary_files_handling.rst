#. `eZ Publish Platform 5.x <index.html>`__
#. `eZ Publish Platform
   Documentation <eZ-Publish-Platform-Documentation_1114149.html>`__
#. `Development & Administration Guides <6291674.html>`__
#. `Features <Features_12781009.html>`__

eZ Publish Platform 5.x : Binary files handling
===============================================

Created and last modified by bertrand.dunogier@ez.no on Oct 30, 2014

The eZ Publish 5 API supports multiple binary file handling mechanisms
by means of an \ ``IOHandler`` interface.

Starting from versions 5.4 / 2014.09, a native IO handler is available.

Icon

The LegacyKernel IO handler, that runs legacy kernel callbacks, is
removed.

Native IO handler 5.4 / 2014.09
===============================

 

The unique ``IOHandler`` interface is removed, replace by two distinct
interfaces:

-  ``eZ\Publish\IO\IOMetadataHandler``: Stores & reads metadata
   (validity, size...)
-  ``eZ\Publish\IO\IOBinarydataHandler``: Stores & reads binarydata
   (actual contents)

The IOService uses both.

` <https://github.com/ezsystems/ezpublish-kernel/blob/native_io_spec/doc/specifications/io/native_io_handlers.md#configuration>`__\ Configuration
-------------------------------------------------------------------------------------------------------------------------------------------------

IO handling can now be configured using semantic configuration.

Which IO handlers (metadata & binarydata) is configurable by siteaccess.
This is the default configuration:

.. code:: theme:

    ezpublish:
        system:
            default:
                io:
                    metadata_handler: default
                    binarydata_handler: default

| 
| ````

metadata and binarydata handlers are configured in the ``ez_io``
extension. This is what the configuration looks like for the default
handlers. It declares a metadata handler and a binarydata handler, both
labelled 'default'. Both handlers are of type 'flysystem', and use the
same flysystem adapter, labelled 'default' as well.

.. code:: theme:

    ez_io:
        metadata_handlers:
            default:
                flysystem:
                    adapter: default
        binarydata_handlers:
            default:
                flysystem:
                    adapter: default

 

The 'default' flysystem adapter's directory is based on your site
settings, and will automatically be set to
``%ezpublish_legacy.root_dir%/$var_dir$/$storage_dir$`` (example:
``/path/to/ezpublish_legacy/var/ezdemo_site/storage``).

` <https://github.com/ezsystems/ezpublish-kernel/blob/native_io_spec/doc/specifications/io/native_io_handlers.md#the-native-flysystem-handler>`__\ The native Flysystem handler.
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

`league/flysystem <https://github.com/ezsystems/ezpublish-kernel/blob/native_io_spec/doc/specifications/io/flysystem.thephpleague.com>`__
(along with
`FlysystemBundle <https://github.com/1up-lab/OneupFlysystemBundle/>`__)
is an abstract file handling library.

It is used as the default way to read & write content binary files in eZ
Publish. It can use the local filesystem (our default configuration),
but is also able to read/write to sftp, zip or cloud filesystems
(dropbox, rackspace, aws-s3).

` <https://github.com/ezsystems/ezpublish-kernel/blob/native_io_spec/doc/specifications/io/native_io_handlers.md#handler-options>`__\ handler options
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

` <https://github.com/ezsystems/ezpublish-kernel/blob/native_io_spec/doc/specifications/io/native_io_handlers.md#adapter>`__\ adapter
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The adapter is the 'driver' used by flysystem to read/write files.
Adapters can be declared using ``oneup_flysystem`` as follows:

.. code:: theme:

    oneup_flysystem:
        adapters:
            default:
                local:
                    directory: "/path/to/directory"

 

How to configure other adapters can be found on the `bundle's online
documentation <https://github.com/1up-lab/OneupFlysystemBundle/blob/master/Resources/doc/index.md#step3-configure-your-filesystems>`__.
Note that we do not use the Filesystems configuration described in this
documentation, only the adapters.

` <https://github.com/ezsystems/ezpublish-kernel/blob/native_io_spec/doc/specifications/io/native_io_handlers.md#upgrading>`__\ Upgrading
-----------------------------------------------------------------------------------------------------------------------------------------

For those using the default ``eZFSFileHandler``, no configuration should
be required, and things should just work like before, but without legacy
kernel callbacks for manipulating images & binary files.

For those using the DFS cluster file handler, a new native handler is
available. See the `DFS
specification <https://github.com/ezsystems/ezpublish-kernel/blob/native_io_spec/doc/specifications/io/doc/specifications/io/legacy_dfs_cluster.md>`__.

 

Document generated by Confluence on Mar 03, 2015 15:12
