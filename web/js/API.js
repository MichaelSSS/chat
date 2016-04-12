'use strict';

angular.module('chatApp')
.factory('API', [ '$http', '$q', function( $http, $q ){
  var
    STATUS_SUCCESS = 'success',
    STATUS_ERROR = 'error',
    API = {};

  API.request = function ( options ){
    var
      defer = $q.defer();
    
    options = angular.extend({
      method : 'GET',
      url    : '/'
    }, options);

    $http( options ).then(
      function ( res ){
        if ( !res.data.error ){
          defer.resolve( res.data );
        } else {
          defer.reject( res.data.error );
        }
      },
      defer.reject
    );
    return defer.promise;
  }

  API.get = function ( url, params ){
    return API.request( {
      method : 'GET',
      url    : url,
      params : params || {}
    } )
  }

  API.post = function ( url, data, options ){
    return API.request( angular.extend( {
      method : 'POST',
      url    : url,
      data   : data || {}
    }, options || {} ) );
  }

  return API;
}])
