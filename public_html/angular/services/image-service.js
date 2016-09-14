app.constant("IMAGE_ENDPOINT", "php/apis/image");
app.service("ImageService", function($http, IMAGE_ENDPOINT) {

	function getUrl() {
		return(IMAGE_ENDPOINT);
	}

	function getUrlForImageId(imageId) {
		return(getUrl() + imageId);
	}

	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetch = function(imageId) {
		return($http.get(getUrlForImageId(imageId)));
	};

	this.fetchImageByGenreId = function() {
		return($http.get(getUrl() + "?genreId=" + genreId));
	};

	this.fetchAllImages = function() {
		return($http.get(getUrl()));
	};

	this.create = function(image) {
		return($http.post(getUrl(), image));
	};

	this.destroy = function(imageId) {
		return($http.delete(getUrlForImageId(imageId)));
	};
});
