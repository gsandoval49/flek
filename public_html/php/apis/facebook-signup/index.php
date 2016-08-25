<?php
require_once dirname(dirname(__DIR__)) . "/classes/autoload.php";
require_once dirname(dirname(__DIR__)) . "/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");
use Edu\Cnm\Flek\Profile;

/**
 * api for facebook signup
 *
 * @author Christina Sosa <csosa4@cnm.edu>
 **/
//start session
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}












/*
//use this in the body tag of each page we want it
<script>
window.fbAsyncInit = function() {
	FB.init({
      appId      : '533126920205402',
      xfbml      : true,
      version    : 'v2.7'
    });
  };

(function(d, s, id){
	var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
//like button
<div
  class="fb-like"
  data-share="true"
  data-width="450"
  data-show-faces="true">
</div>
</script>*/