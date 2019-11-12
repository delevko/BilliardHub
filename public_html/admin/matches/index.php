<?php

require("../../../includes/adminConfig.php");

$title = "Admin Panel - Matches";
require(HOME_DIR."/templates/admin/header.php");

?>
<p><mark>TODO</mark></p>

<a href="create.php">Start Match</a>
<h1>List of Matches:</h1>


<?php

require(HOME_DIR."/templates/admin/footer.php");

/*
$data = query("SELECT tournament.id, tournament.name, billiard.name, 
			age.name, tournament.sex 
			FROM tournament JOIN age ON ageID=age.id 
			JOIN billiard ON billiardID=billiard.id 
			ORDER BY tournament.name, billiard.name DESC, age.name, tournament.sex");

for($i=0; $i<count($data); $i++)
{
	print("<a href=\"lobby.php?id=".$data[$i][0]."\">".$data[$i][1]);
	if(strcasecmp($data[$i][2], "snooker") != 0)
	{
		print(" ".$data[$i][2]);
	}
	if(strcmp($data[$i][3],"") != 0 ||
	   strcmp($data[$i][4],"") != 0)
	{
		print(" (".$data[$i][3]." ".$data[$i][4].")");
	}
	print("</a>");
	print("</br>\n");
}

*/

?>
