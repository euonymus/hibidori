<?php /* -*- coding: utf-8 -*- */
class Album extends AppModel {
  var $actsAs = array('ValidationMethods');

  var $validate = array(
     'name' => array(
        'empty' => array( 'rule' => 'notEmpty'),
        'length' => array('rule' => array('validateLength', 'name', 0, 255)),
        'valid' => array( 'rule' => array('validatecompliant', 'name')),
        'attack' => array( 'rule' => array('validateAttack', 'name'))
     )
  );

  function saveNewData($data, $twuser_id) {
    $data[__CLASS__]['twuser_id'] = $twuser_id;
    return $this->save($data);
  }
}
