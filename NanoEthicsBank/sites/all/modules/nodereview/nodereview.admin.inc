<?php
// $Id: nodereview.admin.inc,v 1.1.2.1.2.2 2009/05/16 17:19:34 junedkazi Exp $


/**
 * @file
 * Administration page callbacks for the nodereview module.
 *
 */


/**
 * Form builder. Configure nodereview node types.
 *
 * @ingroup forms
 *
 */

function nodereview_configure_axes(&$form_state, $type, $name) {

  drupal_set_title(t('Reviews for %type nodes', array('%type' => check_plain($name))));

  $form['use'] = array(
      '#type' => 'fieldset',
      '#title' => t('reviews'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
  );

  $form['use']['node_type'] = array('#type' => 'hidden', '#value' => $type);
  $form['use']['guide'] = array(
    '#type' => 'textarea',
    '#title' => t('Usage Guide to the User'),
    '#return_value' => 1,
    '#default_value' => variable_get('nodereview_guide_'. $type, ''),
    '#description' => t('Instructions to users for how to use this review.  These will be shown on the "Add Review" page. Note that if you have help text defined on admin/settings/content-types/nodereview, this value will override it.'),
  );

  $form['axes'] = array(
    '#type' => 'fieldset',
    '#title' => t('review axes'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#tree' => TRUE,
  );

  // We'll store field information in its own table
  $result = db_query("SELECT aid, tag, description, weight FROM {nodereview_axes} WHERE node_type='%s' ORDER BY weight", $type);

  $axes = array();

  while ($record = db_fetch_object($result)) {
    $axes[] = _nodereview_configure_axis($record);
  }

  $record = new stdClass();
  $record->aid = 0;
  $record->node_type = $type;

  $axes[] = _nodereview_configure_axis($record);

  $form['axes'] += $axes;

  $form['submit'] = array('#type' => 'submit', '#value' => t('Save'));

  return $form;

}


/**
 * Handle submission of the nodereview node type axes
 * form and saving of the data to the database.
 *
 */

function nodereview_configure_axes_submit($form, $form_state) {
  $form_values = $form_state['values'];
  // Save whether or not we're reviewing this node type
  // variable_set('nodereview_use_' . $form_values['node_type'], $form_values['use']);
  variable_set('nodereview_guide_'. $form_values['node_type'], $form_values['guide']);

  // Regardless, save the user's data, just in case they may want it later
  foreach ($form_values['axes'] as $axis) {
    if ($axis['aid'] && $axis['use']) {
      // Update an existing axis
      $axis['description'] = check_plain($axis['description']);
      db_query("UPDATE {nodereview_axes} SET tag='%s', description='%s', weight=%d WHERE aid=%d", $axis['tag'], $axis['description'], $axis['weight'], $axis['aid']);
    }
    elseif ($axis['aid'] && ! $axis['use']) {
      // Delete an existing axis
      db_query("DELETE FROM {nodereview_axes} WHERE aid=%d", $axis['aid']);
    }
    elseif ($axis['use'] && ! $axis['aid']) {
      // Create a new axis
      $axis['description'] = check_plain($axis['description']);
      db_query("INSERT INTO {nodereview_axes} (node_type, tag, description, weight) VALUES ('%s', '%s', '%s', %d)", $form_values['node_type'], $axis['tag'], $axis['description'], $axis['weight']);
    }
    else {
      // Doesn't exist and don't use, so just ignore
    }
  }
}


/**
 * Form builder. To build additional axes on submit.
 *
 * @ingroup forms
 *
 */
function _nodereview_configure_axis($record) {
  $form['aid'] = array(
    '#type' => 'hidden',
    '#value' => $record->aid,
  );
  $form['use'] = array(
    '#type' => 'checkbox',
    '#title' => t('Use axis'),
    '#return_value' => 1,
    '#default_value' => (boolean)($record->aid),
    '#description' => t(''),
  );
  $form['tag'] = array(
    '#type' => 'textfield',
    '#title' => t('name'),
    '#return_value' => 1,
    '#default_value' => $record->tag,
    '#size' => 30,
  );
  $form['description'] = array(
    '#type' => 'textarea',
    '#title' => t('description'),
    '#return_value' => 1,
    '#default_value' => $record->description,
    '#rows' => 2,
  );
  $form['weight'] = array(
    '#type' => 'weight',
    '#title' => t('weight'),
    '#delta' => 10,
    '#default_value' => $record->weight,
    '#description' => t(''),
  );

  return $form;
}


/**
 * We use this function in place of hook_settings(), because hook_settings()
 * isn't fancy enough to support what we need to do.
 *
 */
function nodereview_configure() {

  $form = array();
  $default = array();
  foreach(node_get_types() as $type => $info) {
    $options[$type] = $info->name;
    if (variable_get('nodereview_use_'. $type, 0)) {
      $default[] = $type;
    }
  }

  $form['nodereview'] = array(
    '#type' => 'fieldset',
    '#title' => t('Review types'),
    '#collapsible' => FALSE,
    '#collapsed' => FALSE,
  );
  $form['nodereview']['types'] = array(
    '#type' => 'checkboxes',
    '#title' => t('Reviewable content types'),
    '#default_value' => $default,
    '#options' => $options,
    '#description' => t('Specify which content types can be reviewed.'),
  );

  if (module_exists('fivestar')) {
    $form['fivestar'] = array(
      '#type' => 'fieldset',
      '#title' => t('Fivestar options'),
      '#collapsible' => FALSE,
      '#collapsed' => FALSE,
      '#tree' => TRUE,
    );
    $form['fivestar']['enable'] = array(
      '#type' => 'checkbox',
      '#title' => t('Use Fivestar for reviews'),
      '#default_value' => variable_get('nodereview_fivestar_enable', 0),
      '#description' => t('Enabling Fivestar for reviews will replace select list options with a JavaScript star display.'),
    );
    $form['fivestar']['stars'] = array(
      '#type' => 'select',
      '#title' => t('Number of stars'),
      '#options' => drupal_map_assoc(range(1, 10)),
      '#default_value' => variable_get('nodereview_fivestar_stars', 5),
    );
  }

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save'),
  );

  return $form;
}


function nodereview_configure_submit($form, $form_state) {
  $form_values = $form_state['values'];
  foreach ($form_values['types'] as $type => $checked) {
    variable_set('nodereview_use_'. $type, (bool)$checked);
  }
  if($form_values['fivestar']) {
    foreach ($form_values['fivestar'] as $option => $value) {
      variable_set('nodereview_fivestar_'. $option, $value);
    }
  }
  cache_clear_all();
  menu_rebuild();

}

