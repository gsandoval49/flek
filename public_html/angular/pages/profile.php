<!--container for profile picture & profile content-->
<div class="container">
	<div class="row">
		<div class="col-md-4 profile-picture"></div>
		<div class="col-md-4">
			<h1>Staci Parker</h1>
			<h4>Artist</h4>
			<h4>Location: Albuquerque, NM</h4>
			<p>Bio: Artist, blogger, writer, consultant. Paints poetic landscapes, nature, birds, and still like paintings.
				http://staciparker.com</p>
			<p>"There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is
				pain..."</p>
		</div>
		<div class="col-md-4" ng-controller="MailController">
			<!-- favorite button section -->
			<h4>Favorite My Profile</h4>
			<button href="" class="btn btn-default" type="submit"><i class="fa fa-heart-o fa-lg"></i>Favorite</button>

			<!--message section -->
			<h4>Send Me A Message</h4>
			<button class="btn btn-default" type="button" ng-click="touched = !touched" ><i class="fa fa-envelope-o fa-lg"></i>message
			</button>
			<div class="col-xs-12 col-md-6  col-md-offset-2">


				<!--Begin Contact Form-->
				<form name="messageForm" class="form-horizontal well" ng-controller="MessageController"
						ng-submit="submit(formData, messageForm.$valid);" id="messageForm" action="../php/mailer.php"
						method="post" novalidate>


					<h2>Contact Staci:</h2>


					<!--<div class="form-group">
						<label for="name">Name <span class="text-danger">*</span></label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-user" aria-hidden="true"></i>
							</div>
							<input type="text" class="form-control" id="name" name="name" placeholder="Name"
									 ng-model="formData.name" ng-minlength="2" ng-maxlength="64" ng-required="true">
						</div> <!-- input group -->


						<div class="alert alert-danger" role="alert" ng-messages="messageForm.name.$error"
							  ng-if="messageForm.name.$touched" ng-hide="messageForm.name.$valid">
							<p ng-message="min">Your name is too small.</p>
							<p ng-message="max">Your name is too large.</p>
							<p ng-message="required">Please enter your name.</p>
						</div>

					</div> <!-- form group -->-->


					<div class="form-group">
						<label for="subject">Subject <span class="text-danger">*</span></label>

						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-pencil" aria-hidden="true"></i>
							</div>
							<input type="text" class="form-control" id="subject" name="subject" placeholder="Subject"
									 ng-model="formData.subject" ng-minlength="2" ng-maxlength="128" ng-required="true">
						</div> <!-- input group -->


						<div class="alert alert-danger" role="alert" ng-messages="messageForm.subject.$error"
							  ng-if="messageForm.subject.$touched" ng-hide="messageForm.subject.$valid">
							<p ng-message="min">Your message is too small.</p>
							<p ng-message="max">Your message is too large.</p>
							<p ng-message="required">Please enter a message.</p>
						</div>


					</div> <!-- form-group -->


					<div class="form-group">
						<label for="message">Message <span class="text-danger">*</span></label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-comment" aria-hidden="true"></i>
							</div>
							<textarea class="form-control" rows="5" id="message" name="message"
										 placeholder="Message (2000 characters max)"
										 ng-model="formData.message" ng-minlength="2" ng-maxlength="2000"
										 ng-required="true"></textarea>
						</div>

						<div class="alert alert-danger" role="alert" ng-messages="messageForm.message.$error"
							  ng-if="messageForm.message.$touched" ng-hide="messageForm.message.$valid">
							<p ng-message="min">Your message is too small.</p>
							<p ng-message="max">Your message is too large.</p>
							<p ng-message="required">Please enter a message.</p>
						</div>


					</div>

					<button class="btn btn-lg btn-info" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;Send</button>
					<button class="btn btn-lg btn-warning" type="reset" ng-click="reset();"><i class="fa fa-ban"></i>&nbsp;Reset
					</button>


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
