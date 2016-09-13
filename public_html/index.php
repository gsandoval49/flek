
<?php require_once("php/partials/head-utils.php");?>
<body class="sfooter">
	<div class="sfooter-content">

		<!--begin header-->
		<?php require_once("php/partials/header.php");?>

		<!--begin main content -->
		<main>
			<div class="container-fluid index-div">

				<div ng-view></div>

			</div>
		</main>
	</div>

	<!--begin footer -->
	<?php require_once("php/partials/footer.php");?>
</body>
</html>

