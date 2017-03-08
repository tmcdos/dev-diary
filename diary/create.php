<?php

	if($_REQUEST['ide'])
	{
		$query = 'SELECT DATUM,TIP,BODY FROM LISTER WHERE ID='.(int)$_REQUEST['ide'];
	 	$result = mysql_query($query) or trigger_error($query.'<br>'.mysql_error(),E_USER_ERROR);
	 	$datum = ADate(mysql_result($result,0,0),DELIM);
	 	$event = mysql_result($result,0,1);
	 	$text = mysql_result($result,0,2);
	}

	if(isset($_POST['datum'])) $datum = ivo_str($_POST['datum']);
	if($datum == '') $datum = date('d-m-Y');
	if(isset($_POST['news'])) $text = ivo_str2($_POST['news']);
	if(isset($_POST['event'])) $event = (int)$_POST['event'];

	if(isset($_POST['cmdAdd']))
	{
		if(!ChekDate($datum)) $err = 'Invalid date';
		elseif($text == '') $err = 'Missing body of message';
		elseif($event<1) $err = 'Choose category';
		elseif($_POST['pass']!=PAROLA) $err = 'Wrong password !';
		else
		{
			if($_REQUEST['ide']) $query = 'UPDATE LISTER SET DATUM="'.GDate($datum).'",TIP='.$event.",BODY='".$text."' WHERE ID=".$_REQUEST['ide'];
				else $query = 'INSERT INTO LISTER(CREATED,DATUM,TIP,BODY) VALUES(NOW(),"'.GDate($datum).'",'.$event.",'".$text."')";
		 	$result = mysql_query($query) or trigger_error($query.'<br>'.mysql_error(),E_USER_ERROR);
		 	header('Location:index.php');
		 	die;
		}
	}
	
	if(isset($_POST['cmdDel']) AND $_REQUEST['ide']>0)
	{
		if($_POST['pass']!=PAROLA) $err = 'Wrong password !';
		else
		{
			$query = 'DELETE FROM LISTER WHERE ID='.(int)$_REQUEST['ide'];
		 	$result = mysql_query($query) or trigger_error($query.'<br>'.mysql_error(),E_USER_ERROR);
		 	header('Location:index.php');
		 	die;
		}
	}
	
	$b = str_replace('{IDE}',(int)$_REQUEST['ide'],$b);
	$b = str_replace('{VIS_DEL}',$_REQUEST['ide'] ? '' : 'display:none',$b);
	$b = str_replace('{DATUM}',$datum,$b);
	$b = str_replace('{TEXT}',$text,$b);
	$b = str_replace('<option value="0">{EVENT}</option>',loadItems('TYPE_EVENT','TYPE_EVENT',$event),$b);
 	
?>