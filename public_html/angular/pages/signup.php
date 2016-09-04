<div class="row">
	<!-- <div class="col-md-5">
	  room for large image, maybe scrolling(?)
	  <img src="https://m1.behance.net/rendition/modules/30586517/disp/284234e07eb3d5bb7604f41243d7fd0c.jpg"/>
	</div> -->
	<div class="col-md-1">
		<i class="fa fa-paint-brush fa-5x "></i>

	</div>
	<div class="col-md-6">
		<div class="row">
			<h3>Flek</h3>
			<p>Sign up to see art from your community! Create a new account or sign in with Facebook:</p>
			<a href="signup.php" class="btn btn-warning btn-lg"> <i class="fa fa-facebook fa-lg"></i> </a>
			<div class="row">
				<!--room for sign up form here-->

				<!--begin sign up form-->
				<div class="container">
					<h2>Create Free Account</h2>
					<div class="row">
						<!--Begin Contact Form-->
						<div class="col-md-6">
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
									<label for="password">Password <span class="text-danger">*</span></label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-comment" aria-hidden="true"></i>
										</div>
										<textarea class="form-control" id="password" name="password"
													 placeholder="password"></textarea>
									</div>
								</div>

								<!-- reCAPTCHA -->
								<div class="g-recaptcha" data-sitekey="--YOUR RECAPTCHA SITE KEY--"></div>

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