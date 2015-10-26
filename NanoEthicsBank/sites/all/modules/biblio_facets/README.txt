$Id: README.txt,v 1.5.2.1 2009/12/17 20:59:52 rjerome Exp $

README file for the Biblio Facets Drupal module.


Description
***********

Biblio Facets integrates with Faceted Search to allow users to browse Biblio
types and fields as facets.


Requirements
************

- Drupal 6.x (http://drupal.org/project/drupal).

- Faceted Search (http://drupal.org/project/faceted_search).

- Biblio (http://drupal.org/project/biblio).


Installation
************

1. Extract the 'biblio_facets module directory into your Drupal modules
   directory.

2. Go to the Administer > Site building > Modules page. If you wish to expose
   Biblio types as facets, enable the Biblio Type Facet module. If you wish to
   expose Biblio fields as facets, enable the Biblio Facets modules.

3. Go to the Administer > Site configuration > Faceted Search page, choose to
   edit the faceted search environment that shall expose Biblio facets. In the
   environment editing form, check each facet you wish to expose.

4. If you wish to fully replace Biblio's search and filtering capabilities with
   Biblio Facets, you'll want to override Biblio's theming functions to replace
   the links that are normally provided.


Support
*******

For support requests, bug reports, and feature requests, please use the
project's issue queue on http://drupal.org/project/issues/biblio_facets.

Please DO NOT send bug reports through e-mail or personal contact forms, use the
aforementioned issue queue instead.


Credits
*******
* Ported to 6.x by Ron Jerome

