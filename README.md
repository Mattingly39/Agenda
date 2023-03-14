# Agenda

Objectif : Réaliser un calendrier en ligne

---

## Cadre du projet
### Résumé

Le but de l'application est de pouvoir enregistrer des évènements selon une date précise ou une plage de date.
Les évènements peuvent être publics ou privés, et concerner un seul ou plusieurs
utilisateurs.
Les évènements sont enregistrés sur un agenda. Plusieurs agendas peuvent être créés.

### Planning
Le planning suivant a été spécifié :

* Initialisation du projet et maquettage : 2 jours
* Intégration des maquettes : 3 jours
* Modélisation et intégration de la base : 1 jour
* Développement de la partie agenda : 2 jours
* Développement de la partie évènements : 3 jours
* Développement de la partie utilisateur : 2 jours

Temps global : 13 jours

## Spécifications fonctionnelles

### Utilisateurs

L'application nécessite une inscription et être connecté afin de visualiser
les agendas publics et ses agendas privés.

Les utilisateurs ont un nom, un email et un mot de passe.

### Agendas

Un agenda est composé d'un nom.

Un agenda peut être public ou privé.

Un agenda privé peut être collaboratif. C'est à dire, des utilisateurs peuvent y être ajoutés
et ces utilisateurs peuvent ajouter des évènements.

Seul le créateur de l'agenda peut supprimer cet agenda.

### Evènements

Les évènements peuvent être ajoutés à un agenda.

Les évènements sont supprimables uniquement par le créateur de l'évènement.

Les évènements sont modifiables uniquement par le créateur de l'évènement.

Les évènements ont un nom, une description et des invités optionnels.

Il existe deux types d'évènements : Les évènements ponctuels (appelé tâche) ou les évènements classiques.

#### Tâches

Les tâches sont des évènements spécifiques. Ils contiennent qu'une date avec une heure.

#### Classiques

Les évènements classiques contiennent une date de début et une date de fin. Les heures sont optionnelles.

### Conception
### Agendas
* Les agendas sont filtrables par visibilité (public ou privé).
* Les agendas sont triables par date du plus récent évènement.
* Les agendas sont triables par date de création (croissant et décroissant).
* Les agendas sont filtrables si l'on est le créateur ou juste invité.

### Evènements
* Les évènements sont filtrables par type.
* Les évènements sont triables par date (croissant et décroissant).
* Un utilisateur ne peut pas créer deux évènements concurrents (sur la même plage de date). 

### Utilisateurs
* Les emails doivent être uniques.
