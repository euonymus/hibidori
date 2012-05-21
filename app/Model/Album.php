<?php /* -*- coding: utf-8 -*- */
App::uses('Folder', 'Utility');
class Album extends AppModel {
  public $actsAs = array('ValidationMethods');

  public $path = '';

  public $validate = array(
     'name' => array(
        'empty' => array( 'rule' => 'notEmpty'),
        'length' => array('rule' => array('validateLength', 'name', 0, 255)),
        'valid' => array( 'rule' => array('validatecompliant', 'name')),
        'attack' => array( 'rule' => array('validateAttack', 'name'))
     )
  );

  function __construct($id = false, $table = null, $ds = null) {
    parent::__construct($id, $table, $ds);
    $this->path = WWW_ROOT . 'img' . DS . 'albums' . DS;
  }

  function bindTwuser($reset = false) {
    $this->bindModel(
      array('belongsTo'
            => array('Twuser'
                     => array('className' => 'Twuser',
                              'foreignKey' => 'twuser_id'))),
      $reset);
  }

  function beforeSave() {
    if(isset($this->data[__CLASS__]['shoot_image']['error']) && ($this->data[__CLASS__]['shoot_image']['error'] == 0) ) {
      $id =  (array_key_exists('id', $this->data[__CLASS__])) ? $this->data[__CLASS__]['id'] : $this->id;
      $files_tmp = $this->getImages($id);
      $file_name = $path . DS . sprintf('%05d', count($files_tmp[1]) + 1) . '.jpg';

      if (!move_uploaded_file($this->data[__CLASS__]['shoot_image']['tmp_name'], $file_name)) {
        return false;
      }
    }
    return true;
  }

  function saveNewData($data, $twuser_id) {
    $data[__CLASS__]['twuser_id'] = $twuser_id;
    return $this->save($data);
  }

  function getWithTwuser($id, $twuser_id = false) {
    $options = $this->optActive();
    $options['conditions'][__CLASS__.'.id'] = $id;
    if($twuser_id){
      $options['conditions'][__CLASS__.'.twuser_id'] = $twuser_id;
    }

    $this->bindTwuser();
    return $this->find('first', $options);
  }

  function getAlbumsById($id, $limit = 16, $isMine = false) {
    $options = $this->optActive();
    $options['conditions']['twuser_id'] = $id;
    $options['order'] = 'modified desc';
    $options['limit'] = $limit;

    return $this->find('all', $options);
  }

  function getNewAlbums($limit = 16) {
    $options = $this->optActive();
    $options['order'] = 'modified desc';
    $options['limit'] = $limit;

    return $this->find('all', $options);
  }

  function getAnimationFiles($id = 'sample') {
    $files_tmp = $this->getImages($id);

    $files = array();
    foreach($files_tmp[1] as $key => $file):
      if (count($files_tmp[1]) == 1) {
        $files_key = 0;
      } else {
        $files_key = (string)round(100 * ($key / (count($files_tmp[1]) - 1)),1);
      }
      $files[$files_key] = $file;
    endforeach;

    return $files;
  }

  function getImages($id = 'sample') {
    $path = $this->path . $id;
    $folder = new Folder($path, true);
    return $folder->read(true, true);
  }

  function optActive() {
    $options = array();
    $options['conditions'] = array(__CLASS__.'.status' => 1);
    return $options;
  }
  
  function saveSettingData($orgAlbum, $data, $twuser_id) {
    //TODO もうちょっと美しく。
    $this->id = $orgAlbum[__CLASS__]['id'];
    $this->name = $orgAlbum[__CLASS__]['name'];
    $this->status = $orgAlbum[__CLASS__]['status'];
    $this->twuser_id = $orgAlbum[__CLASS__]['twuser_id'];
    $this->play_speed = $data[__CLASS__]['play_speed'];
    $this->public = $data[__CLASS__]['public'];
    return $this->save($this);
  }
  
}
