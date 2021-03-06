#. `eZ Publish Platform 5.x <index.html>`__
#. `eZ Publish Platform
   Documentation <eZ-Publish-Platform-Documentation_1114149.html>`__
#. `Developer Cookbook <Developer-Cookbook_11403951.html>`__

eZ Publish Platform 5.x : How to paginate API search results
============================================================

Created by jerome.vieilledent@ez.no, last modified by
sarah.haim-lubczanski@ez.no on Jan 12, 2015

Version compatibility

Icon

This recipe is compatible with \ **eZ Publish 5.2 / 2013.11**

 

-  `Description <#HowtopaginateAPIsearchresults-Description>`__
-  `Usage <#HowtopaginateAPIsearchresults-Usage>`__
-  `Adapters <#HowtopaginateAPIsearchresults-Adapters>`__
-  `Historique <#HowtopaginateAPIsearchresults-Historique>`__

Description
-----------

When listing content (e.g. blog posts), pagination is a very common use
case and is usually painful to implement by hand.

For this purpose eZ Publish 5 recommends the use of `Pagerfanta
library <https://github.com/whiteoctober/Pagerfanta>`__ and `proposes
adapters for
it <https://github.com/ezsystems/ezpublish-kernel/tree/master/eZ/Publish/Core/Pagination/Pagerfanta>`__.

Usage
-----

.. code:: theme:

    <?php
    namespace Acme\TestBundle\Controller;
     
    use eZ\Publish\Core\Pagination\Pagerfanta\ContentSearchAdapter;
    use Pagerfanta\Pagerfanta;
    use eZ\Bundle\EzPublishCoreBundle\Controller;
    use eZ\Publish\API\Repository\Values\Content\Query\Criterion\ContentTypeIdentifier;
    use eZ\Publish\API\Repository\Values\Content\Query;
     
    class DefaultController extends Controller
    {
        public function myContentListAction( $locationId, $viewType, $layout = false, array $params = array() )
        {
            // First build the search query.
            // Let's search for folders, sorted by publication date.
            $query = new Query();
            $query->criterion = new ContentTypeIdentifier( 'folder' );
            $query->sortClauses = array( new SortClause\DatePublished() );
     
            // Initialize the pager.
            // We pass the ContentSearchAdapter to it.
            // ContentSearchAdapter is built with your search query and the SearchService.
            $pager = new Pagerfanta( 
                new ContentSearchAdapter( $query, $this->getRepository()->getSearchService() ) 
            );
            // Let's list 2 folders per page, even if it doesn't really make sense ;-)
            $pager->setMaxPerPage( 2 );
            // Defaults to page 1 or get "page" query parameter
            $pager->setCurrentPage( $this->getRequest()->get( 'page', 1 ) );
     
            return $this->render(
                'AcmeTestBundle::my_template.html.twig',
                array(
                    'totalFolderCount' => $pager->getNbResults(),
                    'pagerFolder' => $pager,
                    'location' => $this->getRepository()->getLocationService()->loadLocation( $locationId ),
                ) + $params
            );
        }
    }

**my\_template.html.twig**

.. code:: theme:

    {% block content %}
        <h1>Listing folder content objects: {{ totalFolderCount }} objects found.</h1>
     
        <div>
            <ul>
            {# Loop over the page results #}
            {% for folder in pagerFolder %}
                <li>{{ ez_content_name( folder ) }}</li>
            {% endfor %}
            </ul>
        </div>
     
        {# Only display pagerfanta navigator if needed. #}
        {% if pagerFolder.haveToPaginate() %}
        <div class="pagerfanta">
            {{ pagerfanta( pagerFolder, 'twitter_bootstrap_translated', {'routeName': location} ) }}
        </div>
        {% endif %}
     
    {% endblock %}

Icon

For more information and examples, have a look at `PagerFanta
documentation <https://github.com/whiteoctober/Pagerfanta/blob/master/README.md>`__.

Adapters
--------

Adapter class name

Description

::

    eZ\Publish\Core\Pagination\Pagerfanta\ContentSearchAdapter

Makes the search against passed Query and returns
`Content <https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Content.php>`__
objects.

::

    eZ\Publish\Core\Pagination\Pagerfanta\ContentSearchHitAdapter

Same as ContentSearchAdapter but returns instead
`SearchHit <https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Search/SearchHit.php>`__
objects.

::

    eZ\Publish\Core\Pagination\Pagerfanta\LocationSearchAdapter

Makes a Location search against passed Query and returns Location
objects.

::

    eZ\Publish\Core\Pagination\Pagerfanta\LocationSearchHitAdapter

Same as LocationSearchAdapter but returns instead
`SearchHit <https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Search/SearchHit.php>`__
objects.

Historique
----------

Versions

Description

`5.4 <https://jira.ez.no/browse/EZP/fixforversion/13180>`__,
`2014.07 <https://jira.ez.no/browse/EZP/fixforversion/13481>`__

Adding LocationSearch Adapter

 

 

Document generated by Confluence on Mar 03, 2015 15:12
