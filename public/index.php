<?php
/**
 * Description of what this module (or file) is doing.
 *
 * @author   Lucas Roe <lroe2930@gmail.com>
 */

 require '../vendor/autoload.php';
?>
<h1>Hello World!</h1>


<?php
$host = getenv('DATABASE_HOST');
$user = getenv('DATABASE_USER');
$pass = getenv('DATABASE_PASS');
$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}
echo "Connected to MySQL successfully!";
?>