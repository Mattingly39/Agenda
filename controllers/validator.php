<?php

function validate($array): string
{
    $valide = "";
    foreach ($array as $fieldname => $conditions) {
        foreach ($conditions as $condition) {
            switch ($condition) {
                case 'required':
                    if (empty($_POST[$fieldname])) {
                        $valide = $valide . "<br /> Le champs " . $fieldname . " est obligatoire.";
                    }
                    break;
                case 'email':
                    if(!filter_var($_POST[$fieldname], FILTER_VALIDATE_EMAIL)) {
                         $valide = $valide . "<br />L'adresse mail est invalide.";
                    }
                    break;
                case 'max255':
                    if (strlen($_POST[$fieldname]) > 255 && !empty($_POST[$fieldname])) {
                        $valide = $valide . "<br /> Le champs " . $fieldname . " doit contenir moins de 255 charactères.";
                    }
                    break;
                case 'max50':
                    if (strlen($_POST[$fieldname]) > 50 && !empty($_POST[$fieldname])) {
                        $valide = $valide . "<br /> Le champs " . $fieldname . " doit contenir moins de 50 charactères.";
                    }
                    break;
            }
        }
    }
    return $valide;
}
