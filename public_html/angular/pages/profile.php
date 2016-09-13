<!--container for profile picture & profile content-->
<div class="container">
	<div class="row">
		<div class="col-md-3 profile-picture"></div>
		<div class="col-md-3">
			<h1>Staci Parker</h1>
			<h4>Artist</h4>
			<h4>Location: Albuquerque, NM</h4>
			<p>Bio: Artist, blogger, writer, consultant. Paints poetic landscapes, nature, birds, and still like paintings.
				http://staciparker.com</p>
			<p>"There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is
				pain..."</p>
		</div>
		<div class="col-md-3">
			<h4>Favorite My Profile</h4>
			<button href="" class="btn btn-default" type="submit"><i class="fa fa-heart-o fa-lg"></i>Favorite</button>
		</div>
		<div class="col-md-3">
			<h4>Send Me A Message</h4>
			<button class="btn btn-default" type="button" ng-show="touched"><i class="fa fa-envelope-o fa-lg"></i>message
			</button>
			<h4>example</h4>
			<button class="btn btn-info collapsed" type="button" data-toggle="collapse" data-target="#tweetService"
					  aria-expanded="false" aria-controls="collapseExample">Message Me
			</button>
			<div class="collapse in" id="tweetService" aria-expanded="true">
				<br>
				<pre class="hljs php"><span class="message-info">
					** message info

					</pre>
			</div>
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
