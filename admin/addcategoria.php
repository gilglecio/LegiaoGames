<?php 
require_once('ADMIN.php');
include('../php/model.php');
include('../php/funcoes.php');

if(isset($_POST['addCat'])){
	$novaCat     = $_POST['novaCategoria'];
	$novaCatSlug = slug($_POST['novaCategoria'],'-');
	$categoriaMae      = $_POST['categoriaMae'];
	$categoriaMaeSlug  = slug($_POST['categoriaMae'],'-');
	if($categoriaMae<>''){
		$novaCat     = $categoriaMae.'/'.$novaCat;
		$novaCatSlug = $categoriaMaeSlug.'/'.$novaCatSlug;
	}
	$selCats = mysql_query("SELECT * FROM `tb_categorias` WHERE `categoriaNome` = '$novaCat'");
	if(@mysql_num_rows($selCats) == 0){
		$addCat = mysql_query("INSERT INTO `tb_categorias` (categoriaNome,categoriaSlug) VALUES ('$novaCat','$novaCatSlug')");
	}
}

if(isset($_POST['delCat'])){
	$CatId = $_POST['CatId'];
	@mysql_query("DELETE FROM `tb_categorias` WHERE `categoriaId` = '$CatId'");
}
?>
<a href="painel.php">Voltar</a>
<form name="addCat" action="" method="post" enctype="multipart/form-data">
<select name="categoriaMae">
<option value="" selected="selected"> - Categoria m&atilde;e - </option>
<?php
$selCats = mysql_query("SELECT * FROM `tb_categorias`");
if(@mysql_num_rows($selCats) <> 0){
	while($resCats=mysql_fetch_array($selCats)){
		$categoriaNomeE = explode('/',$resCats['categoriaNome']);
		$categoriaNome = $categoriaNomeE[0];		
		$categoriaId = $resCats['categoriaId'];
		if(count($categoriaNomeE) == 1){
			echo '<option value="'.$categoriaNome.'">'.$categoriaNome.'</option>';
		}
	}
}
?>
</select>
<input type="text" name="novaCategoria" />
<input type="submit" name="addCat" value="adicionar" />
</form>
<hr />
Categorias
<ul>
<?php
$selCats = mysql_query("SELECT * FROM `tb_categorias`");
if(@mysql_num_rows($selCats) <> 0){
	while($resCats=mysql_fetch_array($selCats)){
	echo '<li>';
	echo $resCats['categoriaNome'];
	$catNome = $resCats['categoriaSlug'];
	$verPosts = mysql_query("SELECT `postCategoria` FROM `tb_posts` WHERE `postCategoria` = '$catNome'");
	if(@mysql_num_rows($verPosts) == 0){
	?>
	<form name="addCat" action="" method="post" enctype="multipart/form-data">
	<input type="hidden" name="CatId" value="<?php echo $resCats['categoriaId']; ?>" />
	<input type="hidden" name="CatNome" value="<?php echo $resCats['categoriaNome']; ?>" />
	<input type="submit" name="delCat" value="X" /></form>
	</li>
<?php }}} ?>
</ul>