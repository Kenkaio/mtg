<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Matega</title>
	<link href="public/assets/Lumino_Template/lumino/css/bootstrap.min.css" rel="stylesheet">
	<link href="public/assets/Lumino_Template/lumino/css/font-awesome.min.css" rel="stylesheet">
	<link href="public/assets/Lumino_Template/lumino/css/datepicker3.css" rel="stylesheet">
	<link href="public/assets/Lumino_Template/lumino/css/styles.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="public/css/dashboard.css">
	<link rel="stylesheet" type="text/css" href="public/css/decks.css">
	<link rel="stylesheet" type="text/css" href="public/css/list.css">


	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span></button>
				<a class="navbar-brand" href="#"><span>Matega </span></a>
				<ul class="nav navbar-top-links navbar-right">
					<li class="dropdown"><a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
						<em class="fa fa-envelope"></em><span class="label label-danger">15</span>
					</a>
						<ul class="dropdown-menu dropdown-messages">
							<li>
								<div class="dropdown-messages-box"><a href="profile.html" class="pull-left">
									<img alt="image" class="img-circle" src="http://placehold.it/40/30a5ff/fff">
									</a>
									<div class="message-body"><small class="pull-right">3 mins ago</small>
										<a href="#"><strong>John Doe</strong> commented on <strong>your photo</strong>.</a>
									<br /><small class="text-muted">1:24 pm - 25/03/2015</small></div>
								</div>
							</li>
							<li class="divider"></li>
							<li>
								<div class="dropdown-messages-box"><a href="profile.html" class="pull-left">
									<img alt="image" class="img-circle" src="http://placehold.it/40/30a5ff/fff">
									</a>
									<div class="message-body"><small class="pull-right">1 hour ago</small>
										<a href="#">New message from <strong>Jane Doe</strong>.</a>
									<br /><small class="text-muted">12:27 pm - 25/03/2015</small></div>
								</div>
							</li>
							<li class="divider"></li>
							<li>
								<div class="all-button"><a href="#">
									<em class="fa fa-inbox"></em> <strong>All Messages</strong>
								</a></div>
							</li>
						</ul>
					</li>
					<li class="dropdown"><a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
						<em class="fa fa-bell"></em><span class="label label-info">5</span>
					</a>
						<ul class="dropdown-menu dropdown-alerts">
							<li><a href="#">
								<div><em class="fa fa-envelope"></em> 1 New Message
									<span class="pull-right text-muted small">3 mins ago</span></div>
							</a></li>
							<li class="divider"></li>
							<li><a href="#">
								<div><em class="fa fa-heart"></em> 12 New Likes
									<span class="pull-right text-muted small">4 mins ago</span></div>
							</a></li>
							<li class="divider"></li>
							<li><a href="#">
								<div><em class="fa fa-user"></em> 5 New Followers
									<span class="pull-right text-muted small">4 mins ago</span></div>
							</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div><!-- /.container-fluid -->
	</nav>
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<div class="profile-sidebar">
			<div class="profile-userpic">
				<img src="http://placehold.it/50/30a5ff/fff" class="img-responsive" alt="">
			</div>
			<div class="profile-usertitle">
				<div class="profile-usertitle-name"><?= $pseudo->pseudo ?></div>
				<div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="divider"></div>
		<ul class="nav menu" id="menuDashboard">
			<li class="active" id="dash"><a href="index.php?action=connected"><em class="fa fa-dashboard">&nbsp;</em> Dashboard</a></li>
			<li id="decks"><a href="index.php?action=viewDecks"><em class="fa fa-gamepad">&nbsp;</em> Decks</a></li>
			<li id="vs"><a href="#"><em class="fa fa-bolt">&nbsp;</em> VS</a></li>
			<li id="stats"><a href="#"><em class="fa fa-bar-chart">&nbsp;</em> Stats</a></li>
			<li id="members"><a href="#"><em class="fa fa-users">&nbsp;</em> Members</a></li>
			<li id="profil"><a href="#"><em class="fa fa-cogs">&nbsp;</em> My profil</a></li>
			<li><a href="index.php?action=disconnect"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>
		</ul>
	</div><!--/.sidebar-->

	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">

		<div>
			<?= $contentAdmin ?>
		</div><!--/.row-->
	</div>	<!--/.main-->

	<script src="public/assets/Lumino_Template/lumino/js/jquery-1.11.1.min.js"></script>
	<script src="public/assets/Lumino_Template/lumino/js/bootstrap.min.js"></script>
	<script src="public/assets/Lumino_Template/lumino/js/chart.min.js"></script>
	<script src="public/assets/Lumino_Template/lumino/js/chart-data.js"></script>
	<script src="public/assets/Lumino_Template/lumino/js/easypiechart.js"></script>
	<script src="public/assets/Lumino_Template/lumino/js/easypiechart-data.js"></script>
	<script src="public/assets/Lumino_Template/lumino/js/bootstrap-datepicker.js"></script>
	<script src="public/assets/Lumino_Template/lumino/js/custom.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
	<script src="public/js/dashboard.js"></script>
	<script src="public/js/decks.js"></script>
	<script src="public/js/list.js"></script>

</body>
</html>
