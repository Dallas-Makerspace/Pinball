<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Welcome to Pinball Highscore!!</h2>

		<p>
			You were signed up by the admin of this website.  
		</p>
                <p><strong> User Name: </strong> {{ $username }}</p>
                <p><strong> Password: </strong> {{ $password }}</p>
                <p><strong> Login Url : <strong>{{ link_to_route('getSignIn', "Login", array(), array()); }}</strong>

	</body>
</html>