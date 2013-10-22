<?php
require '../util/header.php';
require 'includes.php';

$session = new Session();
$session->checkSession('user');

$pdo = PDOConnection::getInstance();

/* Lista atendentes */
$stmt = $pdo->prepare('SELECT * FROM user WHERE status != :status ORDER BY name ASC');
$stmt->bindValue('status', 0);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$json = array('users' => $users);

print json_encode($json);
?>