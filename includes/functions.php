<?php
// DEBUGGING
function debug($variable) : string {
  echo '<pre>';
  var_dump($variable);
  echo '</pre>';
  exit;
}
// SANITIZE HTML
function s($html) : string {
  $s = htmlspecialchars($html);
  return $s;
}