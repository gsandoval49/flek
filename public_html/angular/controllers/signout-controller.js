app.controller('signoutController', ["$scope", "signoutService", function($scope,  signoutService) {
	signoutService.signout()
		.then(function() {
			$scope.signoutData = [];
			$scope.alerts = [];
		});
}]);