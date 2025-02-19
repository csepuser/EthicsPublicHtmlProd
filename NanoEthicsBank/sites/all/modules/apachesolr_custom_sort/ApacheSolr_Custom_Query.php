<?php
// $Id: $

class ApacheSolr_Custom_Query implements Drupal_Solr_Query_Interface {

  /**
   * Extract all uses of one named field from a filter string e.g. 'type:book'
   */
  public function filter_extract(&$filterstring, $name) {
    $extracted = array();
    // Range queries.  The "TO" is case-sensitive.
    $patterns[] = '/(^| |-)'. $name .':([\[\{](\S+) TO (\S+)[\]\}])/';
    // Match quoted values.
    $patterns[] = '/(^| |-)'. $name .':"([^"]*)"/';
    // Match unquoted values.
    $patterns[] = '/(^| |-)'. $name .':([^ ]*)/';
    foreach ($patterns as $p) {
      if (preg_match_all($p, $filterstring, $matches, PREG_SET_ORDER)) {
        foreach($matches as $match) {
          $filter = array();
          $filter['#query'] = $match[0];
          $filter['#exclude'] = ($match[1] == '-');
          $filter['#value'] = trim($match[2]);
          if (isset($match[3])) {
            // Extra data for range queries
            $filter['#start'] = $match[3];
            $filter['#end'] = $match[4];
          }
          $extracted[] = $filter;
          // Update the local copy of $filters by removing the match.
          $filterstring = str_replace($match[0], '', $filterstring);
        }
      }
    }
    return $extracted;
  }

  /**
   * Takes an array $field and combines the #name and #value in a way
   * suitable for use in a Solr query.
   */
  public function make_filter(array $filter) {
    // If the field value has spaces, or : in it, wrap it in double quotes.
    // unless it is a range query.
    if (preg_match('/[ :]/', $filter['#value']) && !isset($filter['#start']) && !preg_match('/[\[\{]\S+ TO \S+[\]\}]/', $filter['#value'])) {
      $filter['#value'] = '"'. $filter['#value']. '"';
    }
    $prefix = empty($filter['#exclude']) ? '' : '-';
    return $prefix . $filter['#name'] . ':' . $filter['#value'];
  }

  /**
   * Static shared by all instances, used to increment ID numbers.
   */
  protected static $idCount = 0;

  /**
   * Each query/subquery will have a unique ID
   */
  public $id;

  /**
   * A keyed array where the key is a position integer and the value
   * is an array with #name and #value properties.  Each value is a
   * used for filter queries, e.g. array('#name' => 'uid', '#value' => 0)
   * for anonymous content.
   */
  protected $fields;

  /**
   * The complete filter string for a query.  Usually from $_GET['filters']
   * Contains name:value pairs for filter queries.  For example,
   * "type:book" for book nodes.
   */
  protected $filterstring;

  /**
   * A mapping of field names from the URL to real index field names.
   */
  protected $field_map = array();

  /**
   * An array of subqueries.
   */
  protected $subqueries = array();

  /**
   * The search keywords.
   */
  protected $keys;

  /**
   * The search base path.
   */
  protected $base_path;

  /**
   * Apache_Solr_Service object
   */
  protected $solr;

  protected $available_sorts;

  // Makes sure we always have a valid sort.
  protected $solrsort = array('#name' => 'score', '#direction' => 'asc');

  /**
   * @param $solr
   *   An instantiated Apache_Solr_Service Object.
   *   Can be instantiated from apachesolr_get_solr().
   *
   * @param $keys
   *   The string that a user would type into the search box. Suitable input
   *   may come from search_get_keys().
   *
   * @param $filterstring
   *   Key and value pairs that are applied as filter queries.
   *
   * @param $sortstring
   *   Visible string telling solr how to sort - added to GET query params.
   *
   * @param $base_path
   *   The search base path (without the keywords) for this query.
   */
  function __construct($solr, $keys, $filterstring, $sortstring, $base_path) {
    $this->solr = $solr;
    $this->keys = trim($keys);
    $this->filterstring = trim($filterstring);
    $this->parse_filters();
    $this->available_sorts = $this->get_available_sorts();// $this->default_sorts();
    $this->sortstring = trim($sortstring);
    $this->parse_sortstring($sortstring);
    $this->base_path = $base_path;
    $this->id = ++self::$idCount;
  }

  function __clone() {
    $this->id = ++self::$idCount;
  }

  public function add_filter($field, $value, $exclude = FALSE, $callbacks = array()) {
    $this->fields[] = array('#exclude' => $exclude, '#name' => $field, '#value' => trim($value), '#callbacks' => $callbacks);
  }

  /**
   * Get all filters, or the subset of filters for one field.
   *
   * @param $name
   *   Optional name of a Solr field.
   */
  public function get_filters($name = NULL) {
    if (empty($name)) {
      return $this->fields;
    }
    reset($this->fields);
    $matches = array();
    foreach ($this->fields as $filter) {
      if ($filter['#name'] == $name) {
        $matches[] = $filter;
      }
    }
    return $matches;
  }

  public function remove_filter($name, $value = NULL) {
    // We can only remove named fields.
    if (empty($name)) {
      return;
    }
    if (!isset($value)) {
      foreach ($this->fields as $pos => $values) {
        if ($values['#name'] == $name) {
          unset($this->fields[$pos]);
        }
      }
    }
    else {
      foreach ($this->fields as $pos => $values) {
        if ($values['#name'] == $name && $values['#value'] == $value) {
          unset($this->fields[$pos]);
        }
      }
    }
  }

  public function has_filter($name, $value) {
    foreach ($this->fields as $pos => $values) {
      if (isset($values['#name']) && isset($values['#value']) && $values['#name'] == $name && $values['#value'] == $value) {
        return TRUE;
      }
    }
    return FALSE;
  }

  /**
   * Handle aliases for field to make nicer URLs
   *
   * @param $field_map
   *   An array keyed with real Solr index field names, with value being the alias.
   */
  function add_field_aliases($field_map) {
    $this->field_map = array_merge($this->field_map, $field_map);
    // We have to re-parse the filters.
    $this->parse_filters();
  }

  function get_field_aliases() {
    return $this->field_map;
  }

  function clear_field_aliases() {
    $this->field_map = array();
    // We have to re-parse the filters.
    $this->parse_filters();
  }

  /**
   * Set keywords in this query.
   *
   * @param $keys
   *   New keywords
   */
  function set_keys($keys) {
    $this->keys = $keys;
  }

  /**
   * Remove keywords in this query.
   */
  function remove_keys() {
    $this->keys = '';
  }


  /**
   * Get this query's keywords.
   */
  function get_keys() {
    return $this->keys;
  }

  /**
   * A subquery is another instance of a Solr_Base_Query that should be joined
   * to the query. The operator determines whether it will be joined with AND or
   * OR.
   *
   * @param $query
   *   An instance of Drupal_Solr_Query_Interface.
   *
   * @param $operator
   *   'AND' or 'OR'
   */
  public function add_subquery(Drupal_Solr_Query_Interface $query, $fq_operator = 'OR', $q_operator = 'AND') {
    $this->subqueries[$query->id] = array('#query' => $query, '#fq_operator' => $fq_operator, '#q_operator' => $q_operator);
  }

  public function remove_subquery(Drupal_Solr_Query_Interface $query) {
    unset($this->subqueries[$query->id]);
  }

  public function remove_subqueries() {
    $this->subqueries = array();
  }

  protected function parse_sortstring() {
    // Substitute any field aliases with real field names.
    $sortstring = strtr($this->sortstring, array_flip($this->field_map));
    // Score is a special case - it's the default sort for Solr.
    if ('' == $sortstring) {
      $this->set_solrsort('score', 'asc');
    }
    else {
      // Validate and set sort parameter
      $fields = implode('|', array_keys($this->available_sorts));
      if (preg_match('/^(?:('. $fields .') (asc|desc),?)+$/', $sortstring, $matches)) {
        // We only use the last match.
        $this->set_solrsort($matches[1], $matches[2]);
      }
    }
  }

  public function set_solrsort($name, $direction) {
    if (isset($this->available_sorts[$name])) {
      $this->solrsort = array('#name' => $name, '#direction' => $direction);
    }
  }

  public function get_solrsort() {
    return $this->solrsort;
  }

  public function get_available_sorts() {
    $sorts = array();
    
    /*
    foreach( $this->available_sorts as $key => $sort ) {
      if( $sort['status'] ) {
        $sorts[$key]['title'] = $sort['title'];
        $sorts[$key]['default'] = $sort['default'];
      }
    }
    */
    
    $default_sorts = $this->default_sorts();
    
    foreach ($default_sorts as $sort_name => $sort) {
     
      // get the settings for this page
      $visibility_type = $sort->visibility['type'];
      $visibility_pages = $sort->visibility['pages'];
      
      if ($visibility_type < 2) {
        $path = drupal_get_path_alias($_GET['q']);
        // Compare with the internal and path alias (if any).
        $page_match = drupal_match_path($path, $visibility_pages);
        if ($path != $_GET['q']) {
          $page_match = $page_match || drupal_match_path($_GET['q'], $visibility_pages);
        }
        // When $block->visibility has a value of 0, the block is displayed on
        // all pages except those listed in $block->pages. When set to 1, it
        // is displayed only on those pages listed in $block->pages.
        $page_match = !($visibility_type xor $page_match);
        
        if ($page_match) {
          
          foreach ($sort->fields as $key => $value) {
            $sorts[$key]['title'] = $value['display_value'];
            $sorts[$key]['default'] = $value['sort'];
          }
        }
      }      
    }
    
    return $sorts;
  }
  public function set_available_sort($name, $sort) {
    // We expect non-aliased sorts to be added.
    $this->available_sorts[$name] = $sort;
    $this->available_sorts[$name]['standard'] = FALSE;
    $this->available_sorts[$name]['status'] = TRUE;
  }

  public function remove_available_sort($name) {
    unset($this->available_sorts[$name]);
    // Re-parse the sortstring.
    $this->parse_sortstring();
  }

  /**
   * Returns a default list of sorts.
   */
  protected function default_sorts() {
   return variable_get('sort_field_settings', array());
  }

  /**
   * Return filters and sort in a form suitable for a query param to url().
   */
   public function get_url_queryvalues() {
    $queryvalues = array();
    if ($fq = $this->rebuild_fq(TRUE)) {
      foreach ($fq as $delta => $values) {
        $queryvalues['filters'] .= ' ' . implode(' ', $values);
      }
    }
    $queryvalues['filters'] = isset($queryvalues['filters']) ? trim($queryvalues['filters']) : '';
    $solrsort = $this->solrsort;
    if ($solrsort && ($solrsort['#name'] != 'score' || $solrsort['#direction'] != 'asc')) {
      if (isset($this->field_map[$solrsort['#name']])) {
        $solrsort['#name'] = $this->field_map[$solrsort['#name']];
      }
      $queryvalues['solrsort'] = $solrsort['#name'] .' '. $solrsort['#direction'];
    }
    return $queryvalues;
  }

  public function get_fq() {
    return $this->rebuild_fq();
  }

  /**
   * A function to get just the keyword components of the query,
   * omitting any field:value portions.
   */
  public function get_query_basic() {
    return $this->rebuild_query();
  }

  /**
   * Return the search path.
   *
   * @param string $new_keywords
   *   Optional. When set, this string overrides the query's current keywords.
   */
  public function get_path($new_keywords = NULL) {
    if (isset($new_keywords)) {
      return $this->base_path . '/' . $new_keywords;
    }
    return $this->base_path . '/' . $this->get_query_basic();
  }

  /**
   * Build additional breadcrumb elements relative to $base.
   */
  public function get_breadcrumb($base = NULL) {
    $progressive_crumb = array();
    if (!isset($base)) {
      $base = $this->get_path();
    }

    $search_keys = $this->get_query_basic();
    if ($search_keys) {
      $breadcrumb[] = l($search_keys, $base);
    }

    foreach ($this->fields as $field) {
      $name = $field['#name'];
      // Look for a field alias.
      if (isset($this->field_map[$name])) {
        $field['#name'] = $this->field_map[$name];
      }
      $progressive_crumb[] = $this->make_filter($field);
      $options = array('query' => 'filters=' . rawurlencode(implode(' ', $progressive_crumb)));
      $breadcrumb_name = "apachesolr_breadcrumb_" . $name;
      // Modules utilize this alter to consolidate several fields into one
      // theme function. This is how CCK breadcrumbs are handled.
      drupal_alter('apachesolr_theme_breadcrumb', $breadcrumb_name);
      if ($themed = theme($breadcrumb_name, $field)) {
        $breadcrumb[] = l($themed, $base, $options);
      }
      else {
        $breadcrumb[] = l($field['#value'], $base, $options);
      }
    }
    // The last breadcrumb is the current page, so it shouldn't be a link.
    $last = count($breadcrumb) - 1;
    $breadcrumb[$last] = strip_tags($breadcrumb[$last]);

    return $breadcrumb;
  }

  /**
   * Parse the filter string in $this->filters into $this->fields.
   *
   * Builds an array of field name/value pairs.
   */
  protected function parse_filters() {
    $this->fields = array();
    $filterstring = $this->filterstring;

    // Gets information about the fields already in solr index.
    $index_fields = $this->solr->getFields();

    foreach ((array) $index_fields as $name => $data) {
      // Look for a field alias.
      $alias = isset($this->field_map[$name]) ? $this->field_map[$name] : $name;
      // Get the values for $name
      $extracted = $this->filter_extract($filterstring, $alias);
      if (count($extracted)) {
        foreach ($extracted as $filter) {
          $pos = strpos($this->filterstring, $filter['#query']);
          // $solr_keys and $solr_crumbs are keyed on $pos so that query order
          // is maintained. This is important for breadcrumbs.
          $filter['#name'] = $name;
          $this->fields[$pos] = $filter;
        }
      }
    }
    // Even though the array has the right keys they are likely in the wrong
    // order. ksort() sorts the array by key while maintaining the key.
    ksort($this->fields);
  }

  /**
   * Builds a set of filter queries from $this->fields and all subqueries.
   *
   * Returns an array of strings that can be combined into
   * a URL query parameter or passed to Solr as fq paramters.
   */
  protected function rebuild_fq($aliases = FALSE) {
    $fq = array();
    $fields = array();
    foreach ($this->fields as $pos => $field) {
      // Look for a field alias.
      if ($aliases && isset($this->field_map[$field['#name']])) {
        $field['#name'] = $this->field_map[$field['#name']];
      }
      $fq[$field['#name']][] = $this->make_filter($field);
    }
    foreach ($this->subqueries as $id => $data) {
      $subfq = $data['#query']->rebuild_fq($aliases);
      if ($subfq) {
        $operator = $data['#fq_operator'];
        $subqueries = array();
        foreach ($subfq as $key => $values) {
          foreach ($values as $value) {
            $subqueries[] = $value;
          }
        }
        $fq['subqueries'][$key] =  " {$data['#q_operataor']} (" . implode(" $operator " , $subqueries) . ")";
      }
    }
    return $fq;
  }

  protected function rebuild_query() {
    $query = $this->keys;
    foreach ($this->subqueries as $id => $data) {
      $operator = $data['#q_operator'];
      $subquery = $data['#query']->get_query_basic();
      if ($subquery) {
        $query .= " {$operator} ({$subquery})";
      }
    }
    return $query;
  }
}
