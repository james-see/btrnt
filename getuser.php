<?php 
$username = isset($_GET['username']) ? $_GET['username'] : 'jamescampbell';
require_once ('codebird.php');
Codebird::setConsumerKey('J6D02oyoZGD7N5bMkZTeIw', '7HmaYNfuwBWXElr3MacV2Twpkj63ALZSV87HkwrtIjs'); // static, see 'Using multiple Codebird instances'

$cb = Codebird::getInstance();
$cb->setToken('13050982-CzHNmsiBdhw0btNxiyxe1Uu3t179LcjYX59QvfLBL', 'NKXwQxJnkXu27eOUg5mD0hsA4qZlrSd8ORkF2kZ6c');

$spalgorithm = 0;
$bigger = 'bigger';
$params = array(
	'size' => $bigger,
    'screen_name' => $username
);
	$reply = $cb->users_show($params); // this is loading everything from twitter into the generic object $reply
//print_r($reply); // spit out all api items at once for checking and debugging purposes only
$tid = $reply->id; //twitter user id
$location = $reply->location; // twitter user location listed in profile (different from geo)
$locwarning = '';
if ($location == ''):
	$location = 'No Location listed';
	$locwarning = "<div id='warning'>☒ No Location listed -uh oh spalgorithm +1</div>";
	$spalgorithm++;
	else: $location = 'location: ' . $location;
	endif;
$coord = (array) $reply->status->coordinates;
$geostatus = (array) $reply->status->geo;
$lasttdate = $reply->status->created_at;

$followers = $reply->followers_count; // follower count
$following = $reply->friends_count; // following count
$popfix = ''; // to fix when following > followers
$tname = $reply->name;
$desc = $reply->description;
$descwarn = '';
if ($desc == '') {$descwarn = "<div id='warning'>☒ no description - uh oh spalgorithm +1</div>";$spalgorithm++;}
$prot = "protected"; // is the twitter profile protected?
$protect = $reply->$prot;
if ($protect == 1) {$protect = 'yes';} else $protect = 'no'; 
$urll = $reply->url; // website for user
if ($urll != '') {$urll = "website: <a href='$urll'>$urll</a>";}
$geo = $reply->geo_enabled; // does the user have geo tweets turned on?
$geowarn = '';
if ($geo == 1):
 $geo = "✓ Geo data turned on for <a href='http://www.btrnt.com/geotweet.php?u=$tid'>profile</a>";
 else: 
 $geo = 'Geo data turned off for profile';
 $geowarn = "Geo data turned off for profile";
 endif;
 
$urlwarn = '';
if ($urll == '') {$urlwarn = "<div id='warning'>☒ no URL listed -uh oh spalgorithm +1</div>";$spalgorithm++;} // spalgorithm 1
$profileimg = $reply->profile_image_url_https; // user profile image link
$imgtype = strrchr($profileimg,'.');
$imgname = strrchr($profileimg,'/');
if ($imgtype == '.jpg' && $imgname == '/image_reasonably_small.jpg'):
$profileimglrg = rtrim($profileimg, "_reasonably_small.jpg") . "_bigger.jpg";
 elseif ($imgtype == '.jpg' && $imgname == '/image_normal.jpg'):
$profileimglrg = rtrim($profileimg, "_normal.jpg") . ".jpg";
 elseif ($imgtype == '.jpeg'):
$profileimglrg = rtrim($profileimg, "_normal.jpeg") . ".jpeg";
 elseif ($imgtype == '.png' && $imgname == '/twitter_reasonably_small.png'):
	$profileimglrg = rtrim($profileimg, "_reasonably_small.png") . ".png";
 elseif ($imgtype == '.png' && $imgname == "/twitter_normal.png"):
 	$profileimglrg = rtrim($profileimg, "_normal.png") . "r.png";
  elseif ($imgtype == '.png' && $imgname == '/facebook_normal.png'):
$profileimglrg = rtrim($profileimg, "_normal.png") . ".png";
 else: $profileimglrg = $profileimg;
endif;
$botimgwarn = '';
$botimg = '';
if (strpos($profileimg,'default_profile_images') !== false):
    $botimgwarn = "<div id='warning'>☒ egg image -uh oh spalgorithm +1</div>"; // spalgorithm 2
    $spalgorithm++;
    else: $botimg = '✓ custom profile image';
    endif;
    
$ttweets = $reply->statuses_count; // total tweets
$ttwarn = '';
if ($ttweets == 0):
 $ttwarn = "<div id='warning'>☒ NO TWEETS -uh oh spalgorithm +1</div>";
 $spalgorithm++;
 $lasttweet = 'NO TWEETS';
 else: $lasttweet = $reply->status->text; 
 endif;
$useback = $reply->profile_use_background_image; // background image
$usebackwarning = '';
if ($useback == 1) {$useback = 'Yes! They use a custom background image.';} else {$useback = '';$usebackwarning = "<div id='warning'>no custom background -uh oh spalgorithm +1</div>";$spalgorithm++;} // spalgorithm 3
$created = $reply->created_at;
$favs = $reply->favourites_count;
$favswarn = '';
if ($favs == 0) {$favswarn = "<div id='warning'>☒ NO FAVS -uh oh spalgorithm +1</div>";$spalgorithm++;} // spalgorithm 4
include 'datediff.php';
$daysdiffwarning = '';
$daysdiffstart = DateFigure($created);
if ($daysdiffstart < 30) {$daysdiffwarning = "<div id='warning'>☒ -uh oh, not even a month old spalgorithm +1</div>";$spalgorithm++;}
if ($daysdiffstart < 3) {$daysdiffwarning = "<div id='warning'>☒ -uh oh, not even a few days old spalgorithm +2</div>";$spalgorithm += 2;}
$daysdiffstart = ltrim($daysdiffstart, '+');
$tweetdayavg = $ttweets / $daysdiffstart;
$tweetsperdaywarning = '';
if ($tweetdayavg > 10) {$tweetsperdaywarning = "<div id='warning'>☒ -uh oh, over 10 tweets per day, spalgorithm +1</div>"; $spalgorithm++;}
if ($tweetdayavg > 20) {$tweetsperdaywarning = "<div id='warning'>☒ -uh oh, over 20 tweets per day, spalgorithm +2</div>"; $spalgorithm += 2;}
if ($tweetdayavg > 30) {$tweetsperdaywarning = "<div id='warning'>☒ -uh oh, over 30 tweets per day, spalgorithm +3</div>"; $spalgorithm += 3;}
if ($tweetdayavg > 40) {$tweetsperdaywarning = "<div id='warning'>☒ -uh oh, over 30 tweets per day, spalgorithm +4</div>"; $spalgorithm += 4;}
if ($tweetdayavg > 50) {$tweetsperdaywarning = "<div id='warning'>☒ -uh oh, over 30 tweets per day, spalgorithm +5</div>"; $spalgorithm += 5;}
$roundedtweetdayavg = round($tweetdayavg,2);
// equations
$popularity = (($followers+100) / ($following+100)) * 2;
if ($following > $followers) {$popularity = 0; $popfix = 'Followers are not larger than following so cannot compute popularity score';}
$spamrating = $spalgorithm/9 * 100;
$lasttdatereport = '';
if ($lasttdate != ''):
	$lasttdatereport = 'last tweet date: ' . $lasttdate;
	endif;
$dayssincereport = '';
	if ($lasttweet != 'NO TWEETS') {$dayssince = DateFigure($lasttdate);
	if ($dayssince >= 1) {$dayssincereport = "days since last tweet: $dayssince";} // makes sure days count displays properly
}
// current as of 4/28/2013 - factors: description, twitter image, twitter background, # of favs, website, tweets per day, profile creation date, total tweets, no location
$roundedspamrating = round($spamrating,2);

// ul list of all the results from query
	echo "<ul style='text-align:center'>";
	//echo "<lh id='resultstitle'>PROFILE INFO</lh>";
	echo  "<li id='tname'>$tname (<a href='http://www.twitter.com/$username'>@$username</a>) <div id='double'>id: $tid</div></li>";
	echo "<li id='description' style='text-align:left;'>$desc</li>";
	echo "<div id='wrapper'><li><div id='double'>$location</div><div id='double'>followers: <a href='http://www.twitter.com/$username/followers'>$followers</a></div><div id='double'>following: <a href='https://twitter.com/dcemmy/following'>$following</a></div><div id='double'>total tweets: <a href='http://www.twitter.com/$username'>$ttweets</a></div></li></div>";
	//echo "<li>following: $following</li>";
	
	//echo "<li><div id='circular' style='background-image:url($profileimglrg);'><a href='$profileimglrg'><img src='$profileimglrg'></a></div></li>";
	echo "<li><a href='$profileimglrg'><div id='circular' style='background-image:url($profileimglrg);'></a></div></li>";
	//echo "<li>$imgtype $imgname</li>"; // check image type and name extension
	echo "<li>$botimg</li>"; //profile image custom or default?
	echo "<li>$geo</li>";
	echo "<li>profile created: $created</li>";
	echo "<div id='wrapper'><li><div id='double'># of favs created: $favs</div><div id='double'>days existed: $daysdiffstart</div><div id='double'>tweets per day: $roundedtweetdayavg</div><div id='double'>private profile? $protect</div></li></div>";
	echo "<li>$urll</li>";
	if ($useback != '') {echo "<li>$useback</li>";}
	$map = 'no';
	if (array_key_exists('coordinates', $geostatus)) {
	if ($geostatus['coordinates'][0] == 'null' || $geostatus['coordinates'][0] == '') {echo '';$map = 'no';} 
	else {$map = 'yes'; echo "<li id='fugeo'>geo of last tweet:";
	$latlng = $geostatus['coordinates'][0].','.$geostatus['coordinates'][1];
	echo "<a href='https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=$latlng&amp;aq=&amp;sll=$latlng&amp;sspn=0.354858,0.532837&amp;t=v&amp;ie=UTF8&amp;ll=$latlng&amp;spn=0.022176,0.033302&amp;z=14'>$latlng</a>";
	echo"</li>";}}
	$map = '"'.$map.'"';
	//echo $map;
	//print_r($geostatus);echo"</li>";
	//echo "<li>coord of last tweet: $coord[1]</li>"; not sure what this is yet
	if ($lasttweet != 'NO TWEETS') {echo "<li>$lasttdatereport</li>"; echo "<li><p style='background-color:#e3e3e3;'>$lasttweet</p></li>";echo "<li>$dayssincereport</li>";}
	echo "<li>$ttwarn $locwarning $favswarn $descwarn $urlwarn $botimgwarn $daysdiffwarning $tweetsperdaywarning $usebackwarning</li>"; //all the warning listed on the bottom;
	echo "<li><a href='http://www.jamescampbell.us/projects/twerifier/about-faq.html'><b>spalgorithm results:</b></a> $spalgorithm score, a $roundedspamrating% probability user is a spammer/bot</li>";
	echo "<li id='popular'><a href='http://www.jamescampbell.us/projects/twerifier/about-faq.html'>"; 
	if ($popularity > 0) {echo "<b>popularity rating:</b></a>"; echo round($popularity);} echo" $popfix</a></li>";
	echo "</ul>"; // whew, we made it
?>
<script>
function GetFree(map){
if (map == '"yes"' || map == 'yes'){
	       $('#geo-map').css({'display':'block'});
	 	    } else {
	    	$('#geo-map').css({'display':'none'});}
	    	return
	    	}
	</script>
<?php
      //print_r($tweets); //is a way to see all the json items returned

?>
