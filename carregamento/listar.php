<?php 
include('conexao.php');

$pagina = isset( $_GET['pagina'] ) ? (int)$_GET['pagina'] : 0;

$SQLQuery = mysql_query("SELECT postTitulo, postThumb FROM `tb_posts` LIMIT $pagina,$limite") or die(mysql_error());
if(mysql_num_rows($SQLQuery)==0){
   die();
}
while($res=mysql_fetch_object($SQLQuery)){
?>	
    <li style="overflow:hidden; margin:3px 0;">
        <img style="float:left; margin-right:5px;" src="http://legiaogames.ueuo.com/upload/<?php echo $res->postThumb?>" width="100" height="100" /><br />
        <h4><?php echo $res->postTitulo?></h4>
    </li>	
<?php }	?>