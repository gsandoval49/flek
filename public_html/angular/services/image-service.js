app.constant("IMAGE_ENDPOINT", "php/apis/image");
app.service("ImageService", function($http, IMAGE_ENDPOINT) {
	function getUrl(imageId) {
		return(IMAGE_ENDPOINT);
	}

	function getUrlForId(imageId) {
		return(getUrl() + imageId);
	}

	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetch = function() {
		return($http.get(getUrlForId(imageId)));
	};

	this.create = function() {
		return($http($http.post(getUrl(), image)));
	};

	this.destroy = function() {
		return($http.delete(getUrlForId(imageId)));
	};
});
