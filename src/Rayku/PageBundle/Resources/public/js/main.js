require.config({
	baseUrl: '/bundles/raykupage/js/app'
});

require(
	[
		'/bundles/raykupage/js/app/controller.js'
	],
	function () {
		angular.bootstrap(document, ['raykuApp']);
	});