<?php require_once('ADMIN.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LegiaoGames - Painel</title>
<style type="text/css">
*{ margin:0; padding:0;}
div#box{ width:950px; margin:0 auto; font-family:"Trebuchet MS", Arial, Helvetica, sans-serif; padding:30px 0;}
	div#header{ height:100px; border-bottom:1px solid #CCC;}
	div#content{ width:100%; margin:10px 0; float:left;}
		div#sidebar{ width:200px; float:left; border-right:1px solid #CCC;}
		div#paginas{ float:left;}
	div#footer{ height:100px; background:#333; border-top:1px solid #000;}
div#box h3{ padding:5px; font-size:12px; color:#900; background:#FFDFDF; border:1px solid #FFCECE; display:block;}
div#box .yes{ padding:5px; font-size:12px; color:#090; background:#E1FFE1; border:1px solid #B7FFB7; display:block;}
</style>
</head>

<body>
<div id="box">
	<div id="header">
    <img src="../../../../Users/Rafael/Documents/Site sem nome 2/legiao.png" />
</div><!--header-->
    <div id="content">
    	<div id="sidebar">
        Escolhas
<ul>
				<li><a href="addartigo.php">Adicionar novo Artigo</a></li>
			    <li><a href="addcategoria.php">Gerenciar categorias</a></li>
			    <li><a href="../php/logoOut.php">Sair</a></li>
			</ul>
        </div><!--sidebar-->
        <div id="paginas">
			Home Legiao Games, Parte Administrativa
            Acesso Liberado Somente ao Usuario Rafael Augusto.
      </div><!--paginas-->
    </div><!--content-->
    <div style="clear:both;"></div>
    <div id="footer">
    <img src="../../../../Users/Rafael/Documents/Site sem nome 2/legiaogames.png"  />
    </div><!--footer-->
</div><!--box-->
</body>
</html>