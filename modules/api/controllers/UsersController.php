<?php

namespace api\controllers;

use Yii;
use app\models\User;

/**
 * User Controler
 */
class UsersController extends ApiBaseController 
{
  /**
   * Gets all users except for the authenticated user
   */
  public function actionIndex()
  {
    $users = User::find()
    ->where('id != :user_id')
    ->params([':user_id' => $this->user->id])
    ->all();

    $data = [];
    foreach($users as $user) {
      $data[] = [
        'id' => $user->id,
        'name' => $user->name
      ];
    }

    $this->renderJson($data); 
  }
}
