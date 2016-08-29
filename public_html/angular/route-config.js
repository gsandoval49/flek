// configure our routes
app.config(function($routeProvider, $locationProvider) {
    $routeProvider

    // route for the home page
        .when('/', {
            controller  : 'homeController',
            templateUrl : 'angular/pages/home.php'
        })

        // otherwise redirect to home
        .otherwise({
            redirectTo: '/'
        });

    //use the HTML5 History API
    $locationProvider.html5Mode(true);
});