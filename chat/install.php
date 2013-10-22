<?php
require 'util/pdo.php';

$pdo = PDOConnection::getInstance();

$user_add = array(
	'status' => 1,
	'typing' => 0,
	'name' => 'Administrador',
	'level' => 1,
	'email' => 'admin@admin.com',
	'photo' => NULL,
	'user' => 'administrador',
	'password' => md5('123456'),
	'time' => 0
);

$stmt = $pdo->prepare('SELECT COUNT(*) FROM user WHERE user = :user');
$stmt->bindValue('user', $user_add['user']);
$stmt->execute();

if($stmt->fetchColumn() == 0){

	$pdo->prepare('INSERT INTO user (
		status, typing, level, name, email, photo, user, password, register_date, time
	) VALUES (
		:status, :typing, :level, :name, :email, :photo, :user, :password, NOW(), :time
	)')->execute($user_add);
	
}

?>