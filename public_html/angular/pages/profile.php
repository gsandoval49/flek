<!--container for profile picture & profile content-->
<div class="container">
	<div class="row">
		<div class="col-md-4 profile-picture"></div>
		<div class="col-md-6">
			<h1>Staci Parker</h1>
			<h4>Artist</h4>
			<h4>Location: Albuquerque, NM</h4>
			<p>Bio: Artist, blogger, writer, consultant. Paints poetic landscapes, nature, birds, and still like paintings.
				http://staciparker.com</p>
			<p>"There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is
				pain..."</p>
		</div>
		<div class="col-md-2" ng-controller="MailController">
			<!-- favorite button section -->
			<h4>Favorite My Profile</h4>
			<button href="" class="btn btn-default" type="submit"><i class="fa fa-heart-o fa-lg"></i>Favorite</button>

			<!--message section -->
<!--			<h4>Send Me A Message</h4>
			<button class="btn btn-default" type="button" ng-click="touched = !touched" ><i class="fa fa-envelope-o fa-lg"></i>message
			</button>-->
			<!--<div class="col-xs-12 col-md-6  col-md-offset-2">--> <!--took this away. it's got gray i don't need.-->


				<!--Begin Contact Form-->
<!--				<form name="messageForm" class="form-horizontal well" ng-controller="MessageController"
						ng-submit="submit(formData, messageForm.$valid);" id="messageForm" action="../php/mailer.php"
						method="post" novalidate>-->

					<!--<h4>Contact Staci:</h4>-->

						<div class="alert alert-danger" role="alert" ng-messages="messageForm.name.$error"
							  ng-if="messageForm.name.$touched" ng-hide="messageForm.name.$valid">
							<p ng-message="min">Your name is too small.</p>
							<p ng-message="max">Your name is too large.</p>
							<p ng-message="required">Please enter your name.</p>
						</div>

					</div> <!-- form group -->



		<!-- form-group -->

					<!--empty area for form error/success output-->
					<div class="row">
						<div class="col-xs-6 col-md-6 col-md-offset-5">
							<div id="output-area"></div>
						</div>
					</div>

				</form>


			</div> <!-- row -->

		</div>
	</div>
</div>


<!--<div class="row nav">
	<div class="col-md-4"></div>
	<div class="col-md-4 col-xs-12">

	</div>
</div>-->


<!-- begin gallery -->
<div class="container">
	<!-- Page Header -->
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Profile Feed
			</h1>
		</div>
	</div>
	<!-- /.row -->
	<!-- Projects Row -->
	<div class="row">
		<div class="col-md-6 portfolio-item">
			<a href="#">
				<img class="img-responsive" src="http://placehold.it/700x400" alt=""/>
			</a>
			<h3>
				<a href="#">Profile</a>


			</h3>
		</div>
		<div class="col-md-6 portfolio-item">
			<a href="#">
				<img class="img-responsive" src="http://placehold.it/700x400" alt=""/>
			</a>
			<h3>
				<a href="#">Profile</a>
			</h3>
		</div>
	</div>
	<!-- /.row -->
	<!-- Projects Row -->
	<div class="row">
		<div class="col-md-6 portfolio-item">
			<a href="#">
				<img class="img-responsive" src="http://placehold.it/700x400" alt=""/>
			</a>
			<h3>
				<a href="#">Profile</a>
			</h3>
		</div>
		<div class="col-md-6 portfolio-item">
			<a href="#">
				<img class="img-responsive" src="http://placehold.it/700x400" alt=""/>
			</a>
			<h3>
				<a href="#">Profile</a>
			</h3>
		</div>
	</div>

</div>
