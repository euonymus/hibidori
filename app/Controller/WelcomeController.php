<?php
App::uses('Folder', 'Utility');
App::uses('Crypt', 'euonymus');
class WelcomeController extends AppController {
  public $uses = array('Album');

  function index() {
    $files = $this->Album->getAnimationFiles();

    $this->set('location', (Crypt::encrypt('/album/create')));
    $this->set('files', $files);
    $this->set('hideFooter', true);
    $this->set('isPreload', true);
  }
}