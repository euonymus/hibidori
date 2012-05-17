<?php
/**
  * Description: functions to take care of OAuth login
*/
class OauthLoginComponent extends Object {
  var $login = false;
  var $accessToken = null;
  var $tw_user = null;

  function initialize(&$controller, $settings = array()) {
    // Saving the controller reference for later use
    $this->controller =& $controller;
    $this->setLogin();
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
    $this->accessToken = $this->controller->Session->read('twitter_access_token');
    if (!empty($this->accessToken)) {
      $serial_tw_user = $this->controller->Session->read('tw_user');
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

  function setLogin() {
    $this->checkLogin();
  }

  function setLoginSession($accessToken, $tw_user) {
    $this->controller->Session->renew();
    $this->controller->Session->write('twitter_access_token', $accessToken);
    $this->controller->Session->write('tw_user', base64_encode(serialize($tw_user)));
  }

  function delLoginSession() {
    $this->controller->Session->delete('twitter_access_token');
    $this->controller->Session->delete('tw_user');
    $this->login = $this->checkLogin();
  }
}
