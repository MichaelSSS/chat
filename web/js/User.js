'use strict';

angular.module('chatApp')
.factory('User', ['$q', 'API', function($q, API) {
  var User = {};

  User.access_token = null;
  User.messages = [];

  User.isGuest = function() {
    return !Boolean( this.access_token );
  };

  User.getToken = function(data) {
    var defer = $q.defer();
    
    API.post('/auth/access-token', data).then(function(res) {
      User.access_token = res.access_token;
      defer.resolve(res.access_token);
    }, defer.reject);

    return defer.promise;
  };

  User.getList = function() {
    return API.get('/api/users?access-token=' + this.access_token);
  }

  User.sendMessage = function(data) {
    return API.post('api/messages/create?access-token=' + this.access_token, data);
  }

  User.loadMessages = function(min_id) {
    var 
      defer = $q.defer(),
      params = {
        'access-token': this.access_token
      };
    if (min_id) {
      params.min_id = min_id;
    }
  
    API.get('/api/messages', params).then(function(data) {
      var i, len;
      for ( len = data.length, i = len - 1; i >= 0; i-- ) {
        User.messages.unshift(data[i]);
      }
      defer.resolve(User.messages);
    }, defer.reject);
  
    return defer.promise;
  }

  User.getMessages = function(min_id) {
    return this.messages;
  }
  return User;
}]);
