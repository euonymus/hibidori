<?php
class CameraController extends AppController {
  function index() { $this->redirect('/'); }

  function shoot($id = null) {
    if (is_null($id)) $this->redirect('/');
  }
}