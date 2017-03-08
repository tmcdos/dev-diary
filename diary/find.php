<?php

	$text = ivo_str($_POST['text']);
	$b = str_replace('{TEXT}',$text,$b);
	$query = 'SELECT DATE_FORMAT(CREATED,"%H:%i:%s,&nbsp; %d-%m-%Y"),TYPE_EVENT,COLOR,BODY,LISTER.ID,DATE_FORMAT(DATUM,"%d-%m-%Y") FROM LISTER LEFT JOIN TYPE_EVENT ON TIP=TYPE_EVENT.ID WHERE MATCH(BODY) AGAINST (\''.$text.'\' IN BOOLEAN MODE) ORDER BY DATUM,CREATED';
 	$result = mysql_query($query) or trigger_error($query.'<br>'.mysql_error(),E_USER_ERROR);
 	$z = '';
 	while($row = mysql_fetch_array($result,MYSQL_NUM))
 	{
 		$z.= '<tr><td bgcolor="#'.$row[2].'"><div style="float:left;font-weight:bold;color:white">('.$row[5].') &nbsp; '.$row[1].'</div><div style="float:right"><a href="index.php?tip=1&ide='.$row[4].'" class="link">'.$row[0].'</a>&nbsp;</div></td></tr>';
 		$z.= '<tr><td style="text-align:justify; text-indent: 10pt">'.$row[3].'</td></tr>';
 	}
 	if($z!='') $z = '<table width="100%">'.$z.'</table>';
	$b = str_replace('{CONTENT}',$z,$b);
 	
?>