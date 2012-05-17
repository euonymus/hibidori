<?php
App::uses('TwitterWithOauth', 'euonymus');
App::uses('HostStat', 'euonymus');
App::uses('Crypt', 'euonymus');
class OauthController extends AppController {
/* Twinaviuser model is not needed when icon controller is stopped, then remove it */
  var $components = array('OAuthConsumer', 'OauthLogin', 'Util');
  var $consumer = 'Twinavi';
  var $helpers = array('Html', 'Js', 'Cache');

  var $error_messages = array(
    '予期せぬエラーが発生しました。',
    'アクセスは拒否されました。',
    'twinaviからTwitterへのアクセスを拒否しました。',
    'Twitterへのアクセス権の取得に失敗しました。'
  );

  function beforeFilter(){
    parent::beforeFilter();
  }

  function index() {
    $this->autoRender = false;

    // Get RequestToken
    $hostname = $this->_getHostname();
    $requestToken = TwitterWithOauth::getRequestToken('http://'.$hostname.'/oauth/callback/');

    if (array_key_exists('location', $this->params['url'])) {
      $location = Crypt::decrypt($this->params['url']['location']);
    } else {
      $location = '/';
    }

    $this->Util->writeSession('twitter_request_token', $requestToken);
    $this->Util->writeSession('redirect_url', $location);
    $this->redirect('https://api.twitter.com/oauth/authorize?oauth_token=' . $requestToken->key) or $this->redirect(array('action' => 'ng', '3'));
  }

  function callback() {
    $this->autoRender = false;
    // OAuth checks
    if (!empty($this->params['url']['denied'])) $this->redirect(array('action' => 'ng', '2'));

    // Get Session data
    $requestToken = $this->Util->readSession('twitter_request_token');
    $redirect_url = $this->Util->readSession('redirect_url');

    // Get AccessToken
    $accessToken = TwitterWithOauth::getAccessTokenOauth($requestToken);
    if (empty($accessToken)) $this->redirect(array('action' => 'ng', '3'));

    // Check if it's accessible by getting User info
    $tw_user = TwitterWithOauth::verifyCredentials($accessToken);

    // Set Login info in Session & save it to DB
//    $this->OauthLogin->setLoginSession($accessToken, $tw_user);

//    $this->Twuser->saveAndGetId($tw_user, $accessToken);

    // Remove all session info set in _login action
    $this->Session->delete('twitter_request_token');
    $this->Session->delete('redirect_url');

pr($tw_user);
//    $this->redirect($redirect_url);
  }

  function ng($error_id = 0) {
    if( (count($this->error_messages) - $error_id) <= 0 ) $error_id = 0;
    $this->set('error_message', $this->error_messages[$error_id]);
  }

  function signout() {
    $this->OauthLogin->delLoginSession();
    if(array_key_exists('location', $this->params['url'])) $redirect_url = $this->params['url']['location'];
    elseif(isset($_SERVER['HTTP_REFERER'])) $redirect_url = $_SERVER['HTTP_REFERER'];
    else $redirect_url = '/';
    $this->redirect(h($redirect_url));
  }

  function _ng_to_referer($id = null){
    if(array_key_exists('ngto',$this->params['url'])){
/**** tree と topic のみ使用。ログイン画面統一後はこの部分を削除 ****/
      $referer = Crypt::decrypt($this->params['url']['ngto']);
      $referer = trim($referer, '/');
  
      $referer_separation = explode('?',$referer);
      if(count($referer_separation)>=2) $query_method = '?'.$referer_separation[1];
      else $query_method = '';
  
      $referer_method = explode('/',$referer_separation[0]);
  
      // Set redirect domain, because DoCoMo has to be full URL
      $hostname = $this->_getHostname();
  
      if(count($referer_method)>=2) {
        $referer_action = '';
        for($i=0;$i<count($referer_method);$i++){
          $referer_action .= '/'.$referer_method[$i];
        }
      } else $referer_action .= '/'.$referer_method[0].'/index';
      $this->redirect('http://'.$hostname.$referer_action.'/id:'.$id.'/error:1'.$query_method);
/**** tree と topic のみ使用。ログイン画面統一後はこの部分を削除 ****/
    } else {
      if(array_key_exists('location', $this->params['url'])) {
        $location = '?location='.Crypt::encrypt($this->params['url']['location']);
      } else $location = '';
      $this->redirect('/oauth/m_login/id:'.$id.'/error:1'.$location);
    }
  }

  function _getHostname() {
    // Set callback domain
    $hostname = HostStat::getDomain(true);
    if(!$hostname) {
      $this->cakeError(
        "error500",
        array()
      );
    }
    if (!HostStat::isHonban()) {
      $hostname .= ':'.$_SERVER['SERVER_PORT'];
    }

    return $hostname;
  }
}
?>