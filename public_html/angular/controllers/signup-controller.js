app.controller("SignupController", ["$scope", "SignupService", "$location", function($scope, SignupService, $location) {
	$scope.alerts = [];
	$scope.activationData = {};

	/**
	 * Method that uses the sign up service to activate an account
	 *
	 * @param signupData will contain activation token and password
	 *
	 **/

	$scope.sendActivationToken = function(signupData, validated) {
		if(validated === true) {
			SignupService.create(SignupData)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
						console.log("good status");
						location.url("signup/");
					} else {
						console.log(result.data.message);
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};
}]);
