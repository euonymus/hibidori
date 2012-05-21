<?php
class ProfileController extends AppController {
  public $uses = array('Album', 'Twuser');

  function index($screenName = null) {
    if (is_null($screenName)) $this->redirect('/');
    
    //get profile info
    $twuser = $this->Twuser->getByScreenName($screenName);
    if(empty($twuser)){
      //うちにそんな子はいません！
      //エラーページ出すべき？
      $this->redirect('/');
    }
    $this->set('twuser', $twuser);
    
    //get user info
    $albums = $this->Album->getAlbumsById($twuser['Twuser']['id']);
    $this->set('albums', $albums);
  }
}