<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');
App::uses('Crypt', 'euonymus');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
  public $components = array('OAuthConsumer', 'OauthLogin', 'Util', 'Session');

  /**
   * Called before the controller action.
   */
  function beforeFilter(){
    parent::beforeFilter();
  }

  function loginCheck() {
    if (!$this->OauthLogin->login) $this->redirect('/login?location=' . Crypt::encrypt($this->genCurrentUrl()));
  }

  function genCurrentUrl() {
    $query = http_build_query($this->request->query);
    if (empty($query)) return $this->request->here;
    else return $this->request->here . '?' . $query;
  }
}
