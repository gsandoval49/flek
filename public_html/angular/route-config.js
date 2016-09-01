// configure our routes
app.config(function($routeProvider, $locationProvider) {
	$routeProvider

	// route for the home page
		.when('/', {
			controller: 'homeController',
			templateUrl: 'angular/pages/home.php'
		})

		/*TODO enter more route configs here as we build views and controllers*/
		// route for the about page
		.when('/about', {
			controller  : 'aboutController',
			templateUrl : 'angular/views/about.php'
		})
		// route for the sign-up page
		.when('/signup', {
			controller  : 'signupController',
			templateUrl : 'angular/views/signup.php'
		})

		// otherwise redirect to home
		.otherwise({
			redirectTo: '/'
		});

	//use the HTML5 History API
	$locationProvider.html5Mode(true);
});