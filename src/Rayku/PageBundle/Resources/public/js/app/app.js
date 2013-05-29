// Declare app level module which depends on filters, and services
angular.module('raykuApp', ['raykuApp.filters', 'raykuApp.services', 'raykuApp.directives']).
  config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
    $routeProvider.
      when('/dashboard', { controller: DashboardCtrl }).
      when('/logout', { controller: navigationCtrl }).
      when('/tutor/:id', {
        templateUrl: 'partials/tutor',
        controller: getTutorCtrl
      }).
      when('/tutor/:username/public', {
        templateUrl: 'partials/tutor',
        controller: getTutorPublicCtrl
      }).
      otherwise({
        redirectTo: '/'
      });
    $locationProvider.html5Mode(true);
  }]);