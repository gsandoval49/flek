app.controller("SignupController", ["$scope", "$window", "SignupService", function($scope, $window, SignupService) {
	$scope.signupData = null;
	$scope.alerts = [];
/*
	$scope.activationData = {};
*/

	/**
	 * Method that uses the sign up service to activate an account
	 *
	 * @param signupData will contain activation token and password
	 *
	 **/
	$scope.signupData = {"bid": 1.0, "name": [], "email": null, "city": [], "bio": [], "password": [], "confirmPassword": []};


	$scope.signupData = function(signupData, validated) {
		if(validated === true) {
			SignupService.signup(SignupData)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
						console.log("good status");
						location.url("/signin");
					} else {
						console.log(result.data.message);
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};
}]);
