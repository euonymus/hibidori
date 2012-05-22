<?php
App::uses('Folder', 'Utility');
class AlbumController extends AppController {
  public $uses = array('Album');

  function index() { $this->redirect('/'); }

  function create() {
    $this->loginCheck();

    if ($this->data) {
      $saved = $this->Album->saveNewData($this->data, $this->OauthLogin->tw_user['id']);
      if ($saved) {
        $folder = new Folder($this->Album->path . DS . $saved['Album']['id'], true, 0777);
        $this->redirect('/camera/shoot/' . $saved['Album']['id']);
      }
    }
  }

  function detail($id = null) {
    if (is_null($id)) $this->redirect('/');

    $album = $this->Album->getWithTwuser($id);
    if (empty($album)) $this->redirect('/');

    $files = $this->Album->getAnimationFiles($id);

    $this->set('id', $id);
    $this->set('album', $album);
    $this->set('files', $files);
    $this->set('isPreload', true);
  }

  function select($id = null) {
    $this->loginCheck();
    if (!$this->Album->existsTmp($this->OauthLogin->tw_user['id'])) $this->redirect('/');
    $albums = $this->Album->getAlbumsById($this->OauthLogin->tw_user['id'], $limit = 7);
    if(empty($albums)) $this->redirect('/');

    if (!is_null($id)) {
      $result = $this->Album->registerPhotoToAlbum($this->OauthLogin->tw_user['id'], $id);
      if ($result) {
        $this->redirect('/album/detail/' . $id);
      }
    }

    $this->set('albums', $albums);
  }

  function setting($id = null) {
    if (is_null($id)) $this->redirect('/');
    $this->loginCheck();

    $album = $this->Album->getWithTwuser($id, $this->OauthLogin->tw_user['id']);
    if (empty($album)) $this->redirect('/');

    $updated = false;
    if($this->data){
      if(!$this->Album->saveSettingData($album, $this->data, $this->OauthLogin->tw_user['id'])){
        //TODO failed to save
        
      }else{
        //get renew data
        $album = $this->Album->getWithTwuser($id, $this->OauthLogin->tw_user['id']);
        $updated = true;
      }
    }

    $this->set('id', $id);
    $this->set('album', $album);
    $this->set('updated', $updated);
  }
}