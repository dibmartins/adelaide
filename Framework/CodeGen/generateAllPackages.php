<?php 

require_once("../Class/System.php");

try
{
    $objSubPackages = new CodeGenSubPackages();

    $objSubPackages->SetModel("sigsWebConsultaFarmaciaPsf_v4.xml");
    $objSubPackages->SetOutputDir("Output/Packages/");
    $objSubPackages->SetVersion("1.0");
    $objSubPackages->Generate();
    
    echo "Total de tabelas codificadas: " . $objSubPackages->GetGeneratedClasses();
}
catch(Exception $e)
{
    echo $e->getMessage();  
}
?>