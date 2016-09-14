app.constant("GENRE_ENDPOINT", "php/apis/genre/");
app.service("GenreService", function($http, GENRE_ENDPOINT) {

	function getUrl() {
		return(GENRE_ENDPOINT);
	}

	function getUrlForGenreId(genreId) {
		return(getUrl() + genreId);
	}

	this.fetchGenreByGenreId = function(genreId) {
		return($http.get(getUrlForGenreId(genreId)));
	};

	this.fetchAllGenres = function() {
		return($http.get(getUrl()));
	};

	this.create = function(genre) {
		return($http.post(getUrl(), genre));
	};

	this.update = function(genreId, genre) {
		return($http.put(getUrlForGenreId(genreId, genre)));
	};

	this.destroy = function(genreId) {
		return($http.delete(getUrlForGenreId(genreId)));
	};
});