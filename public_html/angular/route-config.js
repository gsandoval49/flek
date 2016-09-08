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
			templateUrl : 'angular/pages/about.php'
		})
		// route for home page
		.when('/home', {
			controller  : 'homeController',
			templateUrl : 'angular/pages/home.php'
		})
		// route for profile page
		.when('/profile', {
			controller  : 'profileController',
			templateUrl : 'angular/pages/profile.php'
		})
		// route for the sign-up page
		.when('/signup', {
			controller  : 'signupController',
			templateUrl : 'angular/pages/signup.php'
		})

		// otherwise redirect to home
		.otherwise({
			redirectTo: '/'
		});

	//use the HTML5 History API
	$locationProvider.html5Mode(true);
});