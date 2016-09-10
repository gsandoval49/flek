app.service("SignoutService", function($http) {
	this.SIGNOUT_ENPOINT = "../../angular/controllers/signout-controller";

	this.signout = function() {
		return($http.get(this.SIGNOUT_ENPOINT));
	}
});