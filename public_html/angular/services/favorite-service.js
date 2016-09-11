app.constant("FAVORITE_ENDPOINT", "php/apis/favorite/");
app.service("FavoriteService", function($http, FAVORITE_ENDPOINT) {

	function getUrl() {
		return(FAVORITE_ENDPOINT);
	}

	function getUrlForId(favoriteeId) {
		return(getUrl() + favoriteeId);
	}

	function getUrlForId(favoriterId) {
		return(getUrl() + favoriterId);
	}

	/*I don't think we need this here. We're not calling an array of stuff*/
	/*this.all = function() {
		return($http.get(getUrl()));
	};*/

	this.fetchFavoriteByFavoriteeId = function(favoriteeId) {
		return($http.get(getUrl() + "?favoriteeId=" + favoriteeId));
	};

	this.fetchFavoriteByFavoriterId = function(favoriterId) {
		return($http.get(getUrl() + "?favoriterId=" + favoriterId));
	};

	this.fetchAllFavorites = function() {
		return($http.get(getUrl()));
	};

	this.create = function(favorite) {
		return($http.post(getUrl(), favorite));
	};

	/*TODO do we need destroy if we only unpost a favorite and not destroy? for both favoriter and favoritee*/
	this.destroy = function(favoriteeId) {
		return($http.delete(getUrlForFavoriteeId(favoriteeId)));
	};

	this.destroy = function(favoriterId) {
		return($http.delete(getUrlForFavoriterId(favoriterId)));
	};
});