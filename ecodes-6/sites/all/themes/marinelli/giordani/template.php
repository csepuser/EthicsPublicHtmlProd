<?php
/**
 * Adds CSS classes to body TAG.
 */
function add_css_classes() {
  global $user;

  $classnames = "";
  $classname .= $user->uid?"authenticated-user":"anonymous-user";
  
  return $classname;
}

