<form>
<div class="col-sm-4">
	<div class="form-group">
		<label for="email">Email <span class="text-danger">*</span></label>
		<div class="input-group" ng-class="{ 'has-error': profileSignupForm.full}">
			<div class="input-group-addon">
				<i class="fa fa-envelope" aria-hidden="true"></i>
			</div>
			<input type="email" class="form-control" id="email" name="email" placeholder="Email" ng-minlength="4" ng-maxlength="128" ng-required="true"/>
		</div>
		<div class="alert alert-danger" role="alert" ng-messages="profileSignupForm.$error" ng-if="profileSignupForm.$touched" ng-hide="profileSignupForm.$valid">
			<p ng-message="minlength">Email is too short.</p>
			<p ng-message="maxlength">Email is too long.</p>
			<p ng-message="required">Please enter your email.</p>
		</div>
	</div>

	<div class="form-group">
		<label for="password">Password <span class="text-danger">*</span></label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-comment" aria-hidden="true"></i>
			</div>
			<input class="form-control" type="password" name="password"
						 placeholder="password">
		</div>
	</div>

	<button class="btn btn-success" type="submit"><i class="fa fa-pencil"></i> Sign In</button>
</div>
</form>
<div class="col-sm-7">
</div>


