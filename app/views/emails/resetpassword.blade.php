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
                <p><strong> Your Password: </strong> {{ $password }}</p>
                <p>Click on the link below to reset your password</p>
                {{ link_to_route('confirmforgetpassword', "Reset Password", array($code, $user_id), array()); }}
	</body>
</html>