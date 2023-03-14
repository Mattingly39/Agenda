<?php

function mycalendars($user, $sorting, $order)
{
   $root = realpath($_SERVER["DOCUMENT_ROOT"]);
   require "$root/db.php";
   $cal='SELECT calendars.ID AS ID, calendars.name AS name, users.name AS username, visibility, calendars.date AS date 
   FROM calendars INNER JOIN users ON users.ID = calendars.id_creator WHERE id_creator ='.$user.' ORDER BY '.$sorting.' '.$order.'';
   $req1 = $connection->query($cal);
   return $req1->fetchAll();
}

function listeinvites()
{
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require "$root/db.php";
    $cal='SELECT * FROM event_user inner join users on users.ID = id_user';
    $req1 = $connection->query($cal);
    return $req1->fetchAll();
 }

function events($idcal)
{
   $root = realpath($_SERVER["DOCUMENT_ROOT"]);
   require "$root/db.php";
   $events='SELECT start_date, id_creator, title, start_time, end_date, end_time, description, DATEDIFF(end_date, start_date) AS date_difference, events.ID AS eventid, visibility, name 
   FROM events 
   INNER JOIN users ON users.ID = events.id_creator
   WHERE id_calendar = '.$idcal.' ORDER BY start_time';
   $req1 = $connection->query($events);
   return $req1->fetchAll();
}

function eventothers($idcal)
{
   $root = realpath($_SERVER["DOCUMENT_ROOT"]);
   require "$root/db.php";
   $events='SELECT start_date, title, start_time, end_date, end_time, description, DATEDIFF(end_date, start_date) AS date_difference, events.ID, events.visibility, calendars.name AS calname, calendars.visibility, users.name AS username 
   FROM events INNER JOIN calendars ON calendars.ID = events.id_calendar INNER JOIN users ON users.ID = events.id_creator
   WHERE id_calendar <> '.$idcal.' and events.visibility = 1 and calendars.visibility = 1 ORDER BY start_time';
   $req1 = $connection->query($events);
   return $req1->fetchAll();
}

function Delevents($id)
{
   $root = realpath($_SERVER["DOCUMENT_ROOT"]);
   require "$root/db.php";
   $del='DELETE FROM event_user WHERE '.$id.'= id_event';
   $req1 = $connection->query($del);
   $del1='DELETE FROM events WHERE '.$id.'= ID';
   $req1 = $connection->query($del1);
   return $req1->fetchAll();
}

function Editevents($id)
{
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require "$root/db.php";
    $edit='SELECT * FROM events WHERE '.$id.'= ID';
    $req1 = $connection->query($edit);
    return $req1->fetchAll();
}

function Saveevents($id, $title, $description, $visibility)
{
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require "$root/db.php";
    $sql = 'UPDATE events SET title = "'.$title.'", description = "'.$description.'", visibility = "'.$visibility.'" WHERE '.$id.'= ID';
    $req1 = $connection->query($sql);
    return $req1->fetchAll();
}

function Visical($id, $visibilitycal)
{
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require "$root/db.php";
    $save2 = 'UPDATE calendars SET visibility = '.$visibilitycal.' WHERE '.$id.'= ID';
    $req1 = $connection->query($save2);
    return $req1->fetchAll();
}

function Delagenda($idcal)
{
   $root = realpath($_SERVER["DOCUMENT_ROOT"]);
   require "$root/db.php";
   $del='DELETE FROM calendars WHERE '.$idcal.'= ID';
   $req1 = $connection->query($del);
   return $req1->fetchAll();
}

function cal($sorting, $order)
{
   $root = realpath($_SERVER["DOCUMENT_ROOT"]);
   require "$root/db.php";
   $cal='SELECT calendars.name AS namecal, users.name AS username, calendars.ID AS calid, visibility, calendars.date AS caldate
   FROM calendars INNER JOIN users ON users.ID = calendars.id_creator ORDER BY '.$sorting.' '.$order.'';
   $req1 = $connection->query($cal);
   return $req1->fetchAll();
}

function calc1erdumois($mois,$year)
{
   $c = floor((14-$mois)/12);
   $a = $year-$c;
   $m = $mois+12*$c-2;
   $day1 = (1+$a+floor($a/4)-floor($a/100)+floor($a/400)+floor((31*$m)/12));
   return $day1 % 7;
}

function usercreator($user)
{
   $root = realpath($_SERVER["DOCUMENT_ROOT"]);
   require "$root/db.php";
   $cal='SELECT users.name FROM calendars
   INNER JOIN users ON calendars.id_creator = users.ID
   WHERE id_creator = '.$user.'';
   $req1 = $connection->query($cal);
   return $req1->fetchAll();
}

function selectUser($email) 
{
    try {
        require('../db.php');
        $sql = 'select name, email, password, ID from users where email = :email;';
        $query = $connection ->prepare($sql);
        $query->bindValue(':email',$email, PDO::PARAM_STR);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo 'Erreur : ' . $e->getMessage() . '<br/>';
    }
    return $user;
}

function insertUser($name, $email, $password) : bool
{
    try {
        require('../db.php');
        $sql = 'INSERT INTO users(`name`, `email`, `password`) VALUES(:name, :email, :password)';
        $query = $connection->prepare($sql);
        $query->bindValue(':name', $name, PDO::PARAM_STR);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->bindValue(':password', $password, PDO::PARAM_STR);
        return $query->execute();
    } catch (Exception $e) {
        $result = 'Erreur : ' . $e->getMessage() . '<br/>';
    }
}

function insertCalendar($name, $visibility, $id_creator) : bool
{
    try {
        require('../db.php');
        $sql = 'INSERT INTO calendars(`name`, `visibility`, `id_creator`, `date`) VALUES(:name, :visibility, :id_creator, :date)';
        $query = $connection->prepare($sql);
        $query->bindValue(':name', $name, PDO::PARAM_STR);
        $query->bindValue(':visibility', $visibility, PDO::PARAM_BOOL);
        $query->bindValue(':id_creator', $id_creator, PDO::PARAM_INT);
        $query->bindValue(':date', date('Y-m-d H:i:s'), PDO::PARAM_STR);
        return $query->execute();
    } catch (Exception $e) {
        $result = 'Erreur : ' . $e->getMessage() . '<br/>';
    }
}

function selectUsers($userConnected)
{
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require "$root/db.php";
    $sql = 'select name, email, ID from users where ID <> :ID;';
    $query = $connection->prepare($sql);
    $query->bindValue(':ID', $userConnected, PDO::PARAM_STR);
    $query->execute();
    return $query->fetchAll();
}

function insertEvent($id_creator, $title, $start_date, $start_time, $end_date,  $end_time,  $visibility, $description, $id_calendar)
{
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require "$root/db.php";
    $sql = "INSERT INTO events(
        id_creator,
        title,
        start_date,
        start_time,
        end_date,
        end_time,
        visibility,
        description,
        id_calendar ) VALUES(
        :id_creator,
        :title,
        :start_date,
        :start_time,
        :end_date,
        :end_time,
        :visibility,
        :description,
        :id_calendar
        ) ;";
    $query = $connection->prepare($sql);
    $query->bindValue(':id_creator', $id_creator, PDO::PARAM_INT);
    $query->bindValue(':title', $title, PDO::PARAM_STR);
    $query->bindValue(':start_date', $start_date, PDO::PARAM_STR);
    $query->bindValue(':start_time', is_null($start_time) || $start_time == "" ? null :$start_time, PDO::PARAM_STR);
    $query->bindValue(':end_date', is_null($end_date) || $end_date == "" ? null :$end_date , PDO::PARAM_STR);
    $query->bindValue(':end_time', is_null($end_time) || $end_time == "" ? null :$end_time,PDO::PARAM_STR);
    $query->bindValue(':visibility', $visibility, PDO::PARAM_INT);
    $query->bindValue(':description', $description, PDO::PARAM_STR);
    $query->bindValue(':id_calendar', $id_calendar, PDO::PARAM_INT);
    $query->execute();
    return  $connection->lastInsertId();
}


function insertEvent_User($id_user, $id_event): bool
{
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require "$root/db.php";
    $sql = 'INSERT INTO event_user(id_user, id_event) VALUES (:id_user,:id_event);';
    $query = $connection->prepare($sql);
    $query->bindValue(':id_user', $id_user, PDO::PARAM_INT);
    $query->bindValue(':id_event', $id_event, PDO::PARAM_INT);
    return $query->execute();
}
