app.controller('FavoriteController', ["$scope", "FavoriteService","$location", function($scope, FavoriteService, $location) {
	$scope.alerts = [];
	$scope.userData = [];
	$scope.FavoriteData = {};
	$scope.favoriteProfile = null;

	$scope.getFavoriteById = function(favoriteId) {
		FavoriteService.fetchFavoriteByFavoriteId(FavoriteId)
			.then(function(result) {
				if(result.status.data === 200) {
					$scope.favoriteData = result.data.data;
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};

	$scope.getFavoriteImageId = function(favoriteImageId) {
		FavoriteService.fetchFavoriteProfileId(favoriteProfileId)
			.then(function(result) {
				if(result.status.data === 200) {
					$scope.favoriteData = result.data.data;
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};
//comment
	$scope.getFavoriteProfileId = function(favoriteProfileId) {
		FavoriteService.fetchFavoriteProfileId(FavoriteProfileId)
			.then(function(result) {
				if(result.status.data === 200) {
					$scope.favoriteData = result.data.data;
				} else {
					$scope.alerts[0] = {type: "danger", msg: result.data.message};
				}
			})
	};
	/**
	 * creates a favorite and sends it to the favorite API
	 *
	 * @param favorite
	 * @param validated true if Angular validated the form, false if not
	 **/
	$scope.createFavorite = function(favorite, validated) {
		if(validated === true) {
			FavoriteService.create(favorite)
				.then(function(result) {
					if(result.data.status === 200) {
						$scope.alerts[0] = {type: "success", msg: result.data.message};
						$scope.newFavorite = {favoriteId: null, favoriteProfileId: null};
					} else {
						$scope.alerts[0] = {type: "danger", msg: result.data.message};
					}
				});
		}
	};

	/**
	 * updates a favorite and sends it to the favorite API
	 *
	 * @param favorite
	 * @param validated true if Angular validated the form, false if not
	 **/
	$scope.updateFavorite = function(favorite, validated) {
		if(validated === true) {
			FavoriteService.update(favorite.favoriteId, favorite)
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