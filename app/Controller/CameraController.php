<?php
class CameraController extends AppController {
  public $uses = array('Album');

  function index() { $this->redirect('/'); }

  function shoot($id = null) {
    $this->loginCheck();
//    if (is_null($id)) $this->redirect('/');

    if(!$this->Album->isMine($id, $this->OauthLogin->tw_user['id'], true)) $this->redirect('/');

    if ($this->data) {
      if (is_null($id)) {
        if ($this->Album->saveTmpPic($this->OauthLogin->tw_user['id'], $this->data)) {
          $this->redirect('/album/select');
        }
      } else {
        $this->Album->id = $id;
        if ($this->Album->save($this->data)) {
          $this->redirect('/album/detail/' . $id);
        }
      }
    }

    $this->set('hideFooter', true);
    $this->set('id', $id);
  }
}