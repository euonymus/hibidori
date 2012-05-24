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
  function add($id) {
    $this->autoRender = false;
    $this->layout = NULL;

    if (!$this->request->is('ajax')) {
      $this->cakeError(
        "error500",
        array()
      );
      exit;
    }

    header("Content-Type: application/json; charset=utf-8");
/*
    // Input check
    if (!$this->data) {
      echo json_encode(array('message' => '正しいメールアドレスを入力してください。'));
      return;
    }

    // Input validation
    $this->Mailaddress->set($this->data);
    if(!$this->Mailaddress->validates()) {
      echo json_encode(array('message' => '正しいメールアドレスを入力してください。'));
      return;
    }

    // Mail send
    $sent = $this->_sendRegisterMailToCore($this->data['Mailaddress']['mailBeforeAt'] . '@' . $this->data['Mailaddress']['mobileDomain']);
    if (!$sent) {
      echo json_encode(array('message' => 'メール送信に失敗しました。'));
      return;
    }
*/
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