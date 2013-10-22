<?php include('conexao.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>teste LoadScroll</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js" type="text/javascript"></script>  
<script>
$(document).ready(function() {
	var pagina = <?php echo $limite; ?>;
	$("#content").scroll(function() {
		if ($(this).scrollTop() + $(this).height() == $(this).get(0).scrollHeight) {
		  	pagina+=<?php echo $limite; ?>;
			console.log('fim');
			$.ajax({
		  		type: "get",
		  		url: "listar.php",
		  		data: "pagina="+pagina+"&post=OK",
		  		success: function(data) {
			  		$("#content ul").append(data);
		  		}
			});
	  	};
	});
});
</script>
</head>

<body>
<div id="content" style="height:500px; width:400px; margin:0 auto; overflow-y:scroll;">

<ul id="lista">
<?php
$sel=mysql_query("SELECT postTitulo,postThumb FROM `tb_posts` LIMIT $limite") or die(mysql_error());
while($res=mysql_fetch_object($sel)){
?>
    <li style="overflow:hidden; margin:3px 0;">
        <img style="float:left; margin-right:5px;" src="http://legiaogames.ueuo.com/upload/<?php echo $res->postThumb?>" width="100" height="100" /><br />
        <h4><?php echo $res->postTitulo?></h4>
    </li>
<?php } ?>
</ul>
</div>
</body>
</html>