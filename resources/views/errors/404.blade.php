<!DOCTYPE html>
<html lang="en">
<head>
	<title>404 Page Not Found - Anyware Trucks</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link href="{{asset('/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('/css/app.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('/css/errors.css')}}" rel="stylesheet" type="text/css">
</head>
<body>


	<div class="wrapper-page">
		<div class="text-center">
			<h1>404!</h1>
			<h2>Sorry, page not found</h2><br><br>
			<a class="btn btn-primary btn-square" href="{{route('dashboard')}}"><i class="fa fa-angle-left"></i> Back to Dashboard</a>
		</div>
	</div>

</body>
</html>