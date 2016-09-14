/**
 * image Controller will use:
 *
 * image service
 **/

app.controller('ImageController', ["$scope", "ImageService","$location", function($scope, ImageService, $location) {
	$scope.alerts = [];
	$scope.userData = [];
	$scope.imageData = {}; /*are these suppose to be curly braces?*/
	$scope.imageProfile = null; /*is this needed?*/
	$scope.imageFeed = null; /*is this needed?*/

	$scope.getImageById = function(imageId) {
		ImageService.fetchImageByImageId(ImageId)
			.then(function(result) {
				if(result.status.data === 200) {
					$scope.imageData = result.data.data;
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};

	$scope.getImageProfileId = function(imageProfileId) {
		ImageService.fetchImageProfileId(imageProfileId)
			.then(function(result) {
				if(result.status.data === 200) {
					$scope.imageData = result.data.data;
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};

	$scope.getAllImages = function(allImages) {
		ImagesService.fetchAllImagess(allImages)
			.then(function(result) {
				if(result.status.data === 200) {
					$scope.imagesData = result.data.data;
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};
	/**
	 * creates an image and sends it to the image API
	 *
	 * @param image
	 * @param validated true if Angular validated the form, false if not
	 **/
	$scope.createImage = function(image, validated) {
		if(validated === true) {
			ImageService.create(image)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
						$scope.newImage = {imageId: null, imageText:"", imageProfileId: null};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};

	/**
	 * updates an image and sends it to the image API
	 *
	 * @param image
	 * @param validated true if Angular validated the form, false if not
	 **/
	$scope.updateImage = function(image, validated) {
		if(validated === true) {
			ImageService.update(image.imageId, image)
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
