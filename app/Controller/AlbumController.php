<?php
class AlbumController extends AppController {
  public $uses = array('Twuser');

  function index() { $this->redirect('/'); }

  function create() {
  }

  function detail($id = null) {
    if (is_null($id)) $this->redirect('/');
  }

  function setting($id = null) {
    if (is_null($id)) $this->redirect('/');
  }
}