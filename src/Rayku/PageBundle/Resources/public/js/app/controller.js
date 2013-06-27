var app = angular.module('raykuApp', ['ngUpload', 'LoadingIndicator']);

//CONTROLLERS
app.controller('TutorListCtrl', function ($scope, $rootScope, $http) {
    'use strict';

    //Online Tutors List Controller
    $scope.TutorListTemplate = '/bundles/raykupage/js/app/views/TutorListView.html';
	
    $http.get(Routing.generate('get_tutors')).success(function(data) {
        $scope.tutors = data;
    });

    $scope.refreshTutors = function(){
        $http.get(Routing.generate('get_tutors')).success(function(data) {
        	$scope.tutors = data;
        });
    }

    //Poll Tutors
    /*setInterval(function () {
      console.log('Polling tutors');
      $http.get(Routing.generate('get_tutors')).success(function(data) {
        $scope.tutors = data;
      });
    }, 15000);*/
    
    $scope.update = function(user) {
    	$http.post(Routing.generate('post_tutors'), user.tutor).success(function(data){
    		$rootScope.user = user;
    	})
    }
}).controller('CourseViewCtrl',function ($scope, $http){
	// TBD
}).controller('SessionListCtrl',function ($scope, $rootScope, $http, $templateCache, $timeout) {
    //Sessions List Controller
    $scope.SessionListTemplate = '/bundles/raykupage/js/app/views/SessionsView.html';

    $http.get(Routing.generate('get_sessions', {'activeRequests':0})).success(function (data){
        $scope.sessions = data;
      }).error(function (data) {
        $scope.error = data || "Request failed";
    });

    $scope.refreshSessions = function () {
      $http.get(Routing.generate('get_sessions', {'activeRequests':0})).success(function (data){
        $templateCache.remove('/bundles/raykupage/js/app/views/SessionsView.html');
        $scope.SessionListTemplate = '';
        $scope.sessions = data;
      }).error(function (data) {
        $scope.error = data || "Request failed";
      });
    };

    //Should be used to update the sessions name
    $scope.update = function (session) {
      $http.post(Routing.generate('post_sessions', {'session':session.id, 'name':session.tutor_session_name})).success(function(data){
        //done
        $scope.refreshSessions();
        $timeout(function() {
          $scope.SessionListTemplate = '/bundles/raykupage/js/app/views/SessionsView.html';
        },1000);
      }).error(function (data) {
        $scope.error = data || "Request failed";
      });
    }
    

    $scope.onLoad = function() {
        $scope.loaded = true;
    }
}).controller('UserDetailCtrl', function ($scope, $rootScope, $http){
    //Users Details List Controller
  	$scope.UserDetailTemplate = '/bundles/raykupage/js/app/views/ProfileView.html';
    $scope.UsernameTemplate = '/bundles/raykupage/js/app/views/UsernameView.html';
    $scope.TutorStatusTemplate = '/bundles/raykupage/js/app/views/TutorStatusView.html';

  	$http.get(Routing.generate('get_user', {'entity':userId})).success(function(data){
  		data.password = '';
  		$rootScope.user = data;
  	});
  	
    $scope.update = function(content, completed) {
      	$http.get(Routing.generate('get_user', {'entity':userId})).success(function(data){
      		$rootScope.user = data;
      		$('.myprofile').click();
      	});
    }

    $scope.profile = function(user) {
    	$http.post(Routing.generate('post_users_profile', {'user':userId}), user).success(function(data){
    		$rootScope.user = user;
    	});
    }
});  


//DIRECTIVES
app.directive('save', function (){
  return {
    restrict: 'C',
    replace: false,
    template: '<div><a href=# class="edit_session_name">Edit</a></div>',
    link: function (scope, elem, attrs) {
      alert('Im working');
    }
  }
});
