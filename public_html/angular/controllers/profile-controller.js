/**
 * Profile Controller will use:
 *
 * profile service
 * image service
 * mail service
 * favorite service
 * genre service
 * tag service
 **/

app.controller('ProfileController', ["$routeParams", "$scope", "ProfileService", "ImageService", "MailService", "FavoritieService", "GenreService", "TagService", function($routeParams, $scope, ProfileService, ImageService, MailService, FavoriteService, GenreService, TagService) {

	$scope.profileData = null;
	$scope.alerts = [];
	$scope.imageData = null;
	$scope.mailData = null;
	$scope.favoriteData = null;
	$scope.genreData = null;
	$scope.tagService = null;

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

	/**
	 * Image upload from profile
	 **/
	$scope.createImage = function(formData, validated) {
		if(validated === true) {
			ImageService.create(formData)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
						var response = result.data.data;
						$scope.newImage = {imageId: null, imageGenreId:"", imageProfileId:"", imageDescription:"", imageSecureUrl: response[secure_url], imagePublicId: response[public_id]};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
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
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};

	$scope.fetchMailByMailSenderId = function() {
		MailService.fetchMailByMailSenderId($routeParams.mailSenderId)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.mailData = result.data.data;
					console.log($scope.mailData);
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};

	$scope.fetchAllMails = function() {
		MailService.fetchAllMails($routeParams.fetchAllMails()) //how do I select all mail?
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.mailData = result.data.data;
					console.log($scope.mailData);
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
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
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};

	$scope.fetchFavoriteByFavoriterId = function() {
		FavoriteService.fetchFavoriteByFavoriterId($routeParams.favoriterId)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.favoriteData = result.data.data;
					console.log($scope.favoriteData);
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

	/**
	 * Create Methods
	 */

	$scope.profileCreate = function(profile, validated) {
		if(validated === true) {
			ProfileService.create(profile)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});

			ImageService.create(image)
				.then(function(result) {
					if(result.data.staus === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});

			MailService.create(mail)
				.then(function(result) {
					if(result.data.staus === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});

			FavoriteService.create(favorite)
				.then(function(result) {
					if(result.data.staus === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});

			TagService.create(tag)
				.then(function(result) {
					if(result.data.staus === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};
	/*I didn't create any genre- not needed (I think)*/


	/**
	 * Update Methods
	 */

	$scope.profileUpdate = function(profile, validated) {
		if(validated === true) {
			ProfileService.update(profile)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});

			ImageService.update(profile)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});

			MailService.update(profile)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});

			FavoriteService.update(profile)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});

			GenreService.update(profile)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});

			TagService.update(profile)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};

			if($scope.profileData === null){
				$scope.loadProfile();
			}
}]);
