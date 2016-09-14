// configure our routes
app.config(function($routeProvider, $locationProvider) {
	$routeProvider

	// route for the home page
		.when('/', {
			controller: 'homeController', //double check cap in route config vs controller
			templateUrl: 'angular/pages/home.php'
		})
		// route for the about page
		.when('/about', {
			controller  : 'aboutController',
			templateUrl : 'angular/pages/about.php'
		})
		// route for feed page
		.when('/feed', {
			controller  : 'feedController',
			templateUrl : 'angular/pages/feed.php'
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
		// route for the sign-in page
		.when('/signin', {
			controller  : 'signinController',
			templateUrl : 'angular/pages/signin.php'
		})

		// otherwise redirect to home
		.otherwise({
			redirectTo: '/'
		});

	//use the HTML5 History API
	$locationProvider.html5Mode(true);
});