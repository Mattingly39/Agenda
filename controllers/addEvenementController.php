<?php


session_start();
$user = $_SESSION["userConnected"];

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once "$root/helpers.php";
require_once "$root/Template.php";
require_once 'event.php';
require_once models('home');
require 'validator.php';

if(isset($_GET['idcal']) AND !empty($_GET['idcal'])) {
    $idcal = htmlspecialchars($_GET['idcal']);
}
else
{
    $idcal='1';
}

echo $idcal;

$checkFieldsAddEve = validate(
    [
        'titre' => ['required', 'max50'],
        'dateDebut' => ['required'],
        'description' => ['max255']
    ]
);

if ($checkFieldsAddEve == "") {
    // $id_creator, $title, $start_date, $start_time, $end_date,  $end_time,  $visibility, $description, $id_calendar
    if (!isset($_SESSION["userConnected"])) {
        $checkFieldsAddEve = $checkFieldsAddEve . "<br />Vous devez vous connectez pour ajouter un évènement";
    } elseif ($_POST["dateDebut"] > $_POST["dateFin"] && $_POST["dateFin"] != "") {
        $checkFieldsAddEve = $checkFieldsAddEve . "<br />La date de début est supérieure à la date de fin";
    } elseif ($_POST["heureDebut"] > $_POST["heureFin"] && $_POST["heureDebut"] != "" && $_POST["heureFin"] != "") {
        $checkFieldsAddEve = $checkFieldsAddEve . "<br />L'heure de début est supérieure à l'heure de fin";
    } else {
        $id_event = insertEvent(
            $_SESSION["userConnected"]["ID"],
            $_POST["titre"],
            $_POST["dateDebut"],
            $_POST["heureDebut"],
            $_POST["dateFin"],
            $_POST["heureFin"],
            $_POST["Visibilite"] == "Publique" ? 1 : 0,
            $_POST["description"],
            $idcal
        );

        foreach ($_POST as $key => $value) {
            if (strpos($key, 'invite') === 0) {
                $id_user = substr($key, strpos($key, 'invite') + strlen('invite'));
                insertEvent_User($id_user,  $id_event);
            }
        }
        
        insertEvent_User(   $_SESSION["userConnected"]["ID"],  $id_event);
        $checkFieldsAddEve = $checkFieldsAddEve . "<br />L'évenement a bien été ajouté";
    }
} 

$listeUsers = [];
if(isset($_SESSION["userConnected"]["ID"])){
    $listeUsers = selectUsers($_SESSION["userConnected"]["ID"]);
}

$template = $twig->load('homeView.twig');
echo $template->render([
 'months'=>$months,
 'user'=>$user['name'],
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
 'checkFieldsAddEve'=>$checkFieldsAddEve,
 'listeUsers'=>$listeUsers
]);  