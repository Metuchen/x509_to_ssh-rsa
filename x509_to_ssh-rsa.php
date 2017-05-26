<!DOCTYPE html>
<html>
<body>
Fork this code on <a href='https://github.com/Metuchen/x509_to_ssh-rsa'>GitHub</a>
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
  if (empty($_SERVER['SSL_CLIENT_CERT'])) print ("You must present a client certificate for it to be useful to you.\n");
  else {
    $pub_key=openssl_pkey_get_details(openssl_pkey_get_public($_SERVER['SSL_CLIENT_CERT']));
    if (! isset($pub_key['rsa'])) print ("Oops...I can't find an RSA key.  Feel free to fork us on GitHub if you feel like implementing something else (it shouldn't be too hard.)\n");
    else {
      printf('<p style="font-family:monospace">ssh-rsa %s</p>', base64_encode(mpint('ssh-rsa').mpint($pub_key['rsa']['e']).mpint($pub_key['rsa']['n'])));
    }
  }
?>
</body>
</html>
