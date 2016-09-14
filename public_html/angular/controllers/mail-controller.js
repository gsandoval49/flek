app.controller('mailController', ["$scope", "ProfileService", "MailService", function($scope, ProfileService, MailService) {
	/**
	 * state variable to store the alerts generated from the submit event
	 * @type {Array}
	 **/
	$scope.alerts = [];

	/**
	 * state variable to keep track of the data entered into the form fields
	 *@type {Object}
	 **/
	$scope.formData = {"subject": [], "message": []};
	$scope.touched = false;

	$scope.mailbox = [];
	$scope.mailers = {};

	/**
	 * method to reset form data when the submit and cancel buttons are pressed
	 **/
	$scope.reset = function() {
		$scope.formData = {"subject": "", "message": ""};
		$scope.contact-form.$setUntouched();
		$scope.contact-form.$setPristine();
	};

	/**
	 * creates a message and sends the message to the API
	 *
	 * @param message: the message to send
	 * @param validated true if Angular validated the form, false if not
	 **/
	$scope.createMessage = function(message, validated) {
		if(validated === true) {
			MailService.create(message)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
						$scope.newMessage = {messageId: null, attribution: "", message: "", submitter: ""};
						$scope.addMessageForm.$setPristine();
						$scope.addMessageForm.$setUntouched();
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};

	$scope.fetchMail = function() {
		MailService.fetchMail()
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.mailbox = result.data.data;
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			});
	};

	$scope.getProfile = function(profileId) {
		if($scope.mailers[profileId] !== undefined) {
			return($scope.mailers[profileId]);
		} else {
			ProfileService.fetch(profileId)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.mailers[profileId] = result.data.data;
						return($scope.mailers[profileId]);
					} else {
						return(null);
					}
				});
		}
	};

	if($scope.mailbox.length === 0) {
		$scope.fetchMail();
	}

}]);