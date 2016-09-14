app.controller('mailController', ["$scope", "profileService", "mailService", function($scope, profileService, mailService) {
	/**
	 * state variable to store the alerts generated from the submit event
	 * @type {Array}
	 **/
	$scope.alerts = [];

	/**
	 * state variable to keep track of the data entered into the form fields
	 *@type {Object}
	 **/
	$scope.formData = {subject: "", message: "", receiver: null, receiverProfileId: null};
	$scope.touched = false;

	$scope.mailbox = [];
	$scope.profiles = [];

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
		message.receiverProfileId = message.receiver.profileId;
		if(validated === true) {
			mailService.create(message)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
						$scope.newMessage = {};
						$scope.addMessageForm.$setPristine();
						$scope.addMessageForm.$setUntouched();
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};

	$scope.fetchMail = function() {
		mailService.fetchMail()
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.mailbox = result.data.data;
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			});
	};

	$scope.getProfile = function(profileId) {
		for(profile in $scope.profiles) {
			if($scope.profiles[profile].profileId === profileId) {
				return($scope.profiles[profile]);
			}
		}
	};

	$scope.getProfiles = function() {
		profileService.all()
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.profiles = result.data.data;
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			});
	};

	if($scope.mailbox.length === 0) {
		$scope.fetchMail();
	}
	if($scope.profiles.length === 0) {
		$scope.getProfiles();
	}

}]);