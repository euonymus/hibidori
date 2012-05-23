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
    
    //TODO ���C�ɓ���ɒǉ�
    echo "under construction<br />";
    $albums = $this->Favorite->getFavorites($this->OauthLogin->tw_user['id']);

    $this->set('albums', $albums);
    $this->render('index');
  }

  function del($id) {
    if (is_null($id)) $this->redirect('/');
    $this->loginCheck();
    
    //TODO ���C�ɓ��肩��폜
    echo "under construction<br />";
    $albums = $this->Favorite->getFavorites($this->OauthLogin->tw_user['id']);

    $this->set('albums', $albums);
    $this->render('index');
  }

}