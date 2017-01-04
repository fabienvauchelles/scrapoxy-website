<?php
	include_once('../slack-invite.config.inc.php');

	$email = trim($_POST['email']);
	if ($email == "") {
		echo('No email specified');
		http_response_code(400);
		exit();
	}

	$url = 'https://' . $team . '.slack.com/api/users.admin.invite?t=1';
        $data = array(
		'email' => $email,
		'channels' => '',
		'first_name' => '',
		'token' => $token,
		'set_active' => 'true',
		'_attempts' => '1',
	);

	$options = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($data)
		)
	);

	$context  = stream_context_create($options);

	$result = file_get_contents($url, false, $context);
	if ($result === FALSE) {
		echo('Cannot send an invite to: ' . $email);
		http_response_code(400);
		exit();
	}

	header('Location: /');
?>
