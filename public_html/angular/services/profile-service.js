/**
 * Service for profile API
 **/

app.constant("PROFILE_ENDPOINT", "php/apis/profile/");
app.service("ProfileService", function($http, PROFILE_ENDPOINT) {
	function getUrl() {
		return(PROFILE_ENDPOINT);
	}

	function getUrlForId(profileId) {
		return(getUrl() + profileId);
	}

	this.all = function() {
		return($http.get(getUrl()));
	};
	this.fetch = function(profileId) {
		return(http.get(getUrl()));
	};

	this.updateProfile = function(profileId, profile) {
		return($http.put(getUrlForId(profileId, profile)));
	};
});
