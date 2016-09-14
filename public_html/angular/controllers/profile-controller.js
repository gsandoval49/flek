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

app.controller('profileController', ["$routeParams", "$scope", "profileService", "imageService", "mailService", "favoriteService", "genreService", "tagService", function($routeParams, $scope, profileService, imageService, mailService, favoriteService, genreService, tagService) {

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
		profileService.fetch($routeParams.profileId)
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
		profileService.fetchProfileByProfileName($routeParams.profileName)
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
		imageService.fetchImageByImageId($routeParams.imageId)
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
		imageService.fetchImageByImageProfileId($routeParams.imageProfileId)
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
			imageService.create(formData)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
						var response = result.data.data;
						console.log("are we running correctly?");
						/*$scope.newImage = {imageId: null, imageGenreId:"", imageProfileId:"", imageDescription:"", imageSecureUrl: response[secure_url], imagePublicId: response[public_id]};*/
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
		mailService.fetchMailByMailReceiverId($routeParams.mailReceiverId)
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
		mailService.fetchMailByMailSenderId($routeParams.mailSenderId)
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
		mailService.fetchAllMails($routeParams.fetchAllMails()) //how do I select all mail?
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
		favoriteService.fetchFavoriteByFavoriteeId($routeParams.favoriteeId)
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
		favoriteService.fetchFavoriteByFavoriterId($routeParams.favoriterId)
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
		genreService.fetchGenreByGenreId($routeParams.genreId)
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
		genreService.fetchGenreByGenreName($routeParams.genreName)
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
		genreService.fetchAllGenres($routeParams.genreId)
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
		tagService.fetchTagByTagId($routeParams.tagId)
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
		tagService.fetchTagByTagName($routeParams.tagName)
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
		tagService.fetchAllTags($routeParams.tagId)
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
			profileService.create(profile)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});

			imageService.create(image)
				.then(function(result) {
					if(result.data.staus === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});

			mailService.create(mail)
				.then(function(result) {
					if(result.data.staus === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});

			favoriteService.create(favorite)
				.then(function(result) {
					if(result.data.staus === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});

			tagService.create(tag)
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
			profileService.update(profile)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});

			imageService.update(profile)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});

			mailService.update(profile)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});

			favoriteService.update(profile)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});

			genreService.update(profile)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});

			tagService.update(profile)
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
