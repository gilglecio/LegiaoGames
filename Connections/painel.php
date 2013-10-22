<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_painel = "localhost";
$database_painel = "418657";
$username_painel = "418657";
$password_painel = "";
$painel = mysql_pconnect($hostname_painel, $username_painel, $password_painel) or die('<script type="text/javascript">alert(\'O site não pode se conectar com o banco de dados\');</script>');
?>