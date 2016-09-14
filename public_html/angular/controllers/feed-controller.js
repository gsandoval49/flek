/**
 * Feed Controller will use:
 *
 * profile service
 * image service
 * genre service
 * tag service
 **/

app.controller('feedController', ["$routeParams", "$scope", /*"ProfileService",*/ "ImageService", /*"GenreService",*/ /*"TagService",*/ function($routeParams, $scope, /*ProfileService,*/ ImageService) {

	/*$scope.profileData = null;*/
	$scope.alerts = [];
	/*$scope.genreData = [];*/
	/*$scope.tagService = [];*/
	$scope.imageData = [];

	function feedRow(arr, size) {
		var imageRow  = [];
		for (var i=0; i<imageRow.length; i+=size) {
			imageRow.push(arr.slice(i, i+size));
		}
		return imageRow;
	}
	$scope.imageData = feedRow($scope.imageData, 2);

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

	$scope.fetchAllImages = function() {
		ImageService.fetchAllImages()
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.imageData = result.data.data;
					console.log($scope.imageData);
					console.log("hello");
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

/*
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
*/

	/**
	 * Tag Methods
	 **/

/*	$scope.fetchTagByTagId = function() {
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
	};*/

	if($scope.imageData.length === 0){
		$scope.imageData=$scope.fetchAllImages();
	}
}]);
