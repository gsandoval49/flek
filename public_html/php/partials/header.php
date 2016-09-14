<header ng-controller="navController">
    <!-- bootstrap breakpoint directive to control collapse behavior -->
    <bootstrap-breakpoint></bootstrap-breakpoint>

    <nav class="navbar navbar-default navbar-inverse">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" aria-expanded="false" ng-click="navCollapsed = !navCollapsed">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index">Flek</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" uib-collapse="navCollapsed">

                <!--Nav bar links - also added if signed in show feed and profile, if not signed in they see sign up or sign in-->
                <!--Courtesy of Skyler R.-->
                <ul class="nav navbar-nav navbar-right" >
                    <li><a href="index">Home</a></li>
                    <li><a href="about">About</a></li>

                    <?php if(empty($_SESSION["profile"]) === true) { ?>
                    <li><a href="signup">Sign Up</a></li>
                    <li><a href="signin">Sign In</a></li>
                    <?php } else { ?>
                    <!--place feed and profile back in here once we get it to work-->
                        <li><a href="feed">Feed</a></li>
                        <li><a href="profile">Profile</a></li>
							  <li><a href="mail">Mail</a></li>
                    <li><a href="index">Sign Out</a></li>
                    <?php } ?>

                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</header>
<?php if(empty($_SESSION["profile"]) === false) {
	echo "<p><em>Welcome back, " . $_SESSION["profile"]->getProfileName() . "</em></p>";
}

 if(empty($_SESSION = []) === false) {
	echo "<p><em>You are signed out, " . $_SESSION["profile"]->getProfileName() . "</em></p>";
}