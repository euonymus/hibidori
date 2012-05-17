<?php
App::uses('Folder', 'Utility');
App::uses('Crypt', 'euonymus');
class WelcomeController extends AppController {
  function index() {
    $path = WWW_ROOT . 'img' . DS . 'albums' . DS . 'sample';
    $folder = new Folder($path, true);

    $files_tmp = $folder->read(true, true);
    $files = array();
    foreach($files_tmp[1] as $key => $file):
      $files[(string)round(100 * ($key / (count($files_tmp[1]) - 1)),1)] = $file;
    endforeach;

    $this->set('location', (Crypt::encrypt('/album/create')));
    $this->set('files', $files);
  }
}