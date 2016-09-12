<div id="signup" class="row signup-content ">
	<div class="col-md-8">
			<h3>Flek</h3>
			<p>Sign up to see art from your community!</p>


		<section id="signup">
		<div class="container">
		<div class="row">
				<!--room for sign up form here-->

				<div class="col-md-8">
					<h2>Create Free Account</h2>
					<div class="row">
						<!--Begin Actual Contact Form-->
						<div class="jumbotron col-md-8 col-lg-offset-5">
							<form id="signup-form" action="php/mailer.php" method="post">

								<div class="form-group">
									<label for="name">Name <span class="text-danger">*</span></label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-user" aria-hidden="true"></i>
										</div>
										<input type="text" class="form-control" id="name" name="name" placeholder="Name">
									</div>
								</div>

								<div class="form-group">
									<label for="email">Email <span class="text-danger">*</span></label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-envelope" aria-hidden="true"></i>
										</div>
										<input type="email" class="form-control" id="email" name="email" placeholder="Email">
									</div>
								</div>

								<div class="form-group">
									<label for="city">City <span class="text-danger">*</span></label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-pencil" aria-hidden="true"></i>
										</div>
										<input type="text" class="form-control" id="city" name="city" placeholder="City">
									</div>
								</div>

								<div class="form-group">
									<label for="city">Bio <span class="text-danger">*</span></label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-pencil" aria-hidden="true"></i>
										</div>
										<input type="text" class="form-control" id="bio" name="bio" placeholder="Biography">
									</div>
								</div>

								<div class="form-group">
									<label for="password">Password <span class="text-danger">*</span></label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-comment" aria-hidden="true"></i>
										</div>
										<textarea class="form-control" id="password" name="password"
													 placeholder="Password"></textarea>
									</div>
								</div>

								<div class="form-group">
									<label for="passwordConfirm">Confirm Password <span class="text-danger">*</span></label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-comment" aria-hidden="true"></i>
										</div>
										<textarea class="form-control" id="passwordConfirm" name="passwordConfirm"
													 placeholder="Confirm password"></textarea>
									</div>
								</div>





								<button class="btn btn-success" type="submit"><i class="fa fa-pencil"></i> Create</button>
								<button class="btn btn-warning" type="reset"><i class="fa fa-ban"></i> Reset</button>
							</form>
						</div>
						<div class="col-md-3"></div>

						<!--empty area for form error/success output-->
						<div class="row">
							<div class="col-xs-12">
								<div id="output-area"></div>
							</div>
						</div>
					</div>
				</div>


			</div>
		</div>
	</div>
	</div>

</section>