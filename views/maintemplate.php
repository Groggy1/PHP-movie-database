<?php
$url = $viewModel -> get('urlValues');
/*
 echo '<pre>';
 var_dump($url);
 echo '</pre>';
 */
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title><?php echo $viewModel -> get('pageTitle'); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="<?php echo URL; ?>public/css/bootstrap.css" rel="stylesheet" />
		<link href='http://fonts.googleapis.com/css?family=Cinzel:700|Archivo+Narrow:400,700' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<div class="container-fluid">
			<!-- Fixed navbar -->
			<div class="navbar navbar-inverse">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo URL; ?>">FilmDB</a>
				</div>
				<div class="navbar-collapse collapse"><!--.nav-collapse -->
					<ul class="nav navbar-nav">
						<li class="<?php echo($url['controller'] == "home" ? ' active' : ''); ?>">
							<a href="<?php echo URL; ?>">Hem</a>
						</li>
						<li class="dropdown<?php echo($url['controller'] == "movie" ? ' active' : ''); ?>">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Filmer <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li>
									<a href="<?php echo URL . "movie"; ?>">Alla</a>
								</li>
								<li>
									<a href="<?php echo URL; ?>movie/wall">Alla med posters</a>
								</li>
								<li role="presentation" class="divider"></li>
								<li>
									<a href="<?php echo URL; ?>movie/stat">Statistik</a>
								</li>
								<li role="presentation" class="divider"></li>
								<li>
									<a href="<?php echo URL; ?>movie/add">Lägg till en film</a>
								</li>
								<li>
									<a href="<?php echo URL; ?>movie/queue">Köa en film</a>
								</li>
							</ul>
						</li>
						<li class="dropdown<?php echo($url['controller'] == "user" ? ' active' : ''); ?>">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Användare <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li>
									<a href="<?php echo URL; ?>user/recomended">Rekomendationer</a>
								</li>
								<li>
									<a href="<?php echo URL; ?>user/towatch">Filmer att se</a>
								</li>
							</ul>
						</li>
						<li class="dropdown<?php echo($url['controller'] == "series" ? ' active' : ''); ?>">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Filmserier <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li>
									<a href="<?php echo URL; ?>series/index">Alla filmserier</a>
								</li>
								<li>
									<a href="<?php echo URL; ?>series/create">Skapa filmserie</a>
								</li>
							</ul>
						</li>
					</ul>
					<?php
					//Session::init();
					//if(Session::get('user_logged_in')) :
					?>
					<ul class="nav navbar-nav navbar-right">
						<li>
							<a href="<?php echo URL.'login/logout'?>">Logga ut</a>
						</li>
					</ul>
					<?php
					//endif;
					?>
				</div><!--/.nav-collapse -->
			</div><!--/Fixed navbar-->
			<?php
			require ($this -> viewFile);
	 		?>
	 		<div>
	 			<?php
				echo 'Sidan tog ' . (MICROTIME(TRUE) - starting_time_measure) . ' sekunder att ladda';
	 			?>
	 		</div>
	 	</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="<?php echo URL; ?>public/js/bootstrap.js"></script>
	</body>
</html>
