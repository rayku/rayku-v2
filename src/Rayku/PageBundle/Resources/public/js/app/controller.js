//'use strict';

//define([], function () {
    var app = angular.module('raykuApp', ['ngUpload']);

    //SERVICES
    app.service('syncSRV', function ($rootScope) {
      "use strict";

      this.sync = function (data) {
        this.syncData = data;
        $rootScope.$broadcast('updated');
      };
    });

    //CONTROLLERS
    app.controller('TutorListCtrl', function ($scope, $http, $templateCache, $timeout) {
        //Online Tutors List Controller
        $http.get(Routing.generate('get_tutors')).success(function(data) {
            $scope.tutors = data;
        });
          
        $scope.tutorListTemplate = '/bundles/raykupage/js/app/views/TutorListView.html';

        $scope.refreshTutors = function(){
          $templateCache.remove('/bundles/raykupage/js/app/views/TutorListView.html');
          $scope.tutorListTemplate = '';

          $timeout(function() {
            $http.get(Routing.generate('get_tutors')).success(function(data) {
              $scope.tutors = data;
            });
            $scope.tutorListTemplate = '/bundles/raykupage/js/app/views/TutorListView.html';
          });
        }
    }).controller('SessionListCtrl',function ($scope, $http) {
        //Sessions List Controller
      	$http.get(Routing.generate('get_sessions', {'activeRequests':0})).success(function(data){
      		$scope.sessions = data;
      	});

      	$scope.onLoad = function() {
      	    $scope.loaded = true;
      	}
        $scope.SessionListTemplate = '/bundles/raykupage/js/app/views/SessionsView.html';

    }).controller('UserDetailCtrl', function ($scope, $http, $templateCache, $timeout){
        //Users Details List Controller
      	$http.get(Routing.generate('get_user', {'entity':userId})).success(function(data){
      		$scope.user = data;
      	});

      	$scope.UserDetailTemplate = '/bundles/raykupage/js/app/views/ProfileView.html';
        $scope.UsernameTemplate = '/bundles/raykupage/js/app/views/UsernameView.html';

        $scope.callbackFunction = function(contentOfInvisibleFrame) {
            $scope.uploadReport = contentOfInvisibleFrame;
        }
        
        //Update user details on user edit profile submit
      	$scope.update = function(user, completed) {
          $templateCache.remove('/bundles/raykupage/js/app/views/ProfileView.html');
          $templateCache.remove('/bundles/raykupage/js/app/views/UsernameView.html');
          $scope.UserDetailTemplate = '';
          $scope.UsernameTemplate = '';
          
          $http.post(Routing.generate('post_users', {'user':userId}), user).success(function(data){
        	$scope.user = user;
          });

          $timeout(function() {
            $http.get(Routing.generate('get_user', {'entity':userId})).success(function(data){
              $scope.user = data;
            });
            $scope.UserDetailTemplate = '/bundles/raykupage/js/app/views/ProfileView.html';
            $scope.UsernameTemplate = '/bundles/raykupage/js/app/views/UsernameView.html';
          });
      	}

        $scope.profile = function(user) {
          $http.post(Routing.generate('post_users_profile', {'user':userId}), user).success(function(data){
            $scope.user = user;
          });
        }
    });
  
    //DIRECTIVES
    ////Not used at the moment
    app.directive('sync', function (syncSRV) {
        'use strict';

        return {
          template: '',
          controller: function () {
            $scope.$watch('syncdata', function (newVal, oldVal, $scope) {
              syncSRV.sync(newVal);
            }, true);
          }
        };
    }).directive('dataview', function(syncSRV){
        'use strict';

        return {
          template: '',
          controller: function ($scope, $element, $attrs) {
            $scope.$on('updated', function () {
              $scope.data = syncSRV.syncData;
            });
          }
        };
    });
//});