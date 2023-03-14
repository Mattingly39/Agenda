<?php


require_once 'db.php' ;

$queries = ["CREATE TABLE `users` (
	`ID` bigint NOT NULL AUTO_INCREMENT,
	`name` varchar(50) NOT NULL,
	`email` varchar(255) NOT NULL UNIQUE,
	`password` varchar(255) NOT NULL,
	PRIMARY KEY (`ID`)
);",

"CREATE TABLE `calendars` (
	`ID` bigint NOT NULL AUTO_INCREMENT,
	`name` varchar(50) NOT NULL,
	`visibility` BINARY(1) NOT NULL,
	`id_creator` bigint NOT NULL,
	`date` DATE NOT NULL UNIQUE,
	PRIMARY KEY (`ID`)
);"

,"CREATE TABLE `calendar_user` (
	`id_user` bigint NOT NULL,
	`id_calendar` bigint NOT NULL
);"

,"CREATE TABLE `events` (
	`ID` bigint NOT NULL AUTO_INCREMENT,
	`id_creator` bigint NOT NULL,
	`title` varchar(50) NOT NULL,
	`start_date` DATE NOT NULL,
	`start_time` DATETIME,
	`end_date` DATE,
	`end_time` DATETIME,
	`visibility` BINARY(1) NOT NULL,
	`description` TEXT(255),
	`id_calendar` bigint NOT NULL,
	PRIMARY KEY (`ID`)
);"

,"CREATE TABLE `event_user` (
	`id_user` bigint NOT NULL,
	`id_event` bigint NOT NULL
);"

,"ALTER TABLE `calendars` ADD CONSTRAINT `calendars_fk0` FOREIGN KEY (`id_creator`) REFERENCES `users`(`ID`);
"
,"ALTER TABLE `calendar_user` ADD CONSTRAINT `calendar_user_fk0` FOREIGN KEY (`id_user`) REFERENCES `users`(`ID`);
"
,"ALTER TABLE `calendar_user` ADD CONSTRAINT `calendar_user_fk1` FOREIGN KEY (`id_calendar`) REFERENCES `calendars`(`ID`);
"
,"ALTER TABLE `events` ADD CONSTRAINT `events_fk0` FOREIGN KEY (`id_creator`) REFERENCES `users`(`ID`);
"
,"ALTER TABLE `events` ADD CONSTRAINT `events_fk1` FOREIGN KEY (`id_calendar`) REFERENCES `calendars`(`ID`);
"
,"ALTER TABLE `event_user` ADD CONSTRAINT `event_user_fk0` FOREIGN KEY (`id_user`) REFERENCES `users`(`ID`);
"
,"ALTER TABLE `event_user` ADD CONSTRAINT `event_user_fk1` FOREIGN KEY (`id_event`) REFERENCES `events`(`ID`);
"];

foreach ($queries as $query) {
    try {
        $statement = $connection->prepare($query);
        $statement->execute();
    } catch (Exception $e) {
        echo 'Erreur : ' . $e->getMessage() .'<br/>';
    }
}

