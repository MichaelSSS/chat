<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

/**
 * BaseController is the customized base controller class.
 */
class BaseController extends Controller
{

  const STATUS_SUCCESS = 'success';
  const STATUS_ERROR = 'error';

  /**
   * Sends data to the client side in JSON format
   * @param array $data The data to be sent
   * @param bool $terminate If true terminates the application and sends data to user
   * @param int $options Options to be passed to json_encode
   */
  public function renderJson($data, $terminate = true, $options = 0) {
    $json = json_encode($data, $options);

    echo $json;

    if ($terminate) Yii::$app->end();
  }
}
