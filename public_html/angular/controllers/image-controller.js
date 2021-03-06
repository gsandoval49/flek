/**
 * image Controller will use:
 *
 * image service
 **/

app.controller('imageController', ["$scope", "imageService","$location", function($scope, imageService, $location) {
	$scope.alerts = [];
	$scope.userData = [];
	$scope.imageData = {}; /*are these suppose to be curly braces?*/
	$scope.imageProfile = null; /*is this needed?*/
	$scope.imageFeed = null; /*is this needed?*/

	/*define add method to upload images*/
	$scope.add = function() {

	}


	$scope.getImageById = function(imageId) {
		imageService.fetchImageByImageId(imageId)
			.then(function(result) {
				if(result.status.data === 200) {
					$scope.imageData = result.data.data;
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};

	$scope.getImageProfileId = function(imageProfileId) {
		imageService.fetchImageProfileId(imageProfileId)
			.then(function(result) {
				if(result.status.data === 200) {
					$scope.imageData = result.data.data;
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};

	$scope.getAllImages = function(allImages) {
		imageService.fetchAllImages(allImages)
			.then(function(result) {
				if(result.status.data === 200) {
					$scope.imagesData = result.data.data;
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};
	/**
	 * we create an image and sends it to the image API
	 *
	 * @param image
	 * @param validated true if Angular validated the form, false if not
	 **/
	$scope.createImage = function(image, validated) {
		if(validated === true) {
			imageService.create(image)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
						$scope.newImage = {imageId: null, imageDescription:"", imageProfileId: null};
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
			imageService.update(image.imageId, image)
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
