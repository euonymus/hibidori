<?php
App::uses('DependentCharacters', 'euonymus');
class ValidationMethodsBehavior extends ModelBehavior {
  
  function setup(&$Model, $settings = array()) {
  }
  
  function validateLength(&$Model, $value, $field, $min, $max) {
    return (mb_strlen($value[$field]) >= $min && mb_strlen($value[$field]) <= $max);
  }

  function validateAttack(&$Model, $value, $field) {
    return !preg_match('/[<>]/', $value[$field]);
  }

  // 機種依存文字を1文字も含まないこと
  function validatecompliant(&$Model, $value, $field){
    $dependent_characters = DependentCharacters::getData();
    return !preg_match('/[' . $dependent_characters . ']+/u', $value[$field]);
  }
}