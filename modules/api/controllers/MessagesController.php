<?php

namespace api\controllers;

use Yii;
use app\models\Message;
use app\models\Channel;
use app\models\User;

/**
 * Messages Controller
 */
class MessagesController extends ApiBaseController {
  /**
   * Gets messages for the authenticated user
   */
  public function actionIndex($min_id = null) {
    $messages = $this->user->getIncomingMessages($min_id);

    $data = [];
    foreach ($messages as $message) {
      $data[] = [
        'id' => $message->id,
        'author' => $message->author->name,
        'date' => $message->getCreatedAt(),
        'message' => $message->body
      ];
    }
    $this->renderJson($data);
  }

  /**
   * Posts message on behalf of the authenticated user
   * Responds with saved message
   */
  public function actionCreate() {
    $params = Yii::$app->getRequest()->getBodyParams();
    $receiver_id = $params['receiver'];    
    $messageBody = $params['message'];
    
    $receiver = User::findOne($receiver_id);
    if (!$receiver) {
      $this->renderJson(['error' => 'Receiver not found']);
    }

    $channel = Channel::getChannel($this->user, $receiver);
    
    $message = new Message;
    $message->body = $messageBody;
    $message->setAuthor($this->user)->addToChannel($channel);

    if ($message->save()) {
      $this->renderJson([ 'status' => 'success', 'message' => $message->toArray() ]);
    } else {
      $this->renderJsonError([ 'error' => $message->getErrors() ]);
    }
  }
}
