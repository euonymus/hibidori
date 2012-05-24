<?php
class FavoriteController extends AppController {
  public $uses = array('Album', 'Favorite');

  function index() {
    $this->loginCheck();
    
    $albums = $this->Favorite->getFavorites($this->OauthLogin->tw_user['id']);

    $this->set('albums', $albums);
  }

  function add($id) {
    if (is_null($id)) $this->redirect('/');
    $this->loginCheck();
    
    //TODO お気に入りに追加
    echo "under construction<br />";
    $albums = $this->Favorite->getFavorites($this->OauthLogin->tw_user['id']);

    $this->set('albums', $albums);
    $this->render('index');
  }

  function del($id) {
    if (is_null($id)) $this->redirect('/');
    $this->loginCheck();
    
    //TODO お気に入りから削除
    echo "under construction<br />";
    $albums = $this->Favorite->getFavorites($this->OauthLogin->tw_user['id']);

    $this->set('albums', $albums);
    $this->render('index');
  }

}