var app = angular.module('raykuApp', ['ngUpload', 'LoadingIndicator']);

app.provider('routeGenerator', function() {
    this.$get = function() {
    	return null;
    };
 
    this.generate = function(name, params) {
        $route = Routing.generate(name, params).split('#');
        return $route[1];
    };
});

app.
	config(['$routeProvider', 'routeGeneratorProvider', function($routeProvider, routeGeneratorProvider){
		$routeProvider.
			when(routeGeneratorProvider.generate('angular_course_view'), {templateUrl: '/bundles/raykupage/partials/course-view.html', controller: 'CourseViewCtrl'}).
			when(routeGeneratorProvider.generate('rayku_username_dashboard', {username:username}), {templateUrl: '/bundles/raykupage/partials/dashboard-view.html'}).
			when(routeGeneratorProvider.generate('angular_profile'), {templateUrl: '/bundles/raykupage/partials/user-edit.html'}).
			when(routeGeneratorProvider.generate('angular_settings'), {templateUrl: '/bundles/raykupage/partials/user-settings.html'}).
			when(routeGeneratorProvider.generate('angular_payout'), {templateUrl: '/bundles/raykupage/partials/payout.html'}).
			otherwise({redirectTo:routeGeneratorProvider.generate('rayku_username_dashboard', {username:username})});
	}]);

app.controller('CourseViewCtrl', function ($scope, $http, $routeParams){
	$http.get(Routing.generate('get_course', {course:$routeParams.name})).success(function(data){
		$scope.course = data;
	})
}).controller('MainCtrl', function ($rootScope){
	$rootScope.path = function(path, args) {
    	return Routing.generate(path, args);
    }
}).controller('TutorListCtrl', function ($scope, $rootScope, $http) {
    //For pagination
    $scope.currentPage = 0;
    $scope.pageSize = 7;

    //Online Tutors List Controller
    $scope.TutorListTemplate = '/bundles/raykupage/js/app/views/TutorListView.html';

    $http.get(Routing.generate('get_tutors')).success(function(data) {
        $scope.tutors = data;
    });

    $scope.numberOfPages=function(){
      return Math.ceil($scope.tutors.length/$scope.pageSize);                
    }

    $scope.prevPage = function () {
        if ($scope.currentPage > 0) {
            $scope.currentPage--;
        }
    };
    
    $scope.nextPage = function () {
      $scope.currentPage++;
    };
    

    $scope.refreshTutors = function(){
        $http.get(Routing.generate('get_tutors')).success(function(data) {
        	$scope.tutors = data;
        });
    }
    
    $scope.update = function(user) {
    	$http.post(Routing.generate('post_tutors'), user.tutor).success(function(data){
    		$rootScope.user = user;
    		$('#myTutorModal').hide();
    		$('.reveal-modal-bg').hide();
    	});

      
    }
}).controller('SessionListCtrl', function ($scope, $rootScope, $http, $templateCache, $timeout) {
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
        $timeout(function() {
          $scope.SessionListTemplate = '/bundles/raykupage/js/app/views/SessionsView.html';
        },1000);
      }).error(function (data) {
        $scope.error = data || "Request failed";
      });
    };

    //Should be used to update the sessions name
    $scope.update = function (session) {
      $http.post(Routing.generate('post_sessions', {'session':session.id, 'name':session.tutor_session_name})).success(function(data){
        //done
        $scope.refreshSessions();
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
    $scope.SidebarDetailTemplate = '/bundles/raykupage/js/app/views/SidebarDetailView.html';

  	$http.get(Routing.generate('get_user', {'entity':userId})).success(function(data){
  		data.password = '';
  		$rootScope.user = data;
  	});

    $scope.refreshUser = function () {
      $http.get(Routing.generate('get_user', {'entity':userId})).success(function(data){
        data.password = '';
        $templateCache.remove('/bundles/raykupage/js/app/views/SidebarDetailView.html');
        $templateCache.remove('/bundles/raykupage/js/app/views/UsernameView.html');
        $scope.SidebarDetailTemplate = '';
        $scope.UsernameTemplate = '';
        $rootScope.user = data;

        $timeout(function () {
          $scope.SidebarDetailTemplate = '/bundles/raykupage/js/app/views/SidebarDetailView.html';
          $scope.UsernameTemplate = '/bundles/raykupage/js/app/views/UsernameView.html';
        }, 1000);
      });
    }
  	
    $scope.update = function(content, completed) {
      	$http.get(Routing.generate('get_user', {'entity':userId})).success(function (data){
      		$rootScope.user = data;
      	});
    }

    $scope.profile = function(user) {
    	$http.post(Routing.generate('post_users_profile', {'user':userId}), user).success(function(data){
    		$rootScope.user = user;
    		username = user.username; // update global username variable
    	});
    }
});  

//We already have a limitTo filter built-in to angular,
//let's make a startFrom filter
app.filter('startFrom', function() {
    return function(input, start) {
        start = +start; //parse to int
        return input.slice(start);
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
