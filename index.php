<?php 

$feed_url = 'http://www.sc2mx.com/forums/external.php?do=rss&type=newcontent&days=120&count=5';
$handler = curl_init($feed_url);
curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handler, CURLOPT_HEADER, 0);
$response = curl_exec ($handler);
curl_close($handler);
$feeds = new SimpleXmlElement($response, LIBXML_NOCDATA);

$posts_url = 'http://sc2mx.com/forums/external.php?type=RSS2&days=120&count=12&fulldesc=TRUE';
$postcurl = curl_init($posts_url);
curl_setopt($postcurl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($postcurl, CURLOPT_HEADER, 0);
$postres = curl_exec ($postcurl);
curl_close($postcurl);
$posts = new SimpleXmlElement($postres, LIBXML_NOCDATA);




$calendar="https://www.google.com/calendar/feeds/fi6qgmpb0669gfecm97albjufk%40group.calendar.google.com/public/basic?singleevents=true&orderby=starttime&max-results=1&sortorder=ascending&futureevents=true";
$calendarcurl = curl_init($calendar);
curl_setopt($calendarcurl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($calendarcurl, CURLOPT_HEADER, 0);
$calendarxml = curl_exec ($calendarcurl);
curl_close($calendarcurl);
$events = new SimpleXmlElement($calendarxml, LIBXML_NOCDATA);

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>SC2MX | StarCraft Mexico y LatinoAmerica</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		
		<!-- Le styles -->
		<link href="assets/css/style.css" rel="stylesheet">
		<style type="text/css">
			body {
				padding-top: 60px;
				padding-bottom: 40px;
			}
		</style>

		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<link rel="shortcut icon" href="assets/ico/favicon.ico">
	</head>

<body>
	<div class="container">
    		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="http://sc2mx.com" ><img src="assets/img/title_sticker.png" /></a>
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
					<div class="nav-collapse">
						<ul class="nav">
							<li><a href="http://www.aztecwarriors.tk/" alt="Aztek Warriors" target="_blank"><img src="assets/img/AW_Original_small.png" /></a></li>
							<li><a href="http://darkkillers-sc2.webs.com/" alt="Dark Killers" target="_blank"><img src="assets/img/DK_Original_small.png" /></a></li>
							<li><a href="http://www.teamfwd.com/" alt="Forgotten Wolved in the Dark" target="_blank"><img src="assets/img/FwD_Small_small.png" /></a></li>
							<li><a href="http://rohteam.net/noticias/news.php" alt="Renegades of Hell" target="_blank"><img src="assets/img/RoH_Original_small.png" /></a></li>
							<li><a href="http://www.teamtyl.com/" alt="Tierra y Libertad" target="_blank"><img src="assets/img/TyL_Original_small.png" /></a></li>
							<li><a href="http://www.myxgamers.com/" alt="xGamers" target="_blank"><img src="assets/img/xGs_Original_small.png" /></a></li>
						</ul>
						<ul class="nav pull-right">
							<li><a href="http://www.facebook.com/sc2mx" target="_blank"><img src="assets/img/facebook.png" /></a></li>
							<li><a href="https://twitter.com/#!/sc2_mx" target="_blank"><img src="assets/img/twitter.png" /></a></li>
						</ul>
					</div><!--/.nav-collapse -->
				</div><!--/.container -->
			</div><!--/.navbar-inner -->
		</div><!--/.navbar -->

		<div class="container3">
	    		<a class="brand" href="http://sc2mx.com" ><img id="logo" src="assets/img/logo.png" alt="SC2MX"></img></a>
			<div class="container2">
				<div class="navbar">
					<div class="navbar-inner">
						<div class="container">
							<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</a>
							<div class="nav-collapse">
								<ul class="nav" style="padding-left:110px;">
									<li><a href="http://sc2mx.com/forums/forum.php">Foros</a></li>
									<li><a href="http://wiki.sc2mx.com/index.php?title=P%C3%A1gina_principal">Wiki</a></li>
									<li><a href="#streams">Streams (Pronto)</a></li>
									<li><a href="http://lms2.com.mx/">LMS</a></li>
								</ul>
								<ul class="nav pull-right">
							              <li><a href="#about">About (Pronto)</a></li>
							              <li><a href="#contact">Contact (Pronto)</a></li>
								</ul>
							</div><!--/.nav-collapse -->
						</div><!--/.container -->
					</div><!--/.navbar-inner -->
				</div><!--/.navbar -->

				<!-- Example row of columns -->
				<div class="container">
				<div id="streams">
					<ul class="nav nav-pills">
					</ul>
					<div class="row">
						<div class="span8" id="stream_content"></div>
						<div class="span4" id="stream_chat"></div>
					</div>
				</div>


					<div class="row">
						<div class="span8">
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
								       	<center><a href="<?= $mainer->link ?>"><img src=<?= stripslashes($img_src1[2][0]);?> alt="" width="620" height="450"></a></center>
								        	<!-- <div class="carousel-caption">
								          	<h4><a href="<?= $mainer->link ?>"><?= $mainer->title; ?></a></h4>
								          	<p><?= substr(strip_tags($mainer->description),0,50); ?>... <a href="<?= $mainer->link ?>">Ver mas</a></p>
									</div> -->
								</div>
								<?php $a++;}; ?>
							</div>
							<a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>
							<a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
						</div>	</div>
						<div class="span4">
							<div class="row">
								<div class="span4">
									<!-- <h2>Proximos Eventos</h2> -->
<img src="assets/img/title_eventos.PNG" />
<iframe src="https://www.google.com/calendar/embed?showTitle=0&amp;showNav=0&amp;showDate=0&amp;showPrint=0&amp;showTabs=0&amp;showCalendars=0&amp;mode=AGENDA&amp;height=178&amp;wkst=1&amp;hl=es&amp;bgcolor=%23eeeeee&amp;src=fi6qgmpb0669gfecm97albjufk%40group.calendar.google.com&amp;color=%232f91c4&amp;ctz=America%2FMexico_City" style=" border-width:0 " width="300" height="178" frameborder="0" scrolling="no"></iframe>

								</div>
							</div>
							<div class="row">
							       <div class="span4">
									<script type="text/javascript"><!-- 
										google_ad_client = "ca-pub-1286901460565753";
										/* sc2mx_LargeBox */
										google_ad_slot = "0185557107";
										google_ad_width = 300;
										google_ad_height = 250;
										//-->
									</script>
									<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
								</div>
							</div>
						</div>
					</div>
	  
					<div class="row">
						<div class="span8">
							<div class="row">
								<div class="span4"><center>
									<script type="text/javascript"><!--
										google_ad_client = "ca-pub-1286901460565753";
										/* sc2mx_HalfBanner */
										google_ad_slot = "0282681073";
										google_ad_width = 234;
										google_ad_height = 60;
										//-->
									</script>
									<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
								</center></div>
								<div class="span4"><center>
									<script type="text/javascript"><!--
										google_ad_client = "ca-pub-1286901460565753";
										/* sc2mx_HalfBanner */
										google_ad_slot = "0282681073";
										google_ad_width = 234;
										google_ad_height = 60;
										//-->
									</script>
									<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
								</center></div>
							</div>
							<div class="row">
								<div class="span8">
									<div class="navbar">
										<div class="navbar-inner">
											<div class="container">
												<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
												<span class="icon-bar"></span>
												<span class="icon-bar"></span>
												<span class="icon-bar"></span>
												</a>
												<div class="nav-collapse">
													<ul class="nav"><li><a>Videos Estelares de la Comunidad</a></li></ul>
												</div><!--/.nav-collapse -->
											</div><!--/.container -->
										</div><!--/.navbar-inner -->
									</div><!--/.navbar -->
									<table width="100%">
										<tr align="center" vertical-align="top">
											<td><iframe width="205" height="150" src="http://www.youtube.com/embed/hM0n4vl_Jx0" frameborder="0" allowfullscreen></iframe></td>
											<td><iframe width="205" height="150" src="http://www.youtube.com/embed/ZXDeLR_Q1X0" frameborder="0" allowfullscreen></iframe></td>
											<td><iframe width="205" height="150" src="http://www.youtube.com/embed/2OcbgxXrUbI" frameborder="0" allowfullscreen></iframe></td>
										</tr>
									</table>

								</div>
							</div>


							<div class="row">
								<div class="span8">
									<div class="navbar">
										<div class="navbar-inner">
											<div class="container">
												<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
												<span class="icon-bar"></span>
												<span class="icon-bar"></span>
												<span class="icon-bar"></span>
												</a>
												<div class="nav-collapse">
													<ul class="nav"><li><a>Juegos y Videos &Eacute;picos</a></li></ul>
												</div><!--/.nav-collapse -->
											</div><!--/.container -->
										</div><!--/.navbar-inner -->
									</div><!--/.navbar -->
									<table width="100%">
										<tr align="center" vertical-align="top">
											<td><iframe width="205" height="150" src="http://www.youtube.com/embed/ytA9cA2b0K4" frameborder="0" allowfullscreen></iframe></td>
											<td><iframe width="205" height="150" src="http://www.youtube.com/embed/DISFKN8xNQg" frameborder="0" allowfullscreen></iframe></td>
											<td><iframe width="205" height="150" src="http://www.youtube.com/embed/UV3LIf5PGlg" frameborder="0" allowfullscreen></iframe></td>
										</tr>
									</table>

								</div>
							</div>
							<div class="row">
								<div class="span8">
									<div class="navbar">
										<div class="navbar-inner">
											<div class="container">
												<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
												<span class="icon-bar"></span>
												<span class="icon-bar"></span>
												<span class="icon-bar"></span>
												</a>
												<div class="nav-collapse">
													<ul class="nav"><li><a>&Uacute;ltimas Entradas</a></li></ul>
												</div><!--/.nav-collapse -->
											</div><!--/.container -->
										</div><!--/.navbar-inner -->
									</div><!--/.navbar -->

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

								<div class="span2" style="height:100px; width:180px;" >
									<center><h4><font size="3"><a href="<?= $feed->link; ?>"><?= $feed->title; ?></a></font></h4>
									<h5><!-- <font size="1">Iniciado por <?= $dc->creator;?><br/> -->
									Publicado: <?= date("Y-m-d", strtotime($feed->pubDate)); ?></font></h5></center>


								</div>

							<?php }; ?>
								</div>
							</div>
						</div>
					       <div class="span4">
							<div class="row">
								<div class="span4">
									<object width="100%" height="440" id="obj_1297019226277"><param name="movie" value="http://chatsc2mx.chatango.com/group"><param name="wmode" value="transparent"><param name="AllowScriptAccess" value="always"><param name="AllowNetworking" value="all"><param name="AllowFullScreen" value="true"><param name="flashvars" value="cid=1297019226277&amp;a=CCCCCC&amp;b=51&amp;f=43&amp;i=87&amp;k=999999&amp;l=FFFFFF&amp;m=FFFFFF&amp;o=30&amp;r=100&amp;s=1"><embed id="emb_1297019226277" src="http://chatsc2mx.chatango.com/group" width="100%" height="440" wmode="transparent" allowscriptaccess="always" allownetworking="all" type="application/x-shockwave-flash" allowfullscreen="true" flashvars="cid=1297019226277&amp;a=CCCCCC&amp;b=51&amp;f=43&amp;i=87&amp;k=999999&amp;l=FFFFFF&amp;m=FFFFFF&amp;o=30&amp;r=100&amp;s=1"></object>
								</div>
							</div>
							<div class="row">
								<div class="span4"><p></p>
									<center><p><img src="assets/img/ranking.PNG" /></p></center>
									<div class="tabbable" style="margin-bottom: 18px;">
									<ul class="nav nav-tabs">
								       <li class="active"><a href="#tab1" data-toggle="tab"><img src="assets/img/title_ligcamp.png" /></a></li>
								       <li><a href="#tab2" data-toggle="tab"><img src="assets/img/title_ligclan.png" /></a></li>
							              </ul>
								       <div class="tab-content" style="padding-bottom: 9px; border-bottom: 1px solid #ddd;">
								       <div class="tab-pane active" id="tab1">
<table class="table">
									       <thead>
									          <tr>
									            <th>#</th>
									            <th>Nombre</th>
									            <th>W/L</th>
									            <th>DIF</th>
									            <th>PTS.</th>
									          </tr>
									        </thead>
									        <tbody>
								                 <tr>
									            <td>1</td>
									            <td>LgN.JimRising</td>
									            <td>29/11</td>
									            <td>18</td>
									            <td>27</td>
									          </tr>
								                 <tr>
									            <td>2</td>
									            <td>Isurus.Dark</td>
									            <td>23/17</td>
									            <td>6</td>
									            <td>21</td>
									          </tr>
								                 <tr>
									            <td>3</td>
									            <td>RoH.b0rreee</td>
									            <td>19/21</td>
									            <td>-2</td>
									            <td>11</td>
									          </tr>
								                 <tr>
									            <td>4</td>
									            <td>RoH.Kieds</td>
									            <td>18/22</td>
									            <td>-4</td>
									            <td>9</td>
									          </tr>
								                 <tr>
									            <td>5</td>
									            <td>RoH.Kuma</td>
									            <td>16/24</td>
									            <td>-8</td>
									            <td>9</td>
									          </tr>
								                 <tr>
									            <td>6</td>
									            <td>RoH.Gdlk</td>
									            <td>15/25</td>
									            <td>-10</td>
									            <td>8</td>
									          </tr>
        </tbody>
      </table>	
<h5>Top Players (JG)</h5>
<ol>
<li>29 - LgN.JimRising</li>
<li>23 - Isurus.Dark</li>
<li>19 - RoH.Borreee</li>
</ol>

								       </div>
								       <div class="tab-pane" id="tab2">
									       <table class="table">
									       <thead>
									          <tr>
									            <th>#</th>
									            <th>Clan</th>
									            <th>SJ</th>
									            <th>SG</th>
									            <th>SP</th>
									          </tr>
									        </thead>
									        <tbody>
								                 <tr>
									            <td>1</td>
									            <td>RoH</td>
									            <td>7</td>
									            <td>6</td>
									            <td>1</td>
									          </tr>
								                 <tr>
									            <td>2</td>
									            <td>GrB</td>
									            <td>5</td>
									            <td>3</td>
									            <td>2</td>
									          </tr>
								                 <tr>
									            <td>3</td>
									            <td>FwD</td>
									            <td>3</td>
									            <td>1</td>
									            <td>2</td>
									          </tr>
								                 <tr>
									            <td>4</td>
									            <td>iT</td>
									            <td>3</td>
									            <td>1</td>
									            <td>2</td>
									          </tr>
								                 <tr>
									            <td>5</td>
									            <td>Rg</td>
									            <td>3</td>
									            <td>1</td>
									            <td>2</td>
									          </tr>
								                 <tr>
									            <td>6</td>
									            <td>xGs</td>
									            <td>3</td>
									            <td>1</td>
									            <td>2</td>
									          </tr>
								                 <tr>
									            <td>7</td>
									            <td>TyL</td>
									            <td>2</td>
									            <td>0</td>
									            <td>2</td>
									          </tr>
								                 <tr>
									            <td>8</td>
									            <td>LgN</td>
									            <td>0</td>
									            <td>0</td>
									            <td>0</td>
									          </tr>
        </tbody>
      </table>	
<h5>Top Players (JG)</h5>
<ol>
<li>11 - GrB.Kuma</li>
<li>10 - RoH.LoWbOrreee</li>
<li>05 - RoH.Kieds</li>
</ol>
							       </div>
								       </div>
									</div> <!-- /tabbable -->
								</div>
							</div>
					       </div>
					</div>
				</div>
			</div>
		</div>

      <hr>
      <footer>
	<table>
	<tr>
		<td><img src="http://sc2mx.com/forums/images/styles/RoyalFlush/style/logo.gif" /></td>
		<td><p>&copy; SC2MX 2010 - 2013, Derechos Reservados.</p>
		    <p>Las siguientes son marcas o servicios de SC2MX o sus entidades y solo se pueden usar con su permiso: Liga de Clanes SC2MX, Liga de Campeones SC2MX, SC2MX Wiki, el logo del Jaguar, y colores y uniformes. El contenido intelectual de Blizzard incluye marcas, logos, juegos, personajes de juegos, imagenes, video, texto, y texto asociado con las franquicias de Warcraft, Diablo, y StarCraft<a href="http://anongallery.org/img/4/1/i-have-no-idea-what-im-doing-dog.jpg">.</a></p></td>
	</tr>
	</table>
      </footer>

	</div> <!-- /container -->


    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap-transition.js"></script>
    <script src="../assets/js/bootstrap-alert.js"></script>
    <script src="../assets/js/bootstrap-modal.js"></script>
    <script src="../assets/js/bootstrap-dropdown.js"></script>
    <script src="../assets/js/bootstrap-scrollspy.js"></script>
    <script src="../assets/js/bootstrap-tab.js"></script>
    <script src="../assets/js/bootstrap-tooltip.js"></script>
    <script src="../assets/js/bootstrap-popover.js"></script>
    <script src="../assets/js/bootstrap-button.js"></script>
    <script src="../assets/js/bootstrap-collapse.js"></script>
    <script src="../assets/js/bootstrap-carousel.js"></script>
    <script src="../assets/js/bootstrap-typeahead.js"></script>
    <script src="../assets/js/core.js"></script>

</body>
</html>
