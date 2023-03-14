<?php
 

session_start();

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/helpers.php";
require_once "$root/Template.php";
require_once models('home');

require 'validator.php';

$checkFieldsInsc = validate(
 [
    'nom' => ['required', 'max50'],
    'email' => ['required', 'email', 'max255'],
    'mot_de_passe' => ['required', 'max50'],
 ]
);

$template = $twig->load('homeView.twig');
 
// "andrew"; //$2y$10$8C2.WaJPYCv4K99lRQF7PeqGos9o7gslLQq0oTk0G4HmTPA3LXu1y
 //solene  //$2y$10$yyfyb7ObNCeQc83cvX0TF.TQB.zhmIiyrcTUBDiWsJgtGcv3kyf.C
 
 $OkInsc = "";
if($checkFieldsInsc == ""){
   $user = selectUser($_POST['email']);
   if ($user) 
   {
      $checkFieldsInsc = $checkFieldsInsc . "<br />Cet email existe déjà" ;
   } 
   else
   {
      if(!insertUser(strip_tags($_POST['nom']), strip_tags($_POST['email']),  password_hash( strip_tags($_POST['mot_de_passe']), PASSWORD_DEFAULT)))
      {
         $checkFieldsInsc = $checkFieldsInsc . "L'utilisateur n'a pas pu être ajouté" ;
      }
      else {
         $OkInsc =  "L'utilisateur a été ajouté" ;
      }
   }
}


require_once 'event.php';

$listeUsers = [];
if(isset($_SESSION["userConnected"]["ID"])){
    $listeUsers = selectUsers($_SESSION["userConnected"]["ID"]);
}



echo $template->render([
   'checkFieldsInsc'=>$checkFieldsInsc,
   'OkInsc'=>$OkInsc,
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