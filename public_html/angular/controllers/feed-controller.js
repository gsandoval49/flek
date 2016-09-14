/**
 * Feed Controller will use:
 *
 * profile service
 * image service
 * genre service
 * tag service
 **/

app.controller('FeedController', ["$routeParams", "$scope", "ProfileService", "ImageService", "GenreService", "TagService", function($routeParams, $scope, ProfileService, ImageService, MailService, FavoriteService, GenreService, TagService) {

	$scope.profileData = null;
	$scope.alerts = [];
	$scope.genreData = [];
	$scope.tagService = [];
	$scope.imageData = [];

	function feedRow(arr, size) {
		var imageRow  = [];
		for (var i=0; i<imageRow.length; i+=size) {
			imageRow.push(arr.slice(i, i+size));
		}
		return imageRow;
	}
	$scope.imageDataRow = feedRow(imageData, 2);

	/**
	 * Profile method
	 **/

	$scope.loadProfile = function() {
		ProfileService.fetchProfileByProfileId($routeParams.profileId)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.profileData = result.data.data;
					console.log($scope.profileData);
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};

	$scope.fetchProfileByProfileId = function() {
		ProfileService.fetchProfileByProfileName($routeParams.profileName)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.profileData = result.data.data;
					console.log($scope.profileData);
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};

	/**
	 * Image Method
	 **/

	$scope.fetchImageByImageId = function() {
		ImageService.fetchImageByImageId($routeParams.imageId)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.imageData = result.data.data;
					console.log($scope.imageData);
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};

	$scope.fetchImageByImageProfileId = function() {
		ImageService.fetchImageByImageProfileId($routeParams.imageProfileId)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.imageData = result.data.data;
					console.log($scope.imageData);
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};

	$scope.fetchAllImages = function() {
		ImageService.fetchAllImages($routeParams.imageId)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.imageData = result.data.data;
					console.log($scope.imageData);
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};


	$scope.fetchImageByGenreId = function() {
		ImageService.fetchImageByGenreId($routeParams.imageId)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.imageData = result.data.data;
					console.log($scope.imageData);
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};

	/**
	 * Genre Methods
	 **/

	$scope.fetchGenreByGenreId = function() {
		GenreService.fetchGenreByGenreId($routeParams.genreId)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.genreData = result.data.data;
					console.log($scope.genreData);
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};

	$scope.fetchGenreByGenreName = function() {
		GenreService.fetchGenreByGenreName($routeParams.genreName)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.genreData = result.data.data;
					console.log($scope.genreData);
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};

	$scope.fetchAllGenres = function() {
		GenreService.fetchAllGenres($routeParams.genreId)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.genreData = result.data.data;
					console.log($scope.genreData);
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};

	/**
	 * Tag Methods
	 **/

	$scope.fetchTagByTagId = function() {
		TagService.fetchTagByTagId($routeParams.tagId)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.tagData = result.data.data;
					console.log($scope.tagData);
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};

	$scope.fetchTagByTagName = function() {
		TagService.fetchTagByTagName($routeParams.tagName)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.tagData = result.data.data;
					console.log($scope.tagData);
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};

	$scope.fetchAllTags = function() {
		TagService.fetchAllTags($routeParams.tagId)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.tagData = result.data.data;
					console.log($scope.tagData);
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};

	if($scope.profileData === null){
		$scope.loadProfile();
	}
}]);
