function DashboardCtrl($scope, $http, User, Tutors) {
  //get user information
  User.async().then(function (data){
    $scope.dashboard = data;
    if(data.tutor.id !== null){
      $scope.isTutor = data.tutor.id;
      $scope.user = { isTutor: 'isTutor', notTutor: '' };
    }
    else{
      $scope.isTutor = null;
      $scope.user = { isTutor: '', notTutor: 'notTutor' };
    }
  });

  //get current online tutors
  $scope.getOnlineTutors = function () {
    Tutors.async().then(function (data){
      $scope.onlineTutors = data;
    });
  }

  $scope.userSidebar = { name: 'tutor_sidebar', url: 'bundles/raykupage/js/app/partials/tutor_sidebar.html'};
  $scope.userProfile = { name: 'profile_top', url: 'bundles/raykupage/js/app/partials/profile_top.html'};
  $scope.userAsk = { name: 'ask_form', url: 'bundles/raykupage/js/app/partials/ask_form.html'};
  $scope.tutorList = { name: 'tutor_list', url: 'bundles/raykupage/js/app/partials/tutor_list.html'};
  return $scope.dashboard;
}

function navigationCtrl($scope, $http, $location) {
  $scope.logout = function () {
  $http.post('/logout').
    success(function() {
      $location.path('/');
      location.reload(true);//reload the page
    });
  }
}

function getTutorPublicCtrl($scope, $http, $location, $routeParams) {
  $scope.submitPost = function () {
    $http.post('/api/post', $scope.form).
      success(function(data) {
        $location.path('/tutor/');
      });
  };
}

function getTutorCtrl($scope, $http, $routeParams) {
  $http.get('/users/' + $routeParams.id).
    success(function(data) {
      $scope.dashboard = data.dashboard;
    });
}

function getUserCtrl($scope, $http, $routeParams) {
  $http.get('/users/' + $routeParams.id).
    success(function(data) {
      $scope.dashboard = data.dashboard;
    });
}

function EditPostCtrl($scope, $http, $location, $routeParams) {
  $scope.form = {};
  $http.get('/api/post/' + $routeParams.id).
    success(function(data) {
      $scope.form = data.post;
    });

  $scope.editPost = function () {
    $http.put('/api/post/' + $routeParams.id, $scope.form).
      success(function(data) {
        $location.url('/readPost/' + $routeParams.id);
      });
  };
}

function DeletePostCtrl($scope, $http, $location, $routeParams) {
  $http.get('/api/post/' + $routeParams.id).
    success(function(data) {
      $scope.post = data.post;
    });

  $scope.deletePost = function () {
    $http.delete('/api/post/' + $routeParams.id).
      success(function(data) {
        $location.url('/');
      });
  };

  $scope.home = function () {
    $location.url('/');
  };
}