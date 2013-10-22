<?php
$gmtDate = gmdate("D, d M Y H:i:s"); 
header("Expires: {$gmtDate} GMT"); 
header("Last-Modified: {$gmtDate} GMT"); 
header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache"); 
header("Content-Type: application/json; charset=ISO-8859-1", true);
//header("Content-Disposition: inline; filename=\"data.json\"");
?>