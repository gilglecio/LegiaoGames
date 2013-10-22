/*
Created		15/03/2010
Modified	23/08/2010
Project		Atendimento Online
Model		
Company		
Author		Hédi Carlos Minin	
Version		1.0.0
Database	mySQL 5 
*/


drop table IF EXISTS message;
drop table IF EXISTS user;
drop table IF EXISTS client;
drop table IF EXISTS message_history;
drop table IF EXISTS client_history;


Create table client (
	client_id Int UNSIGNED NOT NULL AUTO_INCREMENT,
	user_id Int UNSIGNED NOT NULL DEFAULT 0,
	status Tinyint UNSIGNED NOT NULL DEFAULT 1,
	typing Tinyint UNSIGNED NOT NULL DEFAULT 0,
	name Varchar(255) NOT NULL,
	email Varchar(255) NOT NULL,
	ip_address Varchar(32) NOT NULL,
	call_date Datetime NOT NULL,
	start_call_date Datetime NULL DEFAULT NULL,
	time Varchar(32) NOT NULL,
 Primary Key (client_id)) ENGINE = MyISAM;

Create table user (
	user_id Int UNSIGNED NOT NULL AUTO_INCREMENT,
	status Tinyint UNSIGNED NOT NULL DEFAULT 1,
	typing Tinyint UNSIGNED NOT NULL DEFAULT 0,
	level Tinyint UNSIGNED NOT NULL DEFAULT 1,
	name Varchar(255) NOT NULL,
	email Varchar(255) NOT NULL,
	photo Varchar(32),
	user Varchar(32) NOT NULL,
	password Varchar(32) NOT NULL,
	register_date Datetime NOT NULL,
	time Varchar(32) NOT NULL,
 Primary Key (user_id)) ENGINE = MyISAM;

Create table message (
	message_id Int UNSIGNED NOT NULL AUTO_INCREMENT,
	client_id Int UNSIGNED NOT NULL,
	user_id Int UNSIGNED NOT NULL,
	type Tinyint UNSIGNED NOT NULL DEFAULT 0,
	status Tinyint UNSIGNED NOT NULL DEFAULT 1,
	message Text NOT NULL,
	post_date Datetime NOT NULL,
 Primary Key (message_id)) ENGINE = MyISAM;

Create table client_history (
	client_id Int UNSIGNED NOT NULL,
	user_id Int UNSIGNED NOT NULL DEFAULT 0,
	status Tinyint UNSIGNED NOT NULL DEFAULT 1,
	typing Tinyint UNSIGNED NOT NULL DEFAULT 0,
	name Varchar(255) NOT NULL,
	email Varchar(255) NOT NULL,
	ip_address Varchar(32) NOT NULL,
	call_date Datetime NOT NULL,
	start_call_date Datetime NULL DEFAULT NULL,
	time Varchar(32) NOT NULL,
 Primary Key (client_id)) ENGINE = MyISAM;

Create table message_history (
	message_id Int UNSIGNED NOT NULL AUTO_INCREMENT,
	client_id Int UNSIGNED NOT NULL,
	user_id Int UNSIGNED NOT NULL,
	type Tinyint UNSIGNED NOT NULL DEFAULT 0,
	status Tinyint UNSIGNED NOT NULL DEFAULT 1,
	message Text NOT NULL,
	post_date Datetime NOT NULL,
 Primary Key (message_id)) ENGINE = MyISAM;


Alter table message add Foreign Key (client_id) references client (client_id) on delete  restrict on update  restrict;
Alter table message add Foreign Key (user_id) references user (user_id) on delete  restrict on update  restrict;
Alter table client add Foreign Key (user_id) references user (user_id) on delete  restrict on update  restrict;

Alter table message_history add Foreign Key (client_id) references client_history (client_id) on delete  restrict on update  restrict;
Alter table message_history add Foreign Key (user_id) references user (user_id) on delete  restrict on update  restrict;
Alter table client_history add Foreign Key (user_id) references user (user_id) on delete  restrict on update  restrict;
