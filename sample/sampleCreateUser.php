<head>
	<meta charset="utf-8">
</head>
<pre>
<?php
require __DIR__ . '/../vendor/autoload.php';

use Source\Models\User;

$user = new User();
$user->IDTYPE = 2;
$user->FNAME = "Danilo";
$user->LNAME = "Almeida";
$user->PASSWORD = "12345";
$user->EMAIL = "danilo8almeida@hotmail.com";
$user->save();

if (!$user->save()) {
    echo "<h3>Ooops: {$user->fail()->getMessage()}</h3>";
}
echo "<h2>Usuário</h2>";
var_dump($user->data());
?>
</pre>