<?php
class CameraController extends AppController {
  function index() { $this->redirect('/'); }

  function shoot($id = null) {
    if (is_null($id)) $this->redirect('/');
    $this->set('hideFooter', true);
    $this->set('id', $id);
  }
}