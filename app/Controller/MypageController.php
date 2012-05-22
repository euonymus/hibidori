<?php
App::uses('Crypt', 'euonymus');
class MypageController extends AppController {
  public $uses = array('Album');

  function index() {
    if(!$this->OauthLogin->login){
      $this->redirect('/login?location=' . Crypt::encrypt('/album/create'));
    }
    $albums = $this->Album->getAlbumsById($this->OauthLogin->tw_user['id'], $limit = 7);
    $this->set('albums', $albums);
    $this->set('tw_user', $this->OauthLogin->tw_user);
  }
}