app.constant("SIGNIN_ENDPOINT", "php/apis/signin");
app.service("signinService", function($http, SIGNIN_ENDPOINT) {
	function getUrl() {
		return(SIGNIN_ENDPOINT);
	}
	this.signin = function(signin) {
		console.log("inside signinService signin");
		return($http.post(getUrl(), signin));
	};
});