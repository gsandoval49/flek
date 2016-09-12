/**
 * Profile Controller will use:
 *
 * profile service
 * image service
 * mail service
 * favorite service
 * genre service
 * tag service
 * signout service
 **/

app.controller('ProfileController', ["$routeParams", "$scope", "ProfileService", "ImageService", "MailService", "FavoritieService", "GenreService", "TagService", function($routeParams, $scope, ProfileService, ImageService, MailService, FavoriteService, GenreService, TagService) {

	$scope.profileData = null;
	$scope.alerts = [];
	$scope.imageData = [];
	$scope.mailData = [];
	$scope.favoriteData = [];
	$scope.genreData = [];
	$scope.tagService = [];

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

	$scope.fetchProfileByProfileId() = function() {
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
				}else{
					$scope.alerts[0] = {type:"danger", msg:result.data.message};
				}
		})
		};

	$scope.fetchImageByImageProfileId = function() {
		ImageService.fetchImageByImageProfileId($routeParams.imageProfileId)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.imageData = result.data.data;
					console.log($scope.imageData);
				}else{
					$scope.alerts[0] = {type:"danger", msg:result.data.message};
				}
			})
	};

		/**
		 * Mail Methods
		 **/

		 $scope.fetchMailByMailReceiverId = function() {
			 MailService.fetchMailByMailReceiverId($routeParams.mailReceiverId)
				 .then(function(result) {
					 if(result.data.status === 200) {
					 	$scope.mailData = result.data.data;
						 console.log($scope.mailData);
					 }else{
					 	$scope.alerts[0] = {type:"danger", msg:result.data.message};
					 }
				 })
		 };

	$scope.fetchMailByMailSenderId = function() {
		MailService.fetchMailByMailSenderId($routeParams.mailSenderId)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.mailData = result.data.data;
					console.log($scope.mailData);
				}else{
					$scope.alerts[0] = {type:"danger", msg:result.data.message};
				}
			})
	};

	$scope.fetchAllMails( = function() {
		MailService.fetchAllMails($routeParams.fetchAllMails()) //how do I select all mail?
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.mailData = result.data.data;
					console.log($scope.mailData);
				}else{
					$scope.alerts[0] = {type:"danger", msg:result.data.message};
				}
			})
	};

	/**
	 * Favorite Methods
	 **/

	$scope.fetchFavoriteByFavoriteeId = function() {
		FavoriteService.fetchFavoriteByFavoriteeId($routeParams.favoriteeId)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.favoriteData = result.data.data;
					console.log($scope.favoriteData);
				}else{
					$scope.alerts[0] = {type:"danger", msg:result.data.message};
				}
			})
	};

	$scope.fetchFavoriteByFavoriterId = function() {
		FavoriteService.fetchFavoriteByFavoriterId($routeParams.favoriterId)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.favoriteData = result.data.data;
					console.log($scope.favoriteData);
				}else{
					$scope.alerts[0] = {type:"danger", msg:result.data.message};
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
				}else{
					$scope.alerts[0] = {type:"danger", msg:result.data.message};
				}
			})
	};

	$scope.fetchGenreByGenreName = function() {
		GenreService.fetchGenreByGenreName($routeParams.genreName)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.genreData = result.data.data;
					console.log($scope.genreData);
				}else{
					$scope.alerts[0] = {type:"danger", msg:result.data.message};
				}
			})
	};

	$scope.fetchAllGenres = function() {
		GenreService.fetchAllGenres($routeParams.genreId)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.genreData = result.data.data;
					console.log($scope.genreData);
				}else{
					$scope.alerts[0] = {type:"danger", msg:result.data.message};
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
				}else{
					$scope.alerts[0] = {type:"danger", msg:result.data.message};
				}
			})
	};

	$scope.fetchTagByTagName = function() {
		TagService.fetchTagByTagName($routeParams.tagName)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.tagData = result.data.data;
					console.log($scope.tagData);
				}else{
					$scope.alerts[0] = {type:"danger", msg:result.data.message};
				}
			})
	};

	$scope.fetchAllTags = function() {
		TagService.fetchAllTags($routeParams.tagId)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.tagData = result.data.data;
					console.log($scope.tagData);
				}else{
					$scope.alerts[0] = {type:"danger", msg:result.data.message};
				}
			})
	};

	/**
	 * create, update and delete within profile
	 */

	$scope.profileCreate = function(profile, validated) {
		if(validated === true) {
			ProfileService.create(profile)
				.then(function(results) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					}else{
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	}
}]
