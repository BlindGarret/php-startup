<?php
/**
 * Description of what this module (or file) is doing.
 *
 * @author   Lucas Roe <lroe2930@gmail.com>
 */

 require __DIR__ . '/../vendor/autoload.php';
?>
<h1>Hello World!</h1>


<?php
$dsn = getenv('DATABASE_DSN');
$user = getenv('DATABASE_USER');
$pass = getenv('DATABASE_PASS');
$pdo = new PDO($dsn, $user, $pass);

$stm = $pdo->query("SELECT VERSION()");

$version = $stm->fetch();

echo $version[0] . PHP_EOL;
?>