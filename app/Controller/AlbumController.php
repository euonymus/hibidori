<?php
App::uses('Folder', 'Utility');
class AlbumController extends AppController {
  public $uses = array('Twuser', 'Album');

  function index() { $this->redirect('/'); }

  function create() {
    if ($this->data) {
      $saved = $this->Album->saveNewData($this->data, $this->OauthLogin->tw_user['id']);
      if ($saved) {
        $this->redirect('/camera/shoot/' . $saved['Album']['id']);
      }
    }
  }

  function detail($id = null) {
    if (is_null($id)) $this->redirect('/');
    
    $path = WWW_ROOT . 'img' . DS . 'albums' . DS . $id;
    $folder = new Folder($path, true);

    $files_tmp = $folder->read(true, true);
    $files = array();
    foreach($files_tmp[1] as $key => $file):
      $files[(string)round(100 * ($key / (count($files_tmp[1]) - 1)),1)] = $file;
    endforeach;

    $this->set('files', $files);
    $this->set('id', $id);
  }

  function setting($id = null) {
    if (is_null($id)) $this->redirect('/');
  }
}