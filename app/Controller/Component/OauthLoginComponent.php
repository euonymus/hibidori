<?php
/**
  * Description: functions to take care of OAuth login
*/
class OauthLoginComponent extends Object {
  const SESSION_LOGIN_TWITTER_ACTOKEN = 'LOGIN.TWITTER.ACCESS.TOKEN';
  const SESSION_LOGIN_TWUSER = 'LOGIN.TWUSER';

  public $login = false;
  public $accessToken = null;
  public $tw_user = null;

  function initialize(&$controller, $settings = array()) {
    // Saving the controller reference for later use
    $this->controller =& $controller;
    $this->checkLogin();
  }

  function startup(&$controller) {
  }

  function shutdown(&$controller) {
  }

  function beforeRedirect(&$controller) {
  }

  function beforeRender(&$controller) {
  }

  /*********************************************************/
  /* Followings are primitive functions                    */
  /*********************************************************/
  function checkLogin() {
    $this->accessToken = $this->controller->Session->read(self::SESSION_LOGIN_TWITTER_ACTOKEN);
    if (!empty($this->accessToken)) {
      $serial_tw_user = $this->controller->Session->read(self::SESSION_LOGIN_TWUSER);
      if(is_string($serial_tw_user)) {
        $this->tw_user = unserialize(base64_decode($serial_tw_user));
      } else {
        $this->tw_user = $serial_tw_user;
      }
      if(!empty($this->tw_user)){
        $this->controller->set('oauth_credential', $this->tw_user);
        $this->login = true;
      }
    }

    return $this->login;
  }

  function setLoginSession($accessToken, $tw_user) {
    $this->controller->Session->renew();
    $this->controller->Session->write(self::SESSION_LOGIN_TWITTER_ACTOKEN, $accessToken);
    $this->controller->Session->write(self::SESSION_LOGIN_TWUSER, base64_encode(serialize($tw_user)));
  }

  function delLoginSession() {
    $this->controller->Session->delete(self::SESSION_LOGIN_TWITTER_ACTOKEN);
    $this->controller->Session->delete(self::SESSION_LOGIN_TWUSER);
    $this->login = $this->checkLogin();
  }
}
