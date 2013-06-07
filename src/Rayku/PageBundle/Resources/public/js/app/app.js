// Declare app level module which depends on filters, and services
/*angular.module('raykuApp', ['raykuApp.filters', 'raykuApp.services', 'raykuApp.directives']).
  config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
    $routeProvider.
      when('/dashboard', { controller: DashboardCtrl }).
      when('/logout', { controller: navigationCtrl }).
      otherwise({
        redirectTo: '/'
      });
    $locationProvider.html5Mode(true);
  }]);
  */
 
'use strict';

define(['routeResolver'], function () {

    var app = angular.module('raykuApp', ['routeResolverServices']);

    app.config(['$routeProvider', 'routeResolverProvider', '$controllerProvider', '$compileProvider', '$filterProvider', '$provide',
        function ($routeProvider, routeResolverProvider, $controllerProvider, $compileProvider, $filterProvider, $provide) {

            //Change default views and controllers directory using the following:
            //routeResolverProvider.routeConfig.setBaseDirectories('/app/views', '/app/controllers');

            app.register =
            {
                controller: $controllerProvider.register,
                directive: $compileProvider.directive,
                filter: $filterProvider.register,
                factory: $provide.factory,
                service: $provide.service
            };

            //Define routes - controllers will be loaded dynamically
            var route = routeResolverProvider.route;

           /* $routeProvider
                .when('/dashboard', route.resolve('Dashboard'))
                .when('/customerorders/:customerID', route.resolve('CustomerOrders'))
                .when('/logout', route.resolve('Logout'))
                .otherwise({ redirectTo: '/' });
                */
            }]);
            return app;
});


