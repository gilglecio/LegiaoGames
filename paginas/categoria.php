<div id="categoria">
<div id="categoria-content">
<ul>
<?php
$_PAGE = ($_PAGE >= '1') ? $_PAGE : '1';
$maximo = '5';
$inicio = ($_PAGE * $maximo) - $maximo;

if(isset($_CONTROLLER) && $_CONTROLLER <> 'page' && isset($_SUBCONTROLLER) && $_SUBCONTROLLER <> 'page'){
	$SQL = mysql_query("SELECT * FROM `tb_posts` WHERE `postCategoria` = '$_CONTROLLER/$_SUBCONTROLLER' ORDER BY `postId` DESC LIMIT $inicio,$maximo ") or die("<script type=\"text/javascript\">$(function(){alerta('O site não pode selecionar a tabela POSTES');});</script>");
}else{
	$SQL = mysql_query("SELECT * FROM `tb_posts` WHERE `postCategoria` = '$_CONTROLLER' || `postCategoria` LIKE '%$_CONTROLLER%' ORDER BY `postId` DESC LIMIT $inicio,$maximo") or die("<script type=\"text/javascript\">$(function(){alerta('O site não pode selecionar a tabela POSTES');});</script>");
}
while($result = mysql_fetch_array($SQL)){
	$postCategoria=$result['postCategoria'];
	$postSlug=$result['postSlug'];
	$postId=$result['postId'];
	$postFotoHome = $result['postThumb'];
?>
	<li>
    <?php if(file_exists("upload/$postFotoHome")){ ?>
	<a href="<?php echo $urlBase; ?>/<?php echo $result['postCategoria']; ?>/<?php echo $result['postSlug']; ?>">
	<img src="<?php echo $urlBase; ?>/thumb.php?src=<?php echo $urlBase; ?>/upload/<?php echo $result['postThumb']; ?>&h=150&w=200&zc=1" alt="<?php echo $result['postSlug']; ?>" width="200" height="150" border="0">
	</a>
    <?php } ?>      
	<h5><a href="<?php echo $urlBase; ?>/<?php echo $result['postCategoria']; ?>/<?php echo $result['postSlug']; ?>"><?php echo $result['postTitulo']; ?></a></h5>
    <p><a href="<?php echo $urlBase; ?>/<?php echo $result['postCategoria']; ?>/<?php echo $result['postSlug']; ?>"><?php echo $result['postTexto']; ?></a></p>
    <span>por <a href="#"><?php echo $result['postAutor']; ?></a> em <a href="#"><?php echo date('d/m/y',strtotime($result['postData'])); ?></a>, <a href="#"><?php echo $result['postVisitas']; ?></a> visualizações
    <?php 
	//SELECIONAR COMENTARIO DE CADA POSTE
	$SQLCommnets = mysql_query("SELECT * FROM `tb_coments` WHERE `comentPostId` = '$postId'");
	$contarComments = mysql_num_rows($SQLCommnets);
	if($contarComments > 0){		
	  	echo ', <a href="'.$urlBase.'/'.$result['postCategoria'].'/'.$result['postSlug'].'#comentarios">'.$contarComments.'</a> comentários';
	}
	?>
    </span>
	</li>
<?php  } ?>
</ul>
<div id="paginador-postes">
<?php
if(isset($_CONTROLLER) && $_CONTROLLER <> 'page' && isset($_SUBCONTROLLER) && $_SUBCONTROLLER <> 'page'){
	$sqlResPaginatorPosts = mysql_query("SELECT * FROM `tb_posts` WHERE `postCategoria` = '$_CONTROLLER/$_SUBCONTROLLER' ORDER BY `postId` DESC");
}else{
	$sqlResPaginatorPosts = mysql_query("SELECT * FROM `tb_posts` WHERE `postCategoria` = '$_CONTROLLER' || `postCategoria` LIKE '%$_CONTROLLER%' ORDER BY `postId` DESC");
}
$totalResPaginatorPosts = mysql_num_rows($sqlResPaginatorPosts);

if($totalResPaginatorPosts > $maximo){
	$paginas = ceil($totalResPaginatorPosts/$maximo);
	$links = '3';
	$anterior = $_PAGE-1;
	$proxima = $_PAGE+1;
	$linkPagina = $urlBase.'/'.$postCategoria;
	
	echo '<span>página '.$_PAGE.' de '.$paginas.'</span>';
	
	if($_PAGE >= 6){
		echo "<a title=\"Primeira página\" href=\"$linkPagina\">Primeira</a>";
	}
	
	if($_PAGE > 1){
		echo "<a title=\"página anterior\" href=\"$linkPagina/page/$anterior\"><<</a>";
	}
	
	if($_PAGE>=5){
			echo '<span>...</span>';
	}
	
	for ($i = $_PAGE-$links; $i <= $_PAGE-1; $i++){
		if ($i <= 0){}else{
			if($i === 1){
				echo "<a href=\"$linkPagina\">$i</a>";
			}else{
				echo "<a href=\"$linkPagina/page/$i\">$i</a>";
			}
		}
	}
	echo '<span>'.$_PAGE.'</span>';
	for($i = $_PAGE +1; $i <= $_PAGE+$links; $i++){
		if($i > $paginas){}else{
			echo "<a href=\"$linkPagina/page/$i\">$i</a>";
		}
	}
	
	if($paginas-$links>$_PAGE){
		echo '<span>...</span>';
	}
	
	if($paginas-$links>($_PAGE+1)){
		echo "<a title=\"Ultima página\" href=\"$linkPagina/page/$paginas\">Ultima</a>";
	}
	
	if($_PAGE < $paginas){
		echo "<a title=\"proxima página\" href=\"$linkPagina/page/".$proxima."\">>></a>";
	}
}
?>
</div><!--paginador -postes-->
</div><!--categoria content-->
</div><!--categoria-->