<?php
class FavoriteController extends AppController {
  public $uses = array('Album', 'Favorite');
  public $components = array('RequestHandler');

  function index() {
    $this->loginCheck();
    
    $albums = $this->Favorite->getFavorites($this->OauthLogin->tw_user['id']);

    $this->set('albums', $albums);
  }

//  function add($id) {
//    if (is_null($id)) $this->redirect('/');
//    $this->loginCheck();
//    
//    //TODO お気に入りに追加
//    echo "under construction<br />";
//    $albums = $this->Favorite->getFavorites($this->OauthLogin->tw_user['id']);
//
//    $this->set('albums', $albums);
//    $this->render('index');
//  }

  // API from Ajax
  function add() {
    $this->autoRender = false;
    $this->layout = NULL;

    if (!$this->request->is('ajax')) {
// TODO: check how to handle error.
//      $this->cakeError(
//        "error500",
//        array()
//      );
      exit;
    }

    // Input check
    if (!$this->data) exit;

    // Input validation
    if (!array_key_exists('id', $this->data['Favorite'])) exit;
    if (!$this->OauthLogin->login) exit;


    $id = $this->data['Favorite']['id'];

    header("Content-Type: application/json; charset=utf-8");

    $saved = $this->Favorite->addFavorites($id, $this->OauthLogin->tw_user['id']);
    if (!$saved) {
      echo json_encode(array('message' => 'お気に入りへの登録に失敗しました。'));
      return;
    }

    echo json_encode(array('message' => 'お気に入り登録が完了しました。'));
    return;
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