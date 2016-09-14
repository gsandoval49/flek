app.constant("FAVORITE_ENDPOINT", "php/apis/favorite/");
app.service("favoriteService", function($http, FAVORITE_ENDPOINT) {

	function getUrl() {
		return(FAVORITE_ENDPOINT);
	}

	function getUrlForFavoriterId(favoriteeId) {
		return(getUrl() + favoriteeId);
	}

	function getUrlForFavoriteeId(favoriterId) {
		return(getUrl() + favoriterId);
	}

	/*I don't think we need this here. We're not calling an array of stuff*/
	/*this.all = function() {
		return($http.get(getUrl()));
	};*/

	this.fetchFavoriteById = function(favoriteeId) {
		return($http.get(getUrl() + "?favoriteeId=" + favoriteeId));
	};

	this.fetchFavoriteById = function(favoriterId) {
		return($http.get(getUrl() + "?favoriterId=" + favoriterId));
	};

	this.fetchAllFavorites = function() {
		return($http.get(getUrl()));
	};

	/*we're attempting to target the destroy between the favoritee and the favoriter*/
	this.create = function(favoriteeId, favoriterId) {
		return($http.post(getUrlforId(favoriteeId, favoriterId)));
	};

	/*we're attempting to target the destroy between the favoritee and the favoriter*/
	this.destroy = function(favoriteeId, favoriterId) {
		return($http.delete(getUrlforId(favoriteeId, favoriterId)));
	};


	/*comment this out*/
	/*this.destroy = function(favoriterId) {
		return($http.delete(getUrlForFavoriterId(favoriterId)));
	};*/
});