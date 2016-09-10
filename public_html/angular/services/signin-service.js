app.constant("SIGNIN_ENPOINT", "php/apis/signin/");
app.service("SigninService", function($http, SIGNIN_ENPOINT) {
	function getUrl() {
		return(SIGNIN_ENPOINT);
	}
	this.signin = function(signin) {
		console.log("inside signin service");
		return($http.post(getUrl(), signin));
	};
});