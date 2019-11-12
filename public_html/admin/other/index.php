<?php

require("../../../includes/adminConfig.php");

$title = "Admin Panel - Other";
require(HOME_DIR."/templates/admin/header.php");

?>
<a href="billiardCreate.php">Create Billiard</a>
<h1>List of Billiards:</h1>
<?php

$data = query("SELECT id, name FROM billiard ORDER BY id");
for($i = 0; $i<count($data); $i++)
{
	print($data[$i][1]);
	print("</br>\n");
}
print("<h1>----------</h1>");
?>
<a href="organisationCreate.php">Create Organisation</a>
<h1>List of Organisations:</h1>
<?php
$data = query("SELECT id, name FROM organisation ORDER BY id");
for($i = 0; $i<count($data); $i++)
{
	print($data[$i][1]);
	print("</br>\n");
}

require(HOME_DIR."/templates/admin/footer.php");

?>
