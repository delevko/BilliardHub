
</br><mark>TODO add club's table number</mark></br>
</br></br>
<fieldset>
	<legend>Match:</legend>
	<form action="create.php" method="post">
		Club: <select name="club">
			<?php
			$data = query("SELECT id, name, city FROM club ORDER by id");
			for($i=0; $i<count($data); $i++)
			{
				print("<option value=\"".$data[$i][0]."\">");
				print($data[$i][1].", ".$data[$i][2]);
				print("</option>\n");
			}
			?>
		</select>
		</br></br>
		<table>
		<style>#mid{width:50px;} .num{width:25px;}</style>
		<tr>
			<th> Player1 </th>
			<th id="mid">:</th>
			<th> Player2 </th>
		</tr>
		<tr>
			<td>
				<select name="player1">
	<?php
	$data=query("select id, firstName, lastName from player");
	for($i=0; $i<count($data); $i++)
	{
	print("<option value=\"".$data[$i][0]."\">");
	print($data[$i][1].' '.$data[$i][2]);
	print("</option>\n");
	}
	?>
				</select>
			</td>
			<td> </td>
			<td>
				<select name="player2">
	<?php
	for($i=0; $i<count($data); $i++)
	{
	print("<option value=\"".$data[$i][0]."\">");
	print($data[$i][1].' '.$data[$i][2]);
	print("</option>\n");
	}
	?>
				</select>
			</td>
		</tr>
		<tr><td colspan="3">&nbsp;</td></tr>
		<tr>
			<td><input name="hand1" class="num" type="number" value="0"/></td>
			<td>Handicap</td>
			<td><input name="hand2" class="num" type="number" value="0"/></td>
		</tr>
		</table>
		</br>
		Best of: <input class="num" name="bestOF" type="number" value="1"/>
		</br></br>
		<button type="submit">Create</button>
	</form>
</fieldset>
