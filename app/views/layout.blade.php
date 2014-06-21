<!DOCTYPE html>
<html lang="en-us">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>
		Musicwhore.org Administration
		@yield('page_title')
	</title>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="{{ VIGILANTMEDIA_CDN_BASE_URI }}/web/css/chosen.min.css" type="text/css" />
	<link rel="stylesheet" href="/css/typography.css" type="text/css" media="all" />
	<link rel="stylesheet" href="/css/layout.css" type="text/css" media="screen, projection" />
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" type="text/css" />
	<link href='http://fonts.googleapis.com/css?family=Merriweather&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Merriweather+Sans&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="{{ VIGILANTMEDIA_CDN_BASE_URI }}/web/js/chosen.jquery.min.js"></script>
</head>
<body>
	<div class="container">
		<header class="row">
			<div class="hidden-xs col-md-12">
				<h1 class="site-title">
					Musicwhore.org
					<small>Administration</small>
				</h1>
			</div>

			<nav class="navbar navbar-inverse col-md-12" role="navigation">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-nav">
							<a class="sr-only" href="#content">Skip to content</a>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<div class="visible-xs">
							<a href="{{ route( 'admin.home' ) }}" class="navbar-brand">Musicwhore.org Administration</a>
						</div>
					</div>
					<div id="bs-nav" class="collapse navbar-collapse">
						<ul class="nav navbar-nav">
							<li><a href="{{ route('admin.home') }}">Home</a></li>
							@if ( Auth::check() )
							<li><a href="{{ route('auth.logout') }}">Logout</a></li>
							@else
							<li><a href="{{ route('auth.login') }}">Login</a></li>
							@endif
						</ul>
					</div>
				</div>
			</nav>
		</header>

		<div class="row">
			<div class="col-md-12">
				@yield('section_header')

				@yield('section_label')

				@yield('section_sublabel')

				@if ( Session::get('message') != '')
				<div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					{{ Session::get('message') }}
				</div>
				@endif

				@if ( Session::get('error') != '')
				<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					{{ Session::get('error') }}
				</div>
				@endif

				<div class="row">
					@yield('content')

					@yield('sidebar')
				</div>
			</div>
		</div>
	</div>
</body>
</html>