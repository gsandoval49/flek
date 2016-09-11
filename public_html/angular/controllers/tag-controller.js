app.controller('TagController', ["$scope", "TagService","$location", function($scope, TagService, $location) {
	$scope.alerts = [];
	$scope.userData = [];
	$scope.tagData = {};
	$scope.tagProfile = null;

	$scope.getTagById = function(tagId) {
		TagService.fetchTagByTagId(TagId)
			.then(function(result) {
				if(result.status.data === 200) {
					$scope.tagData = result.data.data;
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};

	$scope.getTagImageId = function(tagImageId) {
		TagService.fetchTagImageId(tagImageId)
			.then(function(result) {
				if(result.status.data === 200) {
					$scope.tagData = result.data.data;
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};

	$scope.getTagProfileId = function(tagProfileId) {
		TagService.fetchTagProfileId(tagProfileId)
			.then(function(result) {
				if(result.status.data === 200) {
					$scope.tagData = result.data.data;
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};

	$scope.getAllTags = function(allTags) {
		TagService.fetchAllTags(allTags)
			.then(function(result) {
				if(result.status.data === 200) {
					$scope.tagData = result.data.data;
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};
	/**
	 * creates a tag and sends it to the tag API
	 *
	 * @param tag
	 * @param validated true if Angular validated the form, false if not
	 **/
	$scope.createTag = function(tag, validated) {
		if(validated === true) {
			TagService.create(tag)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
						$scope.newTag = {tagId: null, tagText:"", tagProfileId: null};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};

	/**
	 * updates a tag and sends it to the tag API
	 *
	 * @param tag
	 * @param validated true if Angular validated the form, false if not
	 **/
	$scope.updateTag = function(tag, validated) {
		if(validated === true) {
			TagService.update(tag.tagId, tag)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};

}]);