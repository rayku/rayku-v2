'use strict';

/* Services */


// Demonstrate how to register services
// In this case it is a simple value service.
var app = angular.module('raykuApp',[]);

app.factory('User', function($http){
    	var myUser = {
    		async: function () {
    			var user = $http.get('/users/:id').then(function (response) {
    				console.log(response);
        			// The return value gets picked up by the then in the controller.
        			return response.data;
    			});
    			// Return the promise to the controller
      			return user;
    		}
    	};
    	return myUser;
    });

app.factory('Tutors', function($http){
    	var myTutor = {
    		async: function () {
    			var tutor = $http.get('/tutors').then(function (response) {
    				console.log(response);
        			// The return value gets picked up by the then in the controller.
        			return response.data;
    			});
    			// Return the promise to the controller
      			return tutor;
    		}
    	};
    	return myTutor;
    });
