#. `eZ Publish Platform 5.x <index.html>`__
#. `eZ Publish Platform
   Documentation <eZ-Publish-Platform-Documentation_1114149.html>`__
#. `Development & Administration Guides <6291674.html>`__
#. `Features <Features_12781009.html>`__
#. `MVC and Application <MVC-and-Application_2719826.html>`__
#. `Siteaccess <Siteaccess_2719828.html>`__

eZ Publish Platform 5.x : Setting the Index Page
================================================

Created by sarah.haim-lubczanski@ez.no, last modified by
bertrand.dunogier@ez.no on Jul 31, 2014

| The Index Page is the page shown when the root index / is accessed.
| For each siteacces you can configure IndexPage, as in eZ Publish 4.x
Put the parameter ``index_page`` in your ezpublish.yml file, under the
right siteaccess category.

**ezpublish.yml**

.. code:: theme:

    ezpublish:
        system:
            mygreat_site:
                languages:
                    - eng-US
                #The page to show when accessing IndexPage (/)
                index_page: /yourURIPage

Icon

If not specified, the index\_page is the configured content root.

 

 

Document generated by Confluence on Mar 03, 2015 15:12
