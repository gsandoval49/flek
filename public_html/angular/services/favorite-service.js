app.constant("FAVORITE_ENDPOINT", "php/apis/favorite");
app.service("FavoriteService", function($http, FAVORITE_ENDPOINT) {
	function getUrl(favoriteId) {
		return(FAVORITE_ENDPOINT);
	}

	function getUrlForId(favoriteId) {
		return(getUrl() + favoriteId);
	}

	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetch = function() {
		return($http.get(getUrlForId(favoriteId)));
	};

	this.create = function() {
		return($http($http.post(getUrl(), favorite)));
	};

	this.destroy = function() {
		return($http.delete(getUrlForId(favoriteId)));
	};
});