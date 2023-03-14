<?php
 
session_start();

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/helpers.php";
require_once "$root/Template.php";

require_once models('home');
require 'validator.php';

$checkFieldsConn = validate(
 [
    'email' => ['required', 'email', 'max255'],
    'mot_de_passe' => ['required', 'max50'],
 ]
);


if($checkFieldsConn == ""){
   $user = selectUser($_POST['email']);
   if ($user) {
       if (!password_verify($_POST['mot_de_passe'], $user['password'])) {
         $checkFieldsConn = $checkFieldsConn . "<br />Mauvais mot de passe" ;
       } 
       else {
         $_SESSION["userConnected"] = $user;
       }
   } else {
      $checkFieldsConn = $checkFieldsConn . "<br />L'adresse mail n'existe pas" ;
   }
}

$user = $_SESSION["userConnected"];


require_once 'event.php';

// récupère la liste des utilisateurs, excepté l'utilisateur connecté
$listeUsers = [];
if(isset($_SESSION["userConnected"]["ID"])){
    $listeUsers = selectUsers($_SESSION["userConnected"]["ID"]);
}


 $template = $twig->load('homeView.twig');
  echo $template->render([
   'checkFieldsConn'=>$checkFieldsConn,
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
 //  'editevent'=>Editevents($id),
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