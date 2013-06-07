require.config({
	baseUrl: '/bundles/raykupage/js/app'
});

require(
	[
		'/bundles/raykupage/js/app/app.js',
		'/bundles/raykupage/js/app/routeResolver.js',
		'/bundles/raykupage/js/app/controller.js',
		'/bundles/raykupage/js/app/services.js',
		'/bundles/raykupage/js/app/directives.js',
		'/bundles/raykupage/js/app/filters.js',
	],
	function () {
		angular.bootstrap(document, ['raykuApp']);
	});