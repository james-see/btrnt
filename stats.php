<!DOCTYPE html>
<html manifest="tw.appcache">
<head>
	<script type="text/javascript">
		(function(document,navigator,standalone) {
			// prevents links from apps from oppening in mobile safari
			// this javascript must be the first script in your <head>
			if ((standalone in navigator) && navigator[standalone]) {
				var curnode, location=document.location, stop=/^(a|html)$/i;
				document.addEventListener('click', function(e) {
					curnode=e.target;
					while (!(stop).test(curnode.nodeName)) {
						curnode=curnode.parentNode;
					}
					// Condidions to do this only on links to your own app
					// if you want all links, use if('href' in curnode) instead.
					if('href' in curnode ) {
						e.preventDefault();
						location.href = curnode.href;
					}
				},false);
			}
		})(document,window.navigator,'standalone');
	</script>
<script type="text/javascript" src="http:///ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="text/javascript">

var addToHomeConfig = {
	returningVisitor: true,		// Show the message only to returning visitors (ie: don't show it the first time)
	expire: 720					// Show the message only once every 12 hours
};


function hideAddressBar()
{
  if(!window.location.hash)
  {
      if(document.height < window.outerHeight)
      {
          document.body.style.height = (window.outerHeight + 50) + 'px';
      }

      setTimeout( function(){ window.scrollTo(0, 1); }, 50 );
  }
}
</script>
<link rel="stylesheet" href="add2home.css">
<script type="application/javascript" src="add2home.js"></script>
<link rel="shortcut icon" href="http://www.btrnt.com/favicon.ico?t="/>
<?php
  $browser = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
    if ($browser == true){
    $browser = 'iphone';
  }
?>
<?php if($browser == 'iphone'){ ?>
  <title>Bot R Not</title>
  <meta name="format-detection" content="telephone=no">
 <meta name="viewport" id="vp" content="initial-scale=1.0,user-scalable=no,maximum-scale=1,width=device-width" />
 <meta name="viewport" id="vp" content="initial-scale=1.0,user-scalable=no,maximum-scale=1" media="(device-height: 568px)" />
  <link rel="stylesheet" type="text/css" href="mobile.css" media="all">
  <meta name="apple-touch-fullscreen" content="yes" />
    <meta name="apple-mobile-web-app-capable" content="yes" /> <!-- you can comment this out to test to make sure it works-->
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />

<?php }else{ ?>
  <title>Bot R Not by @jamescampbell</title>
  <link rel="stylesheet" type="text/css" href="view.css" media="all">
<?php } ?>

<?php include 'mycon.php'?>
<?php include 'getpop.php'?>
<link rel="apple-touch-icon-precomposed" href="apple-touch-icon.png"/>
</head>
<body id="main_body" onload="hideAddressBar()">
<div id="stats" style='width:90%;margin:auto;'>
	<div id="center-table" style="width:100%;margin:auto 0 0;">
<?php include 'getstats.php'?>
	</div>
</div>
</body>
</html>

