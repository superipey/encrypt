<?php $allowedCiphers = ['aes-128-cbc','aes-128-cfb','aes-128-ctr','aes-192-cbc','aes-256-cbc','bf-cbc','camellia-128-cbc','camellia-192-cbc','cast5-cbc','cast5-cfb','des-cbc','des-ofb','gost89','idea-cbc','idea-cfb','rc2-cbc','seed-cbc','seed-cfb']; ?>
<html>
<head>
	<title>Encrypting & Decrypting with OpenSSL Example</title>
	<meta charset="UTF-8">
	<meta name="description" content="Encrypting & Decrypting with OpenSSL for Pemrograman Web Dinamis Kelas XII">
	<meta name="keywords" content="PHP,PWD,encrypting,decrypting,openssl">
	<meta name="author" content="Ferry Stephanus Suwita">
	<style>
		.right {
			position: absolute;
			right: 20px;
			top: 20;
			height: 400px;
			overflow-x: hidden;
			overflow-y: scroll;
			margin-right: 10px;
			width: 300px;
		}
		
		table { border-collapse: collapse; }
		
		.right td {
			border: 1px solid #000;
			padding: 10px 5px;
		}
		
		.green {
			background-color: lime;
		}
		
		.text-center { text-align: center; }
	</style>
</head>
<body>
	<form action="" method="post">
		Choose Cipher Method
		<select name="cipher_method">
		<?php foreach ($allowedCiphers as $cipher): ?>
			<option value="<?php echo $cipher ?>" <?php echo (@$_POST['cipher_method'] == $cipher) ? 'selected' : '' ?>><?php echo $cipher ?></option>
		<?php endforeach; ?>
		</select>
		<br><br>
		<input type="text" name="salt" placeholder="Input Salt" value="<?php echo @$_POST['salt'] ?>" />
		<br><br>
		<input type="text" name="plain" placeholder="Input Plain Text" />
		<input type="submit" />
		<br><br>
		<input type="text" name="cipher" placeholder="Input Cipher Text" />
		<input type="submit" />
	</form>

<?php
	echo '<div class="right">';
	echo '<table>';
	echo '<tr><th>Cipher Method</th><th>Salt Length</th></tr>';
	$modes = openssl_get_cipher_methods();
	foreach ($modes as $row) {
		$cipher_length = openssl_cipher_iv_length($row);
		if ($cipher_length == 0 || $row{0} == strtoupper($row{0})) continue;
		echo '<tr ' . (in_array($row, $allowedCiphers) ? 'class="green"': '') . '>';
		echo '<td>' . $row . '</td>';
		echo '<td class="text-center">' . $cipher_length . '</td>';
		echo '</tr>';
	}
	echo '</table>';
	echo "</div>";
			
	$plain_text 		= @$_POST['plain'];
	$cipher_input 		= @$_POST['cipher'];
	$cipher_method 		= @$_POST['cipher_method'];
	$salt 				= @$_POST['salt'];
	
	if (! empty($cipher_method) && ! empty($salt)) {
		$ivlen = openssl_cipher_iv_length($cipher_method);		
		if (strlen($salt) != $ivlen) {
			echo 'Salt harus ' . $ivlen . ' karakter. Salt yang anda masukan baru ' . strlen($salt) . ' karakter';
			exit;
		}
		
		if (! empty($plain_text)) {
			$cipher = openssl_encrypt($plain_text, $cipher_method, $salt, 0, $salt);
			
			echo "Cipher Text : " . $cipher . "<br />\n";
		}

		if (! empty($cipher_input)) {
			$plain = openssl_decrypt($cipher_input, $cipher_method, $salt, 0, $salt);
			
			echo "Plain Text : " . $plain . "<br />\n";
		}
	}
?>
</body>
</html>
