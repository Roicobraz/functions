<!doctype html>
<html lang="fr-FR">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Double range</title>
		<link rel='stylesheet' href='styles.css'/>
		<script src="script.js"></script>
	</head>
	<body>
		<?php
		require_once('double_range.php');
		$args = array(
			'min' => 328,
			'max' => 723,
			'id1' => 'id1',
			'id2' => 'id2'
		);
		echo(in_double_range($args));
		?>
	</body>
</html>