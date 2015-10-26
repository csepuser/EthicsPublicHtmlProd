<?php
  //$Id: nodereview.theme.inc,v 1.1.2.1.2.1 2009/05/16 16:29:51 junedkazi Exp $

  /**
   * @file
   * This is to implement theme functions for nodereview module
   */

/**
 * Implementation of theme_nodereview_configure_axes()
 * We declare this function to theme the axes in table
 * format
 */
function theme_nodereview_configure_axes($form) {

  $rows = array();
  $output = '';
  foreach (element_children($form['axes']) as $key) {
    $row = array();
    // Strip out the labels on each form element, since they're redundant with the header
    $form['axes'][$key]['use']['#title'] = '';
    $form['axes'][$key]['tag']['#title'] = '';
    $form['axes'][$key]['description']['#title'] = '';
    $form['axes'][$key]['weight']['#title'] = '';

    $row[] = drupal_render($form['axes'][$key]['aid']) . drupal_render($form['axes'][$key]['use']);
    $row[] = drupal_render($form['axes'][$key]['tag']);
    $row[] = drupal_render($form['axes'][$key]['description']);
    $row[] = drupal_render($form['axes'][$key]['weight']);
    $rows[] = $row;
  }

  $header = array('use', 'name', 'description', 'weight');

  // This is how we get the table to be "inside" the fieldset
  $form['axes']['#children'] = theme('table', $header, $rows);

  $output .= drupal_render($form);
  return $output;
}

/**
 * Implementation of  theme_nodereview_review_body
 * We declare this function to theme the full node
 * view
 *
 */

function theme_nodereview_review_body($review, $node) {
  //Logger::debug_var('review', $review);

  $output = '';

  $title = $review['tag'];
  if (NODEREVIEW_FIVESTAR_ENABLE) {
    $output = theme('fivestar_static', $review['score'], variable_get('nodereview_fivestar_stars', 5));
  }
  else {
    $title .= ': ' . $review['score']/10 . '/10';
  }
  $output = theme('box', $title, $output . $review['review']);

  return $output;
}


/**
 * Implementation of  theme_nodereview_review_preview
 * We declare this function to theme the node preview
 *
 */

function theme_nodereview_review_preview($review, $node) {
  $output = '';

  $title = $review['tag'];
  if (NODEREVIEW_FIVESTAR_ENABLE) {
    $output = theme('fivestar_static', $review['score']);
  }
  else {
    $title .= ': ' . $review['score']/10 . '/10';
  }
  $output = theme('box', $title, $output . check_markup($review['review'], $node->format));

  return $output;
}


/**
 * Implementation of  theme_nodereview_teaser
 * We declare this function to theme the node teaser
 * view
 *
 */

function theme_nodereview_teaser($node) {
  $output = '';
  static $header;

  // Presumably teaser will be called multiple times on different nodes
  // on the same page, so static cache the static strings
  if (!isset($header)) {
    $header = array(t('axis'), t('score'), t('review'));
  }

  foreach ($node->reviews as $review) {
    $row = array();
    $row[] = $review['tag'];
    if (NODEREVIEW_FIVESTAR_ENABLE) {
      $row[] = theme('fivestar_static', $review['score'], variable_get('nodereview_fivestar_stars', 5));
    }
    else {
      $row[] = $review['score']/10 . '/10';
    }
    $row[] = truncate_utf8($review['review'], 50, TRUE, TRUE);
    $rows[] = $row;
  }

  $output = theme('table', $header, $rows, array('class'=>'review-teaser'));
  return $output;
}
