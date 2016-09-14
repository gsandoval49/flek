app.controller('signinController', ["$scope", "$window","SigninService", function($scope, $window, SigninService) {
	$scope.alerts = [];
	$scope.signinData = {};

	/**
	 * Method that uses the sign up service to activate an account
	 *
	 * @param signinData will contain email and password
	 * @param validated true if form is valid, false if not
	 **/

	$scope.signin = function(signinData, validated) {
		console.log("inside signinController signin");
		console.log(signinData);
		if(validated === true) {
			SigninService.signin(signinData)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
						console.log("good status");
						$window.location.href = "/feed"
					} else {
						console.log("bad status");
						console.log(result.data);
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};
}]);