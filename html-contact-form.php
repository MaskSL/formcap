<?php
$your_email ='ahmed@gmail.com';// <<=== update to your email address

session_start();
$errors = '';
$name = '';
$visitor_email = '';
$user_message = '';
$number = '';

if(isset($_POST['submit']))
{

	$name = $_POST['name'];
	$visitor_email = $_POST['email'];
	$user_message = $_POST['message'];
	$number = $_POST['number'];

	///------------Do Validations-------------
	if(empty($name))
	{
		$errors .= "\n Name is a required field. ";
	}

	if(empty($visitor_email))
	{
		$errors .= "\n Email is a required field. ";



	}
	if(strlen($number)<9){
		$errors .= "\n Phone number should be 10 digits long ";
	}

	if (!filter_var($visitor_email, FILTER_VALIDATE_EMAIL))
		{
			$errors .= "\n Invalid Email ";
		}

	if(empty($number))
	{
		$errors .= "\n number is a required field. ";

	}

	if(empty($user_message))
	{
		$errors .= "\n Message is a required field. ";

	}

	if(empty($_SESSION['6_letters_code'] ) ||
	  strcasecmp($_SESSION['6_letters_code'], $_POST['6_letters_code']) != 0)
	{
	//Note: the captcha code is compared case insensitively.
	//if you want case sensitive match, update the check above to
	// strcmp()
		$errors .= "\n The captcha code does not match!";
	}

	if(empty($errors))
	{
		// //send the email
		// $to = $your_email;
		// $subject="New form submission";
		// $from = $your_email;
		// $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
		//
		// $body = "A user  $name submitted the contact form:\n".
		// "Name: $name\n".
		// "Email: $visitor_email \n".
		// "Message: \n ".
		// "$user_message\n".
		// "IP: $ip\n";
		//
		// $headers = "From: $from \r\n";
		// $headers .= "Reply-To: $visitor_email \r\n";
		//
		// mail($to, $subject, $body,$headers);

		header('Location: thank-you.html');
	}
}


?>

<html>
<head>
</head>
<body>
<?php
if(!empty($errors)){
echo "<p class='err'>".nl2br($errors)."</p>";
}
?>
<div id='contact_form_errorloc'></div>
<form method="POST" name="contact_form"
action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
<p>
<label for='name'>Name: </label><br>
<input type="text" name="name" value='<?php echo htmlentities($name) ?>'>
</p>
<p>
<label for='email'>Email: </label><br>
<input type="text" name="email" value='<?php echo htmlentities($visitor_email) ?>'>
</p>
<p>
<label for='number'>Number: </label><br>
<input type="text" name="number" value='<?php echo htmlentities($number) ?>'>
</p>
<p>
<label for='message'>Message:</label> <br>
<textarea name="message" rows=8 cols=30><?php echo htmlentities($user_message) ?></textarea>
</p>
<p>
<img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg' ><br>
<label for='message'>Enter the code above here :</label><br>
<input id="6_letters_code" name="6_letters_code" type="text"><br>

</p>
<input type="submit" value="Submit" name='submit'>
</form>

<script language='JavaScript' type='text/javascript'>
function refreshCaptcha()
{
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>
</body>
</html>
