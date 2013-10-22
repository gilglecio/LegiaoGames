<?php 
require_once('ADMIN.php'); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="js/tiny_func.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LegiaoGames - Adicionar novo Artigo</title>
<style type="text/css">
*{ margin:0; padding:0;}
div#box{ width:650px; margin:0 auto; font-family:"Trebuchet MS", Arial, Helvetica, sans-serif; padding:30px 0;}
div#box form{ float:left; width:100%;}
div#box span.form{ display:block; margin-top:30px; color:#900; font-weight:600;}
div#box input,textarea{ width:100%; padding:3px 0; border:1px solid #CCC; background:#FFF; color:#333;}
div#box select{padding:3px 0; border:1px solid #CCC; background:#FFF; color:#333;}
div#box .submit{ width:120px; padding:3px; float:right; margin:15px 0; background:#900; color:#FFF; cursor:pointer;}
div#box h3{ padding:5px; font-size:12px; color:#900; background:#FFDFDF; border:1px solid #FFCECE; display:block;}
div#box .yes{ padding:5px; font-size:12px; color:#090; background:#E1FFE1; border:1px solid #B7FFB7; display:block;}
</style>
</head>

<body>
<div id="box">
<a href="painel.php">Voltar</a>
<h2>Adicionar artigo</h2>

<?php if(isset($_POST['postar'])){
	include('../php/funcoes.php');
	$postTitulo    = strip_tags(trim($_POST['postTitulo']));
	$postSlug      = slug($postTitulo,'-');
	$postTexto     = trim($_POST['postTexto']);
	$postCategoria = $_POST['postCategoria'];
	$postTags      = strip_tags(trim($_POST['postTags']));
	$postVisitas   = '1';
	
	$pasta = '../upload';
	
	$postData      = date('Y-m-d H:i:s');
	
	if($postTitulo == ''){
		echo '<h3>Voc&ecirc; precisa digitar um titulo.</h3>';
	}elseif($_FILES['postThumb']['name'] == ''){
		echo '<h3>Voc&ecirc; precisa enviar uma imagem de identifica&ccedil;&aacute;o.</h3>';
	}elseif($postTexto == ''){
		echo '<h3>Voc&ecirc; precisa adicionar uma descrição ao seu artigo.</h3>';
	}elseif($postCategoria == ''){
		echo '<h3>N&atilde; se esque&ccedil;a de selecionar a categoria correspondente ao poste.<br />
		Caso não tenha <a href="addCat.php">crie-a</a></h3>';
	}elseif($postTags == ''){
		echo '<h3>Voc&ecirc; precisa digitar uma tag.<br />
		A mesma será usada no rodape do seu site.</h3>';
	}else{
		$nome = $postSlug.'-'.date('His').'.jpg';
		$inserir = mysql_query("INSERT INTO `tb_posts` (postTitulo,postSlug,postTags,postCategoria,postData,postAutor,postThumb,postVisitas,postTexto) VALUES ('$postTitulo','$postSlug','$postTags','$postCategoria','$postData','$userNome','$nome','$postVisitas','$postTexto')");
		if($inserir == 1){
			upload($_FILES['postThumb']['tmp_name'],$_FILES['postThumb']['name'],$nome,800,$pasta);
			unset($postTitulo,$postSlug,$postTags,$postTexto);
			echo '<h3 class="yes">Poste Cadastrado! [Redirecionado]</h3>';
			echo '<meta http-equiv="refresh" content="1, URL=\'painel.php\'" />';
		}
	}
}
?>

<form name="adicionarArtigo" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
	<span class="form">Titulo</span>
    <input type="text" name="postTitulo" value="<?php if(isset($postTitulo)){echo $postTitulo;}?>" />
    <span class="form">Foto</span>
    <input type="file" name="postThumb" />
    <span class="form">Conteudo do artigo</span>
    <textarea rows="25" name="postTexto"><?php if(isset($postTitulo)){echo $postTexto;}?></textarea>
    <span class="form">Categoria</span>
    <select name="postCategoria">
    	<option value="" selected="selected">- Selecione a categoria -</option>
        <?php
        $selCats = mysql_query("SELECT * FROM `tb_categorias`");
		if(@mysql_num_rows($selCats) <> 0){
			while($resCats=mysql_fetch_array($selCats)){
				echo '<option value="'.$resCats['categoriaSlug'].'">'.htmlentities($resCats['categoriaNome']).'</option>';
			}
		}
        ?>
    </select>
    <span class="form">Palavra para definir o artigo</span>
    <input type="text" name="postTags" value="<?php if(isset($postTitulo)){echo $postTags;}?>" />
    <input type="submit" class="submit" name="postar" value="Postar" />
</form>
</div><!--box-->
</body>
</html>