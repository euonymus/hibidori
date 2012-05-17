<?php
App::uses('TwitterWithOauth', 'euonymus');
App::uses('HostStat', 'euonymus');
App::uses('Crypt', 'euonymus');
class LoginController extends AppController {
  public $helpers = array('Html', 'Js', 'Cache');

  public $error_messages = array(
    '予期せぬエラーが発生しました。',
    'アクセスは拒否されました。',
    'Twitterへのアクセスを拒否しました。',
    'Twitterへのアクセス権の取得に失敗しました。'
  );

  function beforeFilter(){
    parent::beforeFilter();
  }

  function index() {
    $this->autoRender = false;

    // Get RequestToken
    $hostname = $this->_getHostname();
    $requestToken = TwitterWithOauth::getRequestToken('http://'.$hostname.'/login/callback/');

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
    $this->OauthLogin->setLoginSession($accessToken, $tw_user);

//    $this->Twuser->saveAndGetId($tw_user, $accessToken);

    // Remove all session info set in _login action
    $this->Session->delete('twitter_request_token');
    $this->Session->delete('redirect_url');

pr($tw_user);
    $this->redirect($redirect_url);
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
    if(array_key_exists('location', $this->params['url'])) {
      $location = '?location='.Crypt::encrypt($this->params['url']['location']);
    } else $location = '';
    $this->redirect('/oauth/m_login/id:'.$id.'/error:1'.$location);
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