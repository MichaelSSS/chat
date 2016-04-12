'use strict';

// Declare app level module
angular.module('chatApp', [ 'ngRoute' ]).
config(['$routeProvider', function($routeProvider) {
  $routeProvider
  .when('/', { template:'', controller: 'IndexCtrl' })
  .when('/chat', { templateUrl: 'views/chat.html', controller: 'ChatCtrl' })
  .when('/login', { templateUrl: 'views/login.html', controller: 'LoginCtrl' })
  .otherwise({redirectTo: '/'});
}]);
