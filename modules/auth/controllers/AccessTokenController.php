<?php

namespace auth\controllers;

use Yii;
use yii\filters\VerbFilter;
use app\controllers\BaseController;
use app\models\User;
use auth\models\AccessToken;

/**
 * Access token controller
 */
class AccessTokenController extends BaseController {
  public function behaviors() {
      return [
          // allow only post requests for receiving token
          'verbs' => [
              'class' => VerbFilter::className(),
              'actions' => [
                  'index' => ['post'],
              ],
          ],
      ];
  }

  /**
   * Action for receiving access_token
   */
  public function actionIndex() {
    $user = $this->getUser();
    if (!$user) {
      $this->renderJson([
        'error' => [ 'user' => 'No user' ],
      ]);
    }

    $token = $user->getOrCreateToken();

    if ($token) {
      $this->renderJson([ 'access_token' => $token->token ]);
    } else {
      $this->renderJson([ 'error' => $token->getErrors() ]);
    }
  }

  /**
   * If there is an authenticated user (from session) returns its instance.
   * Otherwise tries to create new user from post parameters
   * @return User user instance. Null returned if user was not created
   */
  protected function getUser() {
      if (!Yii::$app->user->isGuest) return Yii::$app->user->identity;

      $user = new User;
      $user->name = Yii::$app->request->post('name');

      if ($user->save()) return $user;
      return null;
    }
}
