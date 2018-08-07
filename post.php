<?php 
require_once("db.php");

if (isset($_POST["dop_seal"])) { 
    // сюда приходит запрос на промо
    $db = new Db();
    echo $db->GetSeal($_POST["dop_seal"]);
}

if(isset($_POST["email"]) && isset($_POST["name"]) && isset($_POST["tel"])){
    $db = new Db();
    echo $db->InsertNewOrder($_POST["name"],$_POST["email"],$_POST["tel"],$_POST["seals"],$_POST["quantity"],$_POST["price"]);
}
?>