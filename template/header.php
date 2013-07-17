<!DOCTYPE HTML>
<html>
	<head>
		<title>FilmDB - <?php echo $sitetitle; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<link href="css/bootstrap.css" rel="stylesheet" />
		<link href="css/style.css" rel="stylesheet" />
		<link href="css/bootstrap-responsive.css" rel="stylesheet" />
	</head>
	<body>
		<?php
		$filname = pathinfo($_SERVER['PHP_SELF']);
		$filname = $filname['basename'];
	?>
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="brand" href="./index.php">FilmDB</a>
					<div class="nav-collapse collapse">
						<ul class="nav">
							<li class="
							<?php
							if($filname == "index.php")
								echo 'active'
								?>
								">
								<a href="index.php">Hem</a>
							</li>
							<li class="dropdown 
							<?php
							if($filname == "allmovies.php" || $filname == "dispmovie.php" || $filname == "moviewall.php" || $filname == "search.php" || $filname == "towatch.php"){
								echo 'active';
							}
							?>
							" id="accountmenu">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#">Visa film<b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="allmovies.php">Alla filmer</a></li>
									<li><a href="moviewall.php">Alla filmer med posters</a></li>
									<li><a href="search.php">S&ouml;k p&aring; &aring;r/genre</a></li>
									<li><a href="towatch.php">Filmer att se</a></li>
                            	</ul>
                            </li>
                            <li class="dropdown 
                            <?php
							if($filname == "queue.php" || $filname == "addqueue.php" || $filname == "link.php" || $filname == "manproxy.php" || $filname == "imdbproxy.php"){
								echo 'active';
							}
							?>
                            " id="accountmenu">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#">Lägg till film<b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="link.php">L&auml;gg till film</a></li>
									<li><a href="queue.php">K&ouml;a film</a></li>
                            	</ul>
                            </li>
                            <li class="
                            <?php
							if ($filname == "news.php" || $filname == "addnews.php") {
								echo 'active';
							}
                            ?>
                            ">
                            <a href="news.php">Nyheter</a>
							</li>
							<li class="
							<?php
							if ($filname == "stats.php") {
								echo 'active';
							}
							?>
							">
							<a href="stats.php">Statistik</a>
							</li>
							<li>
							<a href="<?php echo $filname.'?logout'; ?>">Logga ut</a>
							</li>
						</ul>
					</div><!-- nav-collapse collapse -->
				</div><!-- container -->
			</div><!-- navbar-inner -->
		</div><!-- navbar navbar-inverse navbar-fixed-top -->
		<div class="container">