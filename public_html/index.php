// WE'RE PRETTY SURE THIS IS SUPPOSE TO BE THE LIVE CODE AND COMMENTED OUT THE ORIGINAL BELOW
<?php require_once("php/partials/head-utils.php");?>
<body class="sfooter">
	<div class="sfooter-content">

		<!--begin header-->
		<?php require_once("php/partials/header.php");?>

		<!--begin main content -->
		<main>
			<div class="container-fluid">

				<div ng-view></div>

			</div>
		</main>
	</div>

	<!--begin footer -->
	<?php require_once("php/partials/footer.php");?>
</body>
</html>



<!--UNCOMMENTED CODE-->
<!--
<?php
/*// insert entire <head> tag
require_once("php/partials/head-utils.php"); */?>

<body class="sfooter">
	<div class="sfooter-content">

		<!--begin header-->
		<?php /*require_once("php/partials/header.php") */?>

		<!--begin main content -->
		<main>
			<div class="container-fluid">

				<!-- added view from #3 in directives. this is angular view directive, where main content view will be updated -->
				<div ng-view></div>

			</div>
		</main>
	</div>

	<!--begin footer -->
	<!-- require once -->
	<?php /*require_once("php/partials/footer.php") */?>
</body>
</html>
-->