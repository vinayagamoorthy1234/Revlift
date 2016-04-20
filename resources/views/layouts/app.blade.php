<!DOCTYPE html>
<html lang="en">
	<head>
		<title>{{isset($pageTitle) ? $pageTitle . ' | ' : ''}} Anyware Trucks</title>
		{{-- META INFORMATION --}}
		<meta charset="UTF-8">
		<meta name="description" content="Anyware is a private trucking management system."> 
		<meta name="viewport" content="width=device-width, initial-scale=1">
		{{-- ADD GOOGLE SITE VERIFICATION META TAG HERE --}}
		<meta name="google" content="nositelinkssearchbox" />
		<meta name="author" content="Revlift Technologies, LLC" />
		<meta name="robots" content="noindex,nofollow">

		{{-- STYLESHEETS --}}
		<link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link href="/css/app.css" rel="stylesheet" type="text/css">
		<link href="/css/login.css" rel="stylesheet" type="text/css">
		<?php if(isset($styles)) echo $styles; ?>

		{{-- SCRIPTS --}}
		<script src="/js/app.js"></script>
		<?php if(isset($scripts)) echo $scripts; ?>
	</head>
	<body>
		<div id="main">
    	@yield('content')
  	</div>
{{-- 		<div class="overlay">
			<div class="content">
				<div class="title">Welcome</div>
			</div>
		</div> --}}
	</body>
</html>
