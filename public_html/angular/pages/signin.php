<section id="sign-in">
<div class="signin-content jumbotron">
	<div class="signin-container">
		<div class="row">
			<div class="col-md-12">

		<!--form starts here-->
		<form name="signinForm" id="signinForm" ng-submit="signin(signinData, signinForm.$valid);" novalidate>
			<div class="col-sm-4 col-lg-offset-4 jumbotron text-center">
				<h2>Welcome Back!</h2>
				<p>Please Sign In</p>
				<div class="row">
					<div class="form-group">
						<label for="email">Email <span class="text-danger">*</span></label>
						<div class="input-group"
							  ng-class="{ 'has-error': signinForm.profileEmail.$touched && signinForm.profileEmail.$invalid}">

							<div class="input-group-addon">
								<i class="fa fa-envelope" aria-hidden="true"></i>
							</div>

							<input type="email" class="form-control" id="profileEmail" name="profileEmail" placeholder="Email"
									 ng-required="true" ng-model="signinData.profileEmail"/>
						</div>

						<div class="alert alert-danger" role="alert" ng-messages="signinForm.profileEmail.$error"
							  ng-if="signinForm.$touched" ng-hide="signinForm.profileEmail.$valid">
							<p ng-message="required">Email Required</p>
						</div>
					</div>

					<div class="form-group">
						<label for="password">Password <span class="text-danger">*</span></label>
						<div class="input-group"
							  ng-class="{ 'has-error': signinForm.profilePassword.$touched && signinForm.profilePassword.$invalid}">

							<div class="input-group-addon">
								<i class="fa fa-comment" aria-hidden="true"></i>
							</div>

							<input class="form-control" type="password" id="profilePassword" name="profilePassword"
									 placeholder="password" ng-required="true" ng-model="signinData.profilePassword"/>

							<div class="alert alert-danger" role="alert" ng-messages="signinForm.profilePassword.$error"
								  ng-if="signinForm.$touched" ng-hide="signinForm.profilePassword.$valid">
								<p ng-message="required">Password Required</p>
							</div>
						</div>
					</div>

					<button class="btn btn-success" type="submit"><i class="fa fa-pencil"></i> Sign In</button>
				</div>
			</div>
		</form>
			</div>
			</div>

		<!--Row for Sign In Message
		<section id="welcome" class="message bg primary text-center">
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<h1 class="section-heading">Welcome Back!</h1>
						<p class="signin-icon">Please Sign In</p>
					</div>
				</div>
			</div>
		</section>-->

	</div>
</div>
	</section>






