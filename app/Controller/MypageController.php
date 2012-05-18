<?php
App::uses('Crypt', 'euonymus');
class MypageController extends AppController {
  function index() {
    if(!$this->OauthLogin->login){
      $this->redirect('/login?location=' . Crypt::encrypt('/album/create'));
    }
    $this->set('tw_user', $this->OauthLogin->tw_user);
  }
}