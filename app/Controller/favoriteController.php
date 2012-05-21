<?php
class FavoriteController extends AppController {
  public $uses = array('Album', 'Favorite');

  function index() {
    $this->loginCheck();
    
    $albums = $this->Favorite->getFavorites($this->OauthLogin->tw_user['id']);

    $this->set('albums', $albums);
  }
}