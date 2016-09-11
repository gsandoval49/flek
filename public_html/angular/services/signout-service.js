app.constant("SIGNOUT_ENDPOINT", "php/apis/singout/");
app.service("SignoutService", function($http, SIGNOUT_ENDPOINT) {

	this.signout = function() {
		return($http.get(this.SIGNOUT_ENDPOINT));
	};
});