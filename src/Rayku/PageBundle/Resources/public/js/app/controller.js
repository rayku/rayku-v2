var app = angular.module('raykuApp', ['ngUpload', 'LoadingIndicator']);

//CONTROLLERS
app.controller('TutorListCtrl', function ($scope, $rootScope, $http) {
    var $table = angular.element(document.getElementById('tutorTable'));
    var $trow = $table.find('tr');
    console.log($trow);
    $trow.click(function () {
      console.log('clicked');
      alert('clicked');
      this.find('input[type="checkbox"]').attr("checked", "checked");
    });
});

app.controller('SessionListCtrl',function ($scope, $rootScope, $http) {
    //Sessions List Controller
  	$scope.SessionListTemplate = '/bundles/raykupage/js/app/views/SessionsView.html';
    $scope.master= {};

    function refreshSessions(){
      $http.get(Routing.generate('get_sessions', {'activeRequests':0})).success(function (data){
        $scope.sessions = data;
      }).error(function (data) {
        $scope.error = data || "Request failed";
      });
    };

    //Should be used to update the sessions name
    $scope.update = function (name) {
      //dont know what the url generated for session name update is so just wrote this in here as a placeholder
      $http.post(Routing.generate('set_session_name'), data).success(function(data){
        refreshSessions();
      }).error(function (data) {
        $scope.error = data || "Request failed";
      });
    }
  	
  	$scope.onLoad = function() {
  	    $scope.loaded = true;
  	}

    refreshSessions();
}).controller('UserDetailCtrl', function ($scope, $rootScope, $http){
    //Users Details List Controller
  	$scope.UserDetailTemplate = '/bundles/raykupage/js/app/views/ProfileView.html';
    $scope.UsernameTemplate = '/bundles/raykupage/js/app/views/UsernameView.html';
    $scope.TutorStatusTemplate = '/bundles/raykupage/js/app/views/TutorStatusView.html';

  	$http.get(Routing.generate('get_user', {'entity':userId})).success(function (data){
  		data.password = '';
  		$rootScope.user = data;
  	});
  	
    $scope.update = function(content, completed) {
      	$http.get(Routing.generate('get_user', {'entity':userId})).success(function (data){
      		$rootScope.user = data;
      		$('.myprofile').click();
      	}).error(function (data) {
          $scope.error = data || "Request failed";
        });
    }

    $scope.profile = function(user) {
    	$http.post(Routing.generate('post_users_profile', {'user':userId}), user).success(function(data){
    		$rootScope.user = user;
    	});
    }
});  


app.directive('tutorList', function () {
    var ts = {
      templateUrl: '/bundles/raykupage/js/app/views/TutorListView.html',
      replace: true,
      restrict: 'EACM',
      scope: {}, 
      controller: function ($scope, $rootScope, $http) {
        //Online Tutors List Controller
        $scope.tutorListTemplate = '/bundles/raykupage/js/app/views/TutorListView.html';
        function refreshTutorlist () {
          $http.get(Routing.generate('get_tutors')).success(function (data) {
            $scope.tutors = data;
          });
        }

        $scope.refreshTutors = function(){
            $http.get(Routing.generate('get_tutors')).success(function (data) {
              $scope.tutors = data;
            });
        }
        
        $scope.update = function(user) {
          $http.post(Routing.generate('post_tutors'), user.tutor).success(function (data){
            $rootScope.user = user;
          })
        }

        refreshTutorlist();
      }// end controller-
    } // end ts
  return ts;
});






