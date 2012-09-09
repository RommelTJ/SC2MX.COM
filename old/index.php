<?php 

$feed_url = 'http://www.sc2mx.com/forums/external.php?do=rss&type=newcontent&days=120&count=4';
$handler = curl_init($feed_url);
curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handler, CURLOPT_HEADER, 0);
$response = curl_exec ($handler);
curl_close($handler);
$feeds = new SimpleXmlElement($response, LIBXML_NOCDATA);

$posts_url = 'http://sc2mx.com/forums/external.php?type=RSS2&days=120&count=9&fulldesc=TRUE';
$postcurl = curl_init($posts_url);
curl_setopt($postcurl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($postcurl, CURLOPT_HEADER, 0);
$postres = curl_exec ($postcurl);
curl_close($postcurl);
$posts = new SimpleXmlElement($postres, LIBXML_NOCDATA);




$calendar="https://www.google.com/calendar/feeds/fi6qgmpb0669gfecm97albjufk%40group.calendar.google.com/public/basic?singleevents=true&orderby=starttime&max-results=5&sortorder=ascending&futureevents=true";
$calendarcurl = curl_init($calendar);
curl_setopt($calendarcurl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($calendarcurl, CURLOPT_HEADER, 0);
$calendarxml = curl_exec ($calendarcurl);
curl_close($calendarcurl);
$events = new SimpleXmlElement($calendarxml, LIBXML_NOCDATA);

?>

<!doctype html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		
		<title>SC2MX</title>
		<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="./css/style.css" />
		<script type="text/javascript">
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-6937338-2']);
		  _gaq.push(['_trackPageview']);
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		</script>
	</head> 
	<body>
	
	<header>
		<div class="navbar">
			<div class="navbar-inner">
    			<div class="container">
      				<a class="brand" href="http://sc2mx.com/">
  						SC2MX
					</a>
					<ul class="nav">
						<li><a href="http://sc2mx.com/forums/forum.php">Foros</a></li>
                                          <li><a href="http://sc2mx.com/forums/search.php?do=getnew&contenttype=vBForum_Post">Novedades</a></li>
						<li><a href="http://nexus.sc2mx.com/">Nexus</a></li>
						<li><a href="http://lms2.com.mx/">LMS</a></li>
						<li><a href="http://www.facebook.com/sc2mx">Facebook</a></li>
					</ul>
    			</div>
  			</div>
		</div>
	</header>
	<section>
		<div class="container">
			<div class="row">
			<div class="span12">
				<a href="http://sc2mx.com/forums/register.php"><img src="/img/FancyAd.png" /></a>
				<div id="streams">
					<ul class="nav nav-pills">
					</ul>
					<div class="row">
						<div class="span8" id="stream_content"></div>
						<div class="span4" id="stream_chat"></div>
					</div>
					<hr />
				</div>
					<div class="row">
			  			<div class="span9">
		  					<h2>Noticias</h2>
							<div id="myCarousel" class="carousel slide">
							    <div class="carousel-inner">
							    	<?php $a=0;foreach($feeds->channel->item as $mainer ){
							    		preg_match_all('/<img[^>]+>/i',$mainer->description, $img1);
										preg_match_all('/(src)=("[^"]*")/i',$img1[0][0], $img_src1);
										if($a==0):
											$act="active ";
										else:
											$act="";
										endif;
									?>
								      <div class="<?= $act;?>item hcontrol">
								        <a href="<?= $mainer->link ?>"><img src=<?= stripslashes($img_src1[2][0]);?> alt=""></a>
								        <div class="carousel-caption">
								          <h4><?= $mainer->title; ?></h4>
								          <p><?= substr(strip_tags($mainer->description),0,200); ?>... <a href="<?= $mainer->link ?>">Ver mas</a></p>
								        </div>
								      </div>
								   <?php $a++;}; ?>
							    </div>
							    <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>
							    <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
							</div>			  						
								<div class="otros">
			  						<ul class="thumbnails">
			  						<?php $b=0;foreach($feeds->channel->item as $changer ){
			  							preg_match_all('/<img[^>]+>/i',$changer->description, $img2);
										preg_match_all('/(src)=("[^"]*")/i',$img2[0][0], $img_src2);
									?>
									<li class="span2">
									<a href="#" class="carchanger thumbnail" data-change="<?= $b;?>">
			  							<img src=<?= stripslashes($img_src2[2][0]);?>/>
			  							<h5><?= $changer->title; ?></h5>
			  						</a>
			  						</li>
			  						<?php $b++;}?>
			  						</ul>
			  				</div>
			  				<h3>&Uacute;ltimas entradas en el foro</h3>
			  				<hr />
			  				<div class="row">
			  				<?php 
			  				//Output feeds
							foreach($posts->channel->item as $feed) {
								preg_match_all('/<img[^>]+>/i',$feed->description, $img);
								preg_match_all('/(src)=("[^"]*")/i',$img[0][0], $img_src);
								$namespaces = $feed->getNameSpaces(true);
								//Now we don't have the URL hard-coded
								$dc = $feed->children($namespaces['dc']); 
								$content = $feed->children($namespaces['content']); 
								?>
    							<div class="span9">
	    							<div class="row">
	    								<div class="span2">
	    									<a href="http://sc2mx.com/forums/member.php?<?= $dc->uid; ?>" target="_blank">
	    										<h4 ><?= $dc->creator;?></h4>
												<img src="http://sc2mx.com/forums/image.php?u=<?= $dc->uid; ?>" />				
		    								</a>
	    								</div>
	    								<div class="span7 foros">
		    								<h4><a href="<?= $feed->link; ?>"><?= $feed->title; ?></a></h4>
		    								<h5>Publicado: <?= date("Y-m-d H:i", strtotime($feed->pubDate)); ?></h5>
		    								<p ><?= $content->encoded; ?></p>
		    								<a href="<?= $feed->link ?>">Ver en el foro</a>
	    								</div>
	    							</div>
	    							<hr />
    							</div>
							<?php }; ?>
							</div>
			  			</div>
			  			<div class="span3">
			  				<h3>Proximos eventos</h3>
			  				<ul>
			  				<?php foreach ($events->entry as $entry) {
      						$title = stripslashes($entry->title);
      						$summary = stripslashes($entry->summary);
      						$summary_pre=str_replace('á', '&aacute;', $summary);
      						$summary_lol=explode('<br>', $summary_pre);
      						$summary_final=$summary_lol[0];
      						?>
      							<li>
      								<h5><?= $title; ?></h5>
      								<span><?= $summary_final; ?></span><br />
      								<a href="<?= $entry->link->attributes()->href; ?>" target="_blank">Guardar en mi calendario</a>
      							</li>
      						<?php }; ?>
			  				</ul>
			  				<object width="100%" height="600" id="obj_1297019226277"><param name="movie" value="http://chatsc2mx.chatango.com/group"><param name="wmode" value="transparent"><param name="AllowScriptAccess" value="always"><param name="AllowNetworking" value="all"><param name="AllowFullScreen" value="true"><param name="flashvars" value="cid=1297019226277&amp;a=CCCCCC&amp;b=51&amp;f=43&amp;i=87&amp;k=999999&amp;l=FFFFFF&amp;m=FFFFFF&amp;o=30&amp;r=100&amp;s=1"><embed id="emb_1297019226277" src="http://chatsc2mx.chatango.com/group" width="100%" height="600" wmode="transparent" allowscriptaccess="always" allownetworking="all" type="application/x-shockwave-flash" allowfullscreen="true" flashvars="cid=1297019226277&amp;a=CCCCCC&amp;b=51&amp;f=43&amp;i=87&amp;k=999999&amp;l=FFFFFF&amp;m=FFFFFF&amp;o=30&amp;r=100&amp;s=1"></object>
			  				<h3>Patrocinios</h3>
			  				<hr />
			  				<center><script type="text/javascript"><!--
google_ad_client = "ca-pub-1286901460565753";
/* sc2mx_skyscraper */
google_ad_slot = "2678785854";
google_ad_width = 160;
google_ad_height = 600;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></center>
			  			</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<footer>
		<div class="container">
			<div class="row">
				<div class="span12">
					<hr />
					<h3>Streams participantes:</h3>
					<ul class="nav nav-pills">
						<li><a href="http://twitch.tv/horusstv" target="_blank">horusstv</a></li>
                                                <li><a href="http://twitch.tv/rommeltj" target="_blank">rommeltj</a></li>
                                                <li><a href="http://twitch.tv/beefchief3" target="_blank">beefchief3</a></li>
                                                <li><a href="http://twitch.tv/zafhir" target="_blank">zafhir</a></li>
                                                <li><a href="http://twitch.tv/jimrsng" target="_blank">jimrsng</a></li>
                                                <li><a href="http://twitch.tv/lowcloud1" target="_blank">lowcloud1</a></li>
                                                <li><a href="http://twitch.tv/zapo_colorado" target="_blank">zapo_colorado</a></li>
                                                <li><a href="http://twitch.tv/xgsrevenge" target="_blank">xgsrevenge</a></li>
                                                <li><a href="http://twitch.tv/itmax" target="_blank">itmax</a></li>
                                                <li><a href="http://twitch.tv/rohteamtv" target="_blank">rohteamtv</a></li>
                                                <li><a href="http://twitch.tv/lms2tv" target="_blank">lms2tv</a></li>
                                                <li><a href="http://twitch.tv/renosoft" target="_blank">renosoft</a></li>
                                                <li><a href="http://twitch.tv/fwdnarutokun" target="_blank">fwdnarutokun</a></li>
                                                <li><a href="http://twitch.tv/grbindomitus" target="_blank">grbindomitus</a></li>
                                                <li><a href="http://www.twitch.tv/samsc2" target="_blank">samsc2</a></li>
						      <li><a href="http://twitch.tv/fritangatv" target="_blank">fritangatv</a></li>
						      <li><a href="http://www.twitch.tv/jeikostate" target="_blank">jeikostate</a></li>
					<li><a href="http://www.twitch.tv/sc2la" target="_blank">sc2la</a></li>
	</ul>
					<div class="well">
						Hecho con cari&ntilde;o por <a href="http://twitter.com/oso96_2000" target="_blank">@oso96_2000</a> y <a href="http://twitter.com/psyrax" target="_blank">@psyrax</a> usando <a href="http://twitter.github.com/bootstrap" target="_blank">bootstrap</a> para el CSS, <a href="http://bootswatch.com/" target="_blank">bootswatch</a> para el tema y <a href="http://jquery.com/" target="_blank">jQuery</a> para el JS. <a href="https://github.com/psyrax/SC2MX" target="_blank">Ve nuestro c&oacute;digo fuente.</a>
					</div>
				</div>
			</div>
		</div>
	</footer>
		<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
		<script src="./js/bootstrap.js"></script>
		<script src="./js/core.js"></script>

	</body>
</html>
		
