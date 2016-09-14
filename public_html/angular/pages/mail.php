
<!--Mail Inbox-->
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1>Your Messages</h1>
			<table class="table table-hover table-responsive table-striped">
				<tr>
					<th>From</th>
					<th>To</th>
					<th>Subject</th>
					<th>Message</th>
				</tr>
				<tr ng-repeat="spam in mailbox">
					<td>{{ getProfile(spam.mailSenderId).profileName }}</td>
					<td>{{ getProfile(spam.mailReceiverId).profileName }}</td>
					<td>{{ spam.mailSubject }}</td>
					<td>{{ spam.mailContent }}</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<br>

<!--form taken out from profile-->
<div class="row">
	<div class="col-md-2"></div>
	<div class="col-md-8">
		<div class="form-group">
			<label for="subject">Subject <span class="text-danger">*</span></label>

			<div class="input-group">
				<div class="input-group-addon">
					<i class="fa fa-pencil" aria-hidden="true"></i>
				</div>
				<input type="text" class="form-control" id="subject" name="subject" placeholder="Subject"
						 ng-model="formData.subject" ng-minlength="2" ng-maxlength="128" ng-required="true">
			</div>
			<!-- input group -->


			<div class="alert alert-danger" role="alert" ng-messages="messageForm.subject.$error"
				  ng-if="messageForm.subject.$touched" ng-hide="messageForm.subject.$valid">
				<p ng-message="min">Your message is too small.</p>
				<p ng-message="max">Your message is too large.</p>
				<p ng-message="required">Please enter a message.</p>
			</div>


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

		</div>
		<div class="col-md-2"></div>
	</div>
</div>