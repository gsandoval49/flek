app.constant("TAG_ENDPOINT", "php/apis/tag");
app.service("TagService", function($http, TAG_ENDPOINT) {
	function getUrl(tagId) {
		return(TAG_ENDPOINT);
	}

	function getUrlForId(tagId) {
		return(getUrl() + tagId);
	}

	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetch = function() {
		return($http.get(getUrlForId(tagId)));
	};

	this.create = function() {
		return($http($http.post(getUrl(), tag)));
	};

	this.update = function() {
		return(http.put(getUrlForId(), tag));
	};

	this.destroy = function() {
		return($http.delete(getUrlForId(tagId)));
	};
});