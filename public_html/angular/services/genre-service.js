app.constant("GENRE_ENDPOINT", "php/apis/genre");
app.service("GenreService", function($http, GENRE_ENDPOINT) {
	function getUrl(genreId) {
		return(GENRE_ENDPOINT);
	}

	function getUrlForId(genreId) {
		return(getUrl() + genreId);
	}

	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetch = function() {
		return($http.get(getUrlForId(genreId)));
	};
});