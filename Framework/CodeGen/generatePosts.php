<?php 

require_once("../Class/System.php");

$objDBServer = AdoFactory::Server();

$rscFields = $objDBServer->ListFields("cli_clientes");

foreach($objDBServer->FieldsInfo($rscFields) as $arField)
{
    echo "\$_POST[\"".$arField["name"]."\"] = \"\";<br>";
}

echo "<br>\$_POST[\"action\"] = \"\";";

?>
