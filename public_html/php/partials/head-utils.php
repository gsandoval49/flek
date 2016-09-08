<DOCTYPE html>
	<html lang="" ng-app="FlekApp">
		<head>
			<!-- The 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
			<meta charset="utf-8"/>
			<meta http-equiv="X-UA-COMPATIBLE" content="IE=edge"/>
			<meta name="viewport" content="width=device-width, initial-scale=1"/>

			<!-- set base for relative links - to enable pretty URLs -->
			<base href="<?php echo dirname($_SERVER["PHP_SELF"]) . "/"; ?>">

			<!-- Latest compiled and minified CSS -->
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
					integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
					crossorigin="anonymous">

			<!-- FontAwesome -->
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">

			<!-- Google Fonts -->
			<link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet">

			<!-- Our Custom CSS -->
			<link rel="stylesheet" href="css/style.css" type="text/css">

			<!--Angular JS Libraries incorporated from templating angular class-->
			<?php $ANGULAR_VERSION = "1.5.8"; ?>
			<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION; ?>/angular.min.js"></script>
			<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION; ?>/angular-messages.min.js"></script>
			<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION; ?>/angular-route.js"></script>
			<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION; ?>/angular-animate.js"></script>
			<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/1.3.3/ui-bootstrap-tpls.min.js"></script>
			<!-- load OUR angular files. -->
			<script src="angular/flek.js"></script>
			<script src="angular/route-config.js"></script>
			<script src="angular/directives/bootstrap-breakpoint.js"></script>
			<!--services-->

			<!-- more angular controllers as we create the views -->
			<script src="angular/controllers/home-controller.js"></script>
			<script src="angular/controllers/sign-up-controller.js"></script>
			<script src="angular/controllers/about-controller.js"></script>
			<script src="angular/controllers/nav-controller.js"></script>
			<script src="angular/controllers/profile-controller.js"></script>
			<script src="angular/controllers/feed-controller.js"></script>


			<title>Flek</title>

		</head>
