<form>
<div class="col-sm-4">
	<div class="form-group">
		<label for="email">Email <span class="text-danger">*</span></label>
		<div class="input-group" ng-class="{ 'has-error': signinForm.profileEmail.$touched && signinForm.profileEmail.$invalid}">

			<div class="input-group-addon">
				<i class="fa fa-envelope" aria-hidden="true"></i>
			</div>

			<input type="email" class="form-control" id="profileEmail" name="profileEmail" placeholder="Email" ng-required="true"/>
		</div>

		<div class="alert alert-danger" role="alert" ng-messages="signinForm.profileEmail.$error" ng-if="signinForm.$touched" ng-hide="signinForm.profileEmail.$valid">
			<p ng-message="required">Email Required</p>
		</div>
	</div>

	<div class="form-group">
		<label for="password">Password <span class="text-danger">*</span></label>
		<div class="input-group" ng-class="{ 'has-error': signinForm.profilePassword.$touched && signinForm.profilePassword.$invalid}">

			<div class="input-group-addon">
				<i class="fa fa-comment" aria-hidden="true"></i>
			</div>

			<input class="form-control" type="password" id="profilePassword" name="password" placeholder="password" ng-required="true"/>
			<p ng-message="required">Password Required</p>
		</div>
	</div>

	<button class="btn btn-success" type="submit"><i class="fa fa-pencil"></i> Sign In</button>
</div>
</form>
<div class="col-sm-7">
</div>


