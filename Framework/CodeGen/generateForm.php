<?php 

require_once("../Class/System.php");

$objForm = new CodeGenForm();
$objForm->SetTable("cli_clientes");

echo "<pre>";
print_r(array_map("htmlentities", $objForm->Generate()));
echo "</pre>";

?>