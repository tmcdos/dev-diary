<?php

	// Show calendar
	if($_REQUEST['time']>1) 
	{
		list($d,$m,$y) = explode('.',$_REQUEST['time']);
		if($_REQUEST['prev']) 
		{
			$m--;
			if($m<1)
			{
				$m = 1;
				$y--;
			}
		}
		elseif($_REQUEST['next']) 
		{
			$m++;
			if($m>12)
			{
				$m = 1;
				$y++;
			}
		}
		$today = getdate(mktime(0,0,0,$m,$d,$y));
	}
	else $today = getdate();
	$mon = $today['mon'];
	$year = $today['year'];
	$day = $today['mday'];
	$my_time = mktime(0,0,0,$mon,1,$year);
	$start_day = date('N', $my_time);
	$start_week = date('W',$my_time);
	$daysIM = date('t',$my_time);

	// get count of posts for each day in the month
	$query = 'SELECT COUNT(*),DATE_FORMAT(DATUM,"%d") AS POSTED FROM LISTER WHERE DATE_FORMAT(DATUM,"%m-%Y")="'.($mon < 10 ? '0' : '').$mon.'-'.$year.'" GROUP BY POSTED';
 	$result = mysql_query($query) or trigger_error($query.'<br>'.mysql_error(),E_USER_ERROR);
 	while($row = mysql_fetch_array($result,MYSQL_NUM)) $cnt[(int)$row[1]] = $row[0];

	// show first week
	$dd = 1;
	$daye = 1;
	$z = '<tr align="center"><td class="week_num">'.($start_week++).'</td>';
	while($dd < $start_day)
	{
		$z.= '<td class="day">&nbsp;</td>';
		$dd++;
	}
	
	while($dd <= 7)
	{
		$z.= '<td class="'.($daye==$day ? 'to' :'').'day">';
		if($cnt[$daye]) $z.= '<a href="index.php?time='.$daye.'.'.$mon.'.'.$year.'"';
			else $z.= '<span';
		$z.= ' class="'.($dd<6 ? 'week_day' : 'week_end').'">'.$daye;
		if($cnt[$daye]) $z.= '</a>';
			else $z.= '</span>';
		$z.= '</td>';
		$daye++;
		$dd++;
	} 
	$z.= '</tr>';
	while($daye <= $daysIM)
	{
		$z.= '<tr align="center"><td class="week_num">'.($start_week++).'</td>';
		$dd = 1;
		while($dd <= 7)
		{
			if($daye <= $daysIM) 
			{
				$z.= '<td class="'.($daye==$day ? 'to' :'').'day">';
				if($cnt[$daye]) $z.= '<a href="index.php?time='.$daye.'.'.$mon.'.'.$year.'"';
					else $z.= '<span';
				$z.= ' class="'.($dd<6 ? 'week_day' : 'week_end').'">'.$daye;
				if($cnt[$daye]) $z.= '</a>';
					else $z.= '</span>';
				$z.= '</td>';
				$daye++;
			}
			else $z.= '<td class="day">&nbsp;</td>';
			$dd++;
		}
		$z.= '</tr>';
	}
	$b = str_replace('<tr><td>{WEEK}</td></tr>',$z,$b);
	$b = str_replace('{MONTH}',$month[$mon - 1].'&nbsp;&nbsp;'.$year,$b);
	$b = str_replace('{TIME}',date('d.m.Y',$my_time),$b);

	// show posts for today
	$query = 'SELECT DATE_FORMAT(CREATED,"%H:%i:%s,&nbsp; %d-%m-%Y"),TYPE_EVENT,COLOR,BODY,LISTER.ID FROM LISTER 
	  LEFT JOIN TYPE_EVENT ON TIP=TYPE_EVENT.ID 
	  WHERE DATE_FORMAT(DATUM,"%d-%m-%Y")="'.($day < 10 ? '0' : '').$day.'-'.($mon < 10 ? '0' : '').$mon.'-'.$year.'" ORDER BY CREATED';
 	$result = mysql_query($query) or trigger_error($query.'<br>'.mysql_error(),E_USER_ERROR);
 	$z = '';
 	$i = 1;
 	while($row = mysql_fetch_array($result,MYSQL_NUM))
 	{
 		$z.= '<tr><td bgcolor="#'.$row[2].'"><div style="float:left;font-weight:bold;color:white">'.($i++).' - '.$row[1].'</div><div style="float:right"><a href="index.php?tip=1&ide='.$row[4].'" class="link">'.$row[0].'</a>&nbsp;</div></td></tr>';
 		$z.= '<tr><td style="text-align:justify; text-indent: 10pt">'.$row[3].'</td></tr>';
 	}
 	if($z!='') $z = '<table width="100%">'.$z.'</table>';
	$b = str_replace('{CONTENT}',$z,$b);
 	
?>