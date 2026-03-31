<?php
$host = 'localhost';
$db = 'academico';
$user = 'Aluno';
$pass = '12345';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
	die('Erro na conexão: ' . $conn->connect_error);
}
// CREATE USER 'Aluno'@'localhost' IDENTIFIED VIA mysql_native_password USING '***';GRANT ALL PRIVILEGES ON *.* TO 'Aluno'@'localhost' REQUIRE NONE WITH GRANT OPTION MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;

?>
