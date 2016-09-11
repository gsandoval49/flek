app.constant("TAG_ENDPOINT", "php/apis/tag/");
app.service("TagService", function($http, TAG_ENDPOINT) {

	function getUrl() {
		return(TAG_ENDPOINT);
	}

	function getUrlForTagId(tagId) {
		return(getUrl() + tagId);
	}

	this.fetchTagByTagId = function(tagId) {
		return($http.get(getUrlForTagId(tagId)));
	};

	this.fetchAllTags = function() {
		return($http.get(getUrl()));
	};

	this.create = function(tag) {
		return($http.post(getUrl(), tag));
	};

	this.update = function(tagId, tag) {
		return($http.put(getUrlForTagId(tagId, tag)));
	};

	this.destroy = function(tagId) {
		return($http.delete(getUrlForTagId(tagId)));
	};
});