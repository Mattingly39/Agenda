<?php
 

session_start();
$user = $_SESSION["userConnected"];

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/helpers.php";
require_once "$root/Template.php";
require_once models('home');
require 'validator.php';

$checkFieldsAddCa = validate(
 [
    'nom' => ['required', 'max50'] ]
);

$OkAddCa = "";

if(!isset($_SESSION["userConnected"])){
   $checkFieldsAddCa = $checkFieldsAddCa . "<br />Vous devez vous connectez pour ajouter un calendrier" ;
}
 

if($checkFieldsAddCa == ""){ 
    if(! insertCalendar($_POST['nom'],isset($_POST['private']) ? 0 : 1 , $_SESSION["userConnected"]["ID"]))
    {
       $checkFieldsInsc = $checkFieldsAddCa . "Le calendrier n'a pas pu être ajouté" ;
    }
    else {
       $OkAddCa =  "Le calendrier a été ajouté" ;
    }

}

require_once 'event.php';

$listeUsers = [];
if(isset($_SESSION["userConnected"]["ID"])){
    $listeUsers = selectUsers($_SESSION["userConnected"]["ID"]);
}

$template = $twig->load('homeView.twig');
echo $template->render([
   'checkFieldsAddCa'=>$checkFieldsAddCa,
   'OkAddCa' => $OkAddCa,
   'user'=>$user['name'],
   'months'=>$months,
   'month'=>$month,
   'mois'=>$reversemonths[$month],
   'year'=>$year,
   'funct'=>$funct,
   'mybgimage'=>$mybgimage,
   'events'=> $events,
   'eventothers'=> $eventothers,
   'compteurprivate'=>$cp,
   'resultevents'=> $resultevents,
   'compteur'=>count($events),
   'change'=>$change,
   'dayselected'=>$day,
   'line'=>$li,
   'moisencours'=>$monthNum,
   'monthnew'=>$monthnew,
   'currentyear'=>date('Y'),
   'idcal'=>$idcal,
   'idcals'=>$idcals,
   'currentmonth'=>$monthName,
   'currentday'=>date('d'),
   'startday'=>$startday,
   'divtwig'=>$dt,
   'number'=>$number,
   'listeUsers'=>$listeUsers
]);  