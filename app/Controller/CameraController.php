<?php
class CameraController extends AppController {
  public $uses = array('Album');

  function index() { $this->redirect('/'); }

  function shoot($id = null) {
    $this->loginCheck();
    if (is_null($id)) $this->redirect('/');

    if ($this->data) {
      $this->Album->id = $id;
      if ($this->Album->save($this->data)) {
        $this->redirect('/album/detail/' . $id);
      }
    }

    $this->set('hideFooter', true);
    $this->set('id', $id);
  }
}