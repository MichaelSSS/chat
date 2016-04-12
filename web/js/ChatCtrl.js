'use strict';

angular.module('chatApp').
controller('ChatCtrl', ['$scope', '$location', 'User', function($scope, $location, User) {
  if (User.isGuest()) {
    $location.path('/');
    return;
  }
  $scope.messages = [];
  $scope.getMessages = function() {
    var min_id = $scope.messages.length ? $scope.messages[0].id : null;
    User.loadMessages(min_id).then(function(data) {
      $scope.messages = data;
    });    
  }
  $scope.getMessages();
  setInterval($scope.getMessages, 60000);

  $scope.users = [];
  User.getList().then(function(data) {
    $scope.users = data;
  });

  $scope.formData = {};
  $scope.send = function(valid) {
    if (!valid) return;
    User.sendMessage($scope.formData).then(function() {
      $scope.formData.message = '';      
    })
  }
}]);
