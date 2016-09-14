app.controller('tagController', ["$scope", "tagService","$location", function($scope, tagService, $location) {
	$scope.alerts = [];
	$scope.userData = [];
	$scope.tagData = {};
	$scope.tagProfile = null;

	$scope.getTagById = function(tagId) {
		tagService.fetchTagByTagId(tagId)
			.then(function(result) {
				if(result.status.data === 200) {
					$scope.tagData = result.data.data;
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};

	$scope.getTagImageId = function(tagImageId) {
		tagService.fetchTagImageId(tagImageId)
			.then(function(result) {
				if(result.status.data === 200) {
					$scope.tagData = result.data.data;
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};

	$scope.getTagProfileId = function(tagProfileId) {
		tagService.fetchTagProfileId(tagProfileId)
			.then(function(result) {
				if(result.status.data === 200) {
					$scope.tagData = result.data.data;
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};

	$scope.getAllTags = function(allTags) {
		tagService.fetchAllTags(allTags)
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
	$scope.createtag = function(tag, validated) {
		if(validated === true) {
			tagService.create(tag)
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
			tagService.update(tag.tagId, tag)
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