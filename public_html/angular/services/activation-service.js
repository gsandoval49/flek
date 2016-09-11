app.constant("PROFILEACTIVATION_ENDPOINT", "php/apis/activation/");

/**
 * Initialize the activation service
 */
app.service("ProfileActivationService", function($http, PROFILEACTIVATION_ENDPOINT) {
	function getUrl() {
		return (PROFILEACTIVATION_ENDPOINT);
	}

	function getUrlForId(profileId) {
		return (getUrl() + profileId);
	}

	/**
	 * fetch profile by activation token and profile id
	 */

	this.fetchProfileByProfileActivationToken = function(profileActivationToken) {
		return ($http.get(getUrl() + "?profileActivationToken=" + profileActivationToken));
	};

	this.fetchProfileByProfileId = function(profileId) {
		return ($http.get(getUrl() + "?profileId=" + profileId));
	};


});