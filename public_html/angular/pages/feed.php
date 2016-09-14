<div>
	<!-- Page Header -->
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header center">Flek Feed
			</h1>
		</div>
	</div>
	<!-- /.row -->
	<!-- Projects Row -->
	<div class="col-md-9">
		<div class="row" ng-repeat="rows in imageDataRow">
			<div class="col-md-6 portfolio-item" ng-repeat="item in rows">
				<a href="#">
					<img id="{{ item.imageGenreId }}" class="img-responsive" src="{{ image.imageSecureUrl }}" alt="image description" height="400", width=700"/>
				</a>
				<h3>
					<a href="#">Profile</a>

				</h3>
			</div>
		</div>

	<div class="col-md-3">
		<ul class="sidebar">
			<li><a href="#drawing">drawing</a></li>
			<li><a href="#sculpture">sculpture</a></li>
			<li><a href="#painting">painting</a></li>
			<li><a href="#graffiti">graffiti</a></li>
			<li><a href="#graphic-design">graphic-design</a></li>
			<li><a href="#fashion">fashion</a></li>
		</ul>
	</div>

</div>


