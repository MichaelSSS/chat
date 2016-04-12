'use strict';

angular.module('chatApp').
controller('IndexCtrl', ['$scope', '$location', 'User', function($scope, $location, User) {
  User.getToken().finally(function() {
    if (User.isGuest()) {
      $location.path('/login');
    } else {
      $location.path('/chat');
    }
  });
}]);
