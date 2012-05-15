<?php
App::uses('Folder', 'Utility');
class ProjectController extends AppController {
  function index() {

  }

  function shoot($id) {
  }

  function listview() {
  }

  function show($id) {
    $path = WWW_ROOT . 'img' . DS . 'projects' . DS . '1';
    $folder = new Folder($path, true);

    $files_tmp = $folder->read(true, true);
    $files = array();
    foreach($files_tmp[1] as $key => $file):
      $files[(string)round(100 * ($key / (count($files_tmp[1]) - 1)),1)] = $file;
    endforeach;

    $this->set('files', $files);
  }
}