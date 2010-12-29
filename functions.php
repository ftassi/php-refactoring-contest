<?php
/**
 * Funzioni di validazione e di gestione degli errori generiche
 * 
 * Il file è deprecato e non più necessario(viene mantenuto per 
 * retrocompatibilità)
 * 
 * @deprecated 
 */

/**
 * Validate form
 *
 * @param array $mandatary_fields
 * @param array $fields
 * @return array
 */
function validate($mandatary_fields, $fields)
{
  $errors = array();
  
  foreach ($mandatary_fields as $field)
  {
    if($fields[$field] == '')
    {
      $errors[] = 'The ' . $field . ' field is mandatory';
    } 
  }
  
  return $errors;
}

function die_with_error($error_msg, $query)
{
  $message  = 'Invalid query: ' . $error_msg. "\n";
  $message .= 'Whole query: ' . $query;
  die($message);
}