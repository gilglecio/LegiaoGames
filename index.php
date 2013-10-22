<?php if(file_exists('header.php')){ include('header.php'); }else{ exit; } ?>

<?php 
if(file_exists('destaque.php')){ 
	if($_CONTROLLER === '' && !isset($_SEARCH)){
		include('destaque.php'); 
	}		
}	 
?>
<div id="content">
<div id="conteudo">
<div id="bloco">
<div id="sidebar">
<?php if(file_exists('sidebar.php')){ include('sidebar.php'); } ?>
</div><!--sidebar-->
<?php include($_AtualPagina);
if(file_exists('footer.php')){ include('footer.php'); }
?>