<?php

require_once models('home');

if(isset($_SESSION["userConnected"]) AND !empty($_SESSION["userConnected"])) {
    $user = $_SESSION["userConnected"];
    }
    else
    {
        $user['name'] = '';
    }
    
    if(isset($_GET['deConnected']) AND !empty($_GET['deConnected'])) {
        if($_GET['deConnected'] == 1) {
            unset($_SESSION['userConnected']);
            $user['name'] = '';
        }
        else {
        $user = $_SESSION["userConnected"];
        }
    }
    
    if(isset($_GET['sort'])) {
        $sort = htmlspecialchars($_GET['sort']);
        }
        else {
            $sort='Nom';
        }
    $_SESSION['sort'] = $sort;
    
    if ($_SESSION['sort'] == 'Nom'){
        $sorting = 'calendars.name';
    }
    if ($_SESSION['sort'] == 'Date création'){
        $sorting = 'calendars.date';
    }
    if ($_SESSION['sort'] == 'Propriétaire'){
        $sorting = 'users.name';
    }
    
    if(isset($_GET['order'])) {
        $order = htmlspecialchars($_GET['order']);
        }
        else {
            $order='ASC';
        }
    $_SESSION['order'] = $order;
    
    if ($_SESSION['order'] == 'ASC'){
        $sorder = 'ASC';
    }
    if ($_SESSION['order'] == 'DESC'){
        $order = 'DESC';
    }
    
    

$bgimage = array('/public/images/calendrierback1.png', '/public/images/calendrierback2.png', '/public/images/calendrierback3.png', '/public/images/calendrierback4.png', '/public/images/calendrierback5.png'); 
$i = rand(0, count($bgimage)-1); 
$mybgimage = "$bgimage[$i]";

$months = array(
    'JANVIER' => 'January',
    'FEVRIER' => 'February',
    'MARS' => 'March',
    'AVRIL' => 'April',
    'MAI' => 'May',
    'JUIN' => 'June',
    'JUILLET' => 'July',
    'AOUT' => 'August',
    'SEPTEMBRE' => 'September',
    'OCTOBRE' => 'October',
    'NOVEMBRE' => 'November',
    'DECEMBRE' => 'December');

$reversemonths = array_flip($months);   

$divtwig = array(
    '',                                                                   //0
    '<div></div>',                                                        //1
    '<div></div><div></div>',                                             //2
    '<div></div><div></div><div></div>',                                  //3
    '<div></div><div></div><div></div><div></div>',                       //4
    '<div></div><div></div><div></div><div></div><div></div>',            //5    
    '<div></div><div></div><div></div><div></div><div></div><div></div>', //6       
);

$change = 1;

if(isset($_GET['id']) AND !empty($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);
    if(isset($_GET['funct']) AND !empty($_GET['funct'])) {
        $funct = htmlspecialchars($_GET['funct']);
        if ($funct=="del"){ 
        Delevents($id);
        }
        elseif ($funct=="edit")
        {
        Editevents($id);
        }}
}
else
{
    $id='';
}

$funct='';


// Selectionne le bon agenda selon l'ID du connecté
if(isset($_GET['idcal']) AND !empty($_GET['idcal'])) {
    $idcal = htmlspecialchars($_GET['idcal']);
}
else
{
    $idcal='1';
}

if(isset($_GET['day']) AND !empty($_GET['day'])) {
    $day = htmlspecialchars($_GET['day']);
}
else
{
    $day=0;
}

// Calcule le mois en cours
$monthNum  = date('m');
$monthName = date('F', mktime(0, 0, 0, $monthNum, 10));
$monthnew = $monthNum;
$monthName2 = date('F', mktime(0, 0, 0, $monthnew, 10));

if(isset($_GET['month']) AND !empty($_GET['month'])) {
    $month = htmlspecialchars($_GET['month']);
}
else
{
    $month=$monthName2;
}

// Convertit le mois en valeur numérique
$date = date_parse($month);
$mois = $date['month'];

if(isset($_GET['year']) AND !empty($_GET['year'])) {
        $year = htmlspecialchars($_GET['year']);   
}
else
{
    $year=date('Y');
}

// Calcul du jour auquel le 1er d'un mois donné correspond
$startday= calc1erdumois($mois,$year);

// Détermine le nombre de case de la 1ère ligne du calendrier à laisser vide pour positionner le '01'
$dt = $divtwig[$startday];

// Calcule le nombre de jour de chaque mois
$number = cal_days_in_month(CAL_GREGORIAN, $mois, $year);

// Calcule le coefficient qui permettra de choisir la classe "matrix_l" à affecter
$li = ($number-(7-$startday))/4;


$idcals = cal($sorting, $order);

// récupère la start_date de la table 'events'
$events = events($idcal);
$eventothers = eventothers($idcal);


$cp=0;
if (count($events) != 0){
for ($c3=0; $c3 < count($events); $c3++) {
$eventdates[$c3] = $events[$c3][0];
if ($events[$c3][8]==0){
    $cp++; 
}
}
$resultevents = array_unique($eventdates);
}
else {
    $resultevents = array();
}
if ($user['name'] != null ){
$mycalendar = mycalendars($user['ID'], $sorting, $order);
}
else
{
    $mycalendar = '';
}
