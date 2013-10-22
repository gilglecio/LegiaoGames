<?php 
include_once('php/MySql.class.php');
$MySql = new MySql;
$urlBase = 'http://legiaogames.ueuo.com';
$siteTitulo = 'LegiaoGames2.0';
$siteSlug = 'A pensão dos Games';
include_once('php/Usuario.class.php'); 
$userClass = new Usuario;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="<?php echo $urlBase; ?>/js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){alerta = function(str){$("body").append("<div id='alerta'><div id='alertaBox'>"+str+"</div></div>");var $alerta = $("#alerta");$alerta.slideDown(350);$alerta.click(function(){$alerta.slideUp(350);});window.setTimeout(function() {$alerta.slideUp(350);}, 10000);};});
</script>
<?php
$url = $_GET['url'];
$_URLE = explode('/',$url);

$_CONTROLLER    = $_URLE[0];
$_SUBCONTROLLER = $_URLE[1];
$_ACTION        = $_URLE[2];


if($_SUBCONTROLLER === 'page'){
	$_PAGE = $_URLE['2'];
}elseif($_ACTION === 'page'){
	$_PAGE = $_URLE['3'];
}
$_SEARCH = $_GET['s']; 
$_PAGINAS = array('contato'); 

if(isset($_SEARCH) && $_SEARCH !== ''){
	$_AtualPagina = 'paginas/busca.php';
	$_eSEARCH = explode('/',$_SEARCH);
	$searchPag = (isset($_eSEARCH[2])) ? ' / '.$_eSEARCH[2] : ''; 
	$_TituloPagina = $_eSEARCH[0].$searchPag.' - busca em '.$siteTitulo;
}elseif(isset($_GET['alerta'])){ 
	echo '<script type="text/javascript">$(function(){alerta("'.$_GET['alerta'].'");});</script>';
	$_AtualPagina = 'paginas/home.php';
	$_TituloPagina = $siteTitulo.' - '.$siteSlug;
}elseif(isset($_CONTROLLER) && $_CONTROLLER === 'arquivo'){
	$_AtualPagina = 'paginas/arquivo.php';
	$_TituloPagina = $_SUBCONTROLLER.' - '.$siteTitulo;
}elseif(isset($_CONTROLLER) && in_array($_CONTROLLER,$_PAGINAS)){
	$_AtualPagina = 'paginas/'.$_CONTROLLER.'.php';
	$_TituloPagina = ucfirst($_CONTROLLER).' - '.$siteTitulo;	
}elseif(isset($_ACTION) && $_ACTION <> ''){
	$pega_slug_do_poste = mysql_query("SELECT `postSlug` FROM `tb_posts` WHERE `postSlug` = '$_ACTION'");
	if(@mysql_num_rows($pega_slug_do_poste)==1){
		$pega_titulo_do_poste = mysql_query("SELECT `postTitulo` FROM `tb_posts` WHERE `postSlug` = '$_ACTION'");
		$_AtualPagina = 'paginas/single.php';
		while($resPegaTitulo=mysql_fetch_array($pega_titulo_do_poste)){
			$titlePost = $resPegaTitulo['postTitulo'];
		}
			$_TituloPagina = $titlePost.' - '.$siteTitulo;
	}elseif(!is_nan($variavel)){
		$_AtualPagina = 'paginas/categoria.php';
		$_TituloPagina = ucfirst($_CONTROLLER).' / '.$_ACTION.' - '.$siteTitulo;
	}
}elseif(isset($_SUBCONTROLLER) && $_SUBCONTROLLER <> 'page' && $_SUBCONTROLLER <> ''){
	$pega_slug_do_poste = mysql_query("SELECT `postSlug` FROM `tb_posts` WHERE `postSlug` = '$_SUBCONTROLLER'");
	if(@mysql_num_rows($pega_slug_do_poste)==1){
		$pega_titulo_do_poste = mysql_query("SELECT `postTitulo` FROM `tb_posts` WHERE `postSlug` = '$_SUBCONTROLLER'");
		$_AtualPagina = 'paginas/single.php';
		while($resPegaTitulo=mysql_fetch_array($pega_titulo_do_poste)){
			$titlePost = $resPegaTitulo['postTitulo'];
		}
		$_AtualPagina = 'paginas/single.php';
		$_TituloPagina = $titlePost.' - '.$siteTitulo;
	}else{
		$_AtualPagina = 'paginas/categoria.php';
		$_TituloPagina = ucfirst($_SUBCONTROLLER).' - '.$siteTitulo;
	}
}elseif(isset($_CONTROLLER) && $_CONTROLLER == ''){
	$_AtualPagina = 'paginas/home.php';
	$_TituloPagina = $siteTitulo.' - '.$siteSlug;
}else{
	$_AtualPagina = 'paginas/categoria.php';
	$_TituloPagina = ucfirst($_CONTROLLER).' - '.$siteTitulo;
}

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_TituloPagina; ?></title>

<link href="<?php echo $urlBase; ?>/style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo $urlBase; ?>/js/cycle.js"></script>

<script type="text/javascript">
	$(function(){$("#slide ul").cycle({fx:'fade',speed: 500,timeout: 3000,pager:'.paginador-slider',fastOnEvent: true});});
	window.onload = function() { document.getElementById("loadings").style.display = "none"; };
	$(document).ready(function(){$("#expandButton").hide();$(".toggleButton").click(function(){$("div#destaque").slideToggle("slow");$("div#slide-nav").slideToggle("slow");$("div#novidades").slideToggle("slow");$("div#imagem").slideToggle("slow");$(".toggleButton").toggle();});});
	$(document).ready(function(){$("#expandButton").hide();$("#login-toggle").click(function(){	$("div#login-form").slideToggle("slow");$(".toggleButtonLogin").toggle();});});
	$(document).ready(function(){alerta = function(str){$("body").append("<div id='alerta'><div id='alertaBox'>"+str+"</div></div>");var $alerta = $("#alerta");    $alerta.slideDown(350);$alerta.click(function(){$alerta.slideUp(350);});window.setTimeout(function() {$alerta.slideUp(350);}, 10000);};});
</script>
<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet'>

<meta name="robots" content="index, follow" />
<meta name="description" content="LegiaoGames seu site de downloads" />
<meta name="keywords" content="animes, naruto, jogos e downloads, games para computador" />
<meta name="generator" content="Gilgl&eacute;cio.com - Programador e Design Freelance" />
</head>

<body>

<div id="header">
	<div id="header-capa">
	<div id="header-left"></div>
    <div id="header-corpo"></div>
    <div id="header-right"></div>
    </div><!--header capa-->
    
    <div id="header-logo">
    	<a href="<?php echo $urlBase; ?>"><img src="<?php echo $urlBase; ?>/images/legiaogames.png" width="219" height="62" alt="LegiaoGames 2.0" border="0" /></a>
    </div><!--header-logo-->
    
    <div id="header-search">
    	<form name="search" method="get" enctype="multipart/form-data" action="<?php echo $urlBase; ?>">
        	<input name="s" type="text" id="s" value="O que voc&ecirc; procura?"  onfocus="if(this.value=='O que voc&ecirc; procura?')this.value='';" onblur="if(this.value=='')this.value='O que voc&ecirc; procura?';" />
            <input type="submit" name="buscar" value="" id="buscar" />
        </form>
    </div><!--header-search-->
    
    <div id="menu"></div><!--menu-->
    
    <div id="login">
    	<div id="login-form" style="display:none;">
        <?php if(!$userClass->usuarioLogado()){ ?> 
        	<form name="login" method="POST" enctype="multipart/form-data" action="<?php echo $urlBase.'/php/logar.php'; ?>" >
            	<span>email</span>
            	<input type="text" name="email" value="login"  onfocus="if(this.value=='login')this.value='';" onblur="if(this.value=='')this.value='login';" />
                <span>senha</span>
                <input type="password" name="senha" value="senha"  onfocus="if(this.value=='senha')this.value='';" onblur="if(this.value=='')this.value='senha';" />
                <span style="margin-top:7px;"><input type="checkbox" name="lembrar" />&nbsp;Conectado</span>
                <input type="submit" name="logar" value="logar" />
            </form>
        <?php }else{ ?>
        	<span>Olá <?php echo $_SESSION['usuarioLG_userNome']; ?> | <a  href="<?php echo $urlBase; ?>/php/logoOut.php">sair</a></span>
        <?php } ?>
        </div><!--login-form-->
        
        <div id="login-toggle"> 
        <?php if(!$userClass->usuarioLogado()){echo 'logar';}else{echo 'deslogar';} ?> 
        	<img src="<?php echo $urlBase; ?>/images/expandButton.png" alt="" title="Logar" class="toggleButtonLogin">
			<img style="display: none;" src="<?php echo $urlBase; ?>/images/collapseButton.png" alt="" class="toggleButtonLogin">
        </div><!--login-toggle-->
    </div><!--login-->
    
    	<div id="menu-lista">
    	<ul class="home"><li><a href="<?php echo $urlBase; ?>" <?php if($_CONTROLLER == '' && !isset($_SEARCH)){ echo 'style="color:#900;"'; } ?>>home</a></li></ul>
        <ul class="paginas">
          	<?php
			$selCatMenuTop = mysql_query("SELECT `postCategoria` FROM `tb_posts` GROUP BY `postCategoria`")
			or die('<script type=\"text/javascript\">$(function(){alerta(\'O site não pode selecionar as categorias do Site\');});</script>'.mysql_error());
			if(mysql_num_rows($selCatMenuTop) === 0){
				echo '<li><a href="#">categorias</a></li>';
			}else{
				$ArrayCats = array();
				while($resCatMenuTop=mysql_fetch_array($selCatMenuTop)){
					$resCatMenuTopE = explode('/',$resCatMenuTop['postCategoria']);
					array_push($ArrayCats,$resCatMenuTopE[0]);
				}
				$ArrayCats = array_flip($ArrayCats);
				$ArrayCats = array_flip($ArrayCats);
				$numCategorias = count($ArrayCats);
				for($u=0;$u<$numCategorias+1;$u++){
					echo '<li><a ';
					if($ArrayCats[$u] == $_CONTROLLER){
						echo 'style="color:#900;"';
					}
					echo ' href="'.$urlBase.'/'.$ArrayCats[$u].'">'.$ArrayCats[$u].'</a></li>';
				}
            } ?>
        </ul>
        </div><!--menu-lista-->        
    <div id="header-sombra">
    <div id="sombra-header-left"></div>
    <div id="sombra-header-corpo"></div>
    <div id="sombra-header-right"></div>
    </div><!--header-sombra-->
</div><!--header-->