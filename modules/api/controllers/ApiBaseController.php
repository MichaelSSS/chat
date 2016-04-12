<?php

namespace api\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use app\controllers\BaseController;

/**
 * The base controller for all API controllers
 */
class ApiBaseController extends BaseController
{
    /**
     * @var app\models\User current user instance
     */
    protected $user;

    /**
     * Declares filter that supports the authentication
     * based on the access token passed through a query parameter
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }

    /**
     * Called before each action to set $user property
     */
    public function beforeAction($action) {
      if (!parent::beforeAction($action)) {
          return false;
      }
      $this->user = Yii::$app->user->identity;

      return true;
    }
}
