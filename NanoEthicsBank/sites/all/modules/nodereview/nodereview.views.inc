<?php

//$Id: nodereview.views.inc,v 1.1.2.1.2.1 2009/05/16 16:29:51 junedkazi Exp $

  /**
   * @file
   * This is to implement view functionality
   */

function nodereview_views_data() {
  $data['nodereview']['table']['group']  =t('Node Review');
  $data['nodereview']['table']['join']['node'] = array(
    'left_field' => 'nid',
    'field' => 'nid',
  );

  $data['nodereview']['reviewed_nid'] = array(
    'title' => t('Reviewed Node'),
    'help' => t('The node which is reviewed.'),
    'filter' => array(
      'handler' => 'views_handler_filter_numeric',
      'numeric' => TRUE,
    ),
    'argument' => array(
      'handler' => 'views_handler_argument_numeric',
      'numeric' => TRUE,
    ),

  );
  return $data;
}
