<!DOCTYPE html>
<html>
<body>
<p style="font-family:monospace">
<?php
function mpint($data) {
  $len = strlen($data);
  $format='%08x%s';
  if (ord($data[0]) & 0x80) {
    $len++;
    $format='%08x00%s';
  }
  return hex2bin(sprintf($format, $len, bin2hex($data)));
}
$pub_key=openssl_pkey_get_details(openssl_pkey_get_public($_SERVER['SSL_CLIENT_CERT']));
printf('ssh-rsa %s', base64_encode(mpint('ssh-rsa').mpint($pub_key['rsa']['e']).mpint($pub_key['rsa']['n'])));
?>
</p>
</body>
</html>
