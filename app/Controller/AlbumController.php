<?php
App::uses('Folder', 'Utility');
class AlbumController extends AppController {
  public $uses = array('Twuser', 'Album');

  function index() { $this->redirect('/'); }

  function create() {
    $this->loginCheck();

    if ($this->data) {
      $saved = $this->Album->saveNewData($this->data, $this->OauthLogin->tw_user['id']);
      if ($saved) {
	//    $folder = new Folder($this->Album->path, true);
    //    $folder->create('100');

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

    if (count($files_tmp[1]) == 1) {
      $files_key = 0;
    } else {

      $files_key = (string)round(100 * ($key / (count($files_tmp[1]) - 1)),1);
    }
    $files[$files_key] = $file;
    endforeach;

    $this->set('files', $files);
    $this->set('id', $id);
  }

  function setting($id = null) {
    if (is_null($id)) $this->redirect('/');
  }
}