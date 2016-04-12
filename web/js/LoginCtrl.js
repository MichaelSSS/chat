'use strict';

angular.module('chatApp').
controller('LoginCtrl', ['$scope', '$location', 'User', function($scope, $location, User) {
  $scope.user = {};

  $scope.login = function() {
    User.getToken($scope.user).then(function() {
      if (!User.isGuest()) {
        $location.path('/chat');
      }
    }, function(resp) {
      1;
    });
  }
}]);
