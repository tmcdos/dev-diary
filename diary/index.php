<?php
include('DBASE.PHP');

$tip = (int)$_REQUEST['tip'];
$tpl = Array('list','create','find','show');
$month = Array('January','February','March','April','May','June','July','August','September','October','November','December');

	if($b = @file_get_contents($tpl[$tip].'.htm'))
	{
		include($tpl[$tip].'.php');
		$b = str_replace('{HEADER}',@file_get_contents('header.htm'),$b);
		$b = str_replace('{FOOTER}',@file_get_contents('footer.htm'),$b);
		if($err!='') $z = 'alert("'.$err.'");';
			else $z = '';
		$b = str_replace('<!--{ERROR}-->',$z,$b);
		$b = str_replace('{PREP}',WEBDIR,$b);

		echo $b;
	}
	else die('Could not find template - '.$tpl[$tip].'.htm');

?>