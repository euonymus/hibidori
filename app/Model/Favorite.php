<?php /* -*- coding: utf-8 -*- */
App::uses('Folder', 'Utility');
class Favorite extends AppModel {
  public $actsAs = array('ValidationMethods');

  public $path = '';
  
  public $belongsTo = array('Album' =>
    array(
      'className' => 'Album',
      'foreignKey' => 'album_id'
    )
  );

  function getFavorites($twuser_id, $limit = 16) {
    $options = $this->optActive();
    $options['conditions'][__CLASS__.'.twuser_id'] = $twuser_id;
    $options['order'] = __CLASS__.'.modified desc';
    $options['limit'] = $limit;

    return $this->find('all', $options);
  }

  function addFavorites($id, $twuser_id) {
    // TODO: 実装する
    return true;
  }
  
  function isFavorite($album_id, $twuser_id){
    $options = $this->optActive();
    $options['conditions'][__CLASS__.'.album_id'] = $album_id;
    $options['conditions'][__CLASS__.'.twuser_id'] = $twuser_id;
    return $this->find('first', $options);
  }

  function optActive() {
    $options = array();
    $options['conditions'] = array(__CLASS__.'.status' => 1);
    return $options;
  }
}
