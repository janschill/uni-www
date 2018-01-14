# WWW Semester-Projekt

## Aufgabenstellung

> Setzen Sie mit PHP (Backend) und HTML/CSS/Javascript (Frontend) eine Anwendung zur Nutzung im Browser um. Diese soll u.a. Nutzeranfragen über Formulare entgegennehmen, verarbeiten und die Ergebnisse als HTML-Seite anzeigen. Die Daten sollen dabei in einer Datenbank gespeichert werden.

## Dokumentation 
### Ziel und Funktionsumfang der Anwendung
Wir haben uns entschieden das GOM-Projekt aus dem letzten Semester weiterzuführen, um so ein _komplettes_ Webseiten-Projekt einmal entwickelt zu haben.
Die Aufgabe in GOM war es eine statische Webseite mit HTML und CSS umzusetzen, hier wählten wir als Projekt eine persönliche Webseite für Jan Schill, auf der, wie in einem Portfolio, verschiedenste Projekte aufgelistet werden.
Nun haben wir dieses Projekt mit PHP so erweitert, dass es möglich ist die Projekte dynamisch anzulegen und zu verwalten. Außerdem können Blogeinträge verfasst werden.
Es gibt verschiedene Benutzergruppen, welchen es ermöglicht entweder Einträge zu verfassen oder zu löschen.

### Aufbau der Anwendung
Die Anwendung ist nach dem MVC-Softwaremuster aufgebaut. Es gibt das `Model`, welches die Datenbank Verarbeitung übernimmt, den `View`, welcher per Twig-Templating, den Content an den Browser gibt und den `Controller`, welcher die Kommunikation zwischen `Model` und `View` übernimmt – also die Daten aus der Datenbank vom `Model` entgegennimmt und dann ans `View` schickt.

Da es ein Admin-Panel gibt, in dem der Nutzer, mit den nötigen Rechten Einstellungen und Einträge verwalten kann, unterscheiden wir zwischen Controller, welche für das Admin-Panel sind und die Controller die im Frontend, also das was auf der Webseite angezeigt wird.
Zwischen den Controllern haben wir auch versucht die auszuteilen, so dass eher mehr Controller haben, um so das doch recht umfangreiche Projekt sinnvoll zu gliedern.
Da, dabei viele Redundanzen auftreten, haben wir auch _Oberklassen_ angelegt, die an _Unterklassen_ Methoden und Variablen vererben.

Um in das Backend zu gelangen, haben wir uns an die heutigen CMS angelehnt und es einfach im Pfad unter `/login` versteckt.

### Überlegungen zu den URIs 
Das Routing als Struktur:
```
|-- /
    |-- /login
    |-- /logout
    |-- /about
    |-- /blog
        |-- /{id}
    |-- /projects
        |-- /{id}
    |-- /admin
        |-- /about
        |-- /blog
            |-- /new
            |-- /delete/{id}
            |-- /edit/{id}
            |-- /{author}
        |-- /projects
            |-- /new
            |-- /delete/{id}
            |-- /edit/{id}
            |-- /{author}        
        |-- /media
            |-- /new
            |-- /delete/{id}
        |-- /settings
            |-- /tag/delete{id}
            |-- /category/delete{id}
```
_hier ueberlegungen_

### Externe Komponenten
- `gulp.js`
- `Sass`
- `Composer`
- `Twig`
- `BEM`
- CKEditor

### Inspiration
Da unser Projekt Richtung Blog und ein wenig in Content-Management-System geht, haben wir uns ein wenig an dem Backend von Wordpress orientiert. 
Also, so etwas wie das Dashboard und das Anlegen von neuen Blogeinträgen.

### Probleme
Wir hatten anfangs Probleme mit dem Verständniss von Twig, Composer und wie PHP dies nutzt.
Und auch Probleme PHP richtig anzuwenden, was möglich ist, wie man es dann umsetzt und die _neue_ `->`-Notation zu verwenden und nicht Punktnotation, war wahrscheinlich die häufigste Fehlerquelle.


- (Aufbau der Anwendung)
- (Aufgabenteilung: Welcher Teil übernimmt welche Aufgaben?)
- (Überlegungen zu den URIs)
- (Warum wurde diese Aufteilung gewählt?)
- (Aufbau der Datenbank)
- Nutzung von JS im Frontend
- Überlegungen zum Progressive Enhancement
- Besonderheiten
- Wer hat was umgesetzt?
- Warum werden sie verwendet?

Wir haben uns entschieden die Hausarbeit aus dem letzten Semester in GOM (Frontend) weiterzufuehren, damit wir ein komplettes realistisches Webseiten-Projekt umsetzen koennen. Da dort das Frontend entwickelt wurde, muessen wir bei diesem Projekt nicht von 0 anfangen und koennen uns auf das Neugelernte konzentrieren und anwenden.

## Auflistung der Implementierungen
### Backend
#### Minimalanforderungen
- :white_check_mark: Objektorientierung
- :white_check_mark: PHP-Version 5.6.x oder 7.x
- :white_check_mark: Codestyle nach PSR-1 und PSR-2
- :white_check_mark: Verwendung des Front-Controller-Musters
- :white_check_mark: Kapselung von Request/Response in Objekte (z.B. Symfony/HTTPFoundation)
- :white_check_mark: Nur Frontend-Controller und Resourcen über HTTP erreichbar (/public als Documentroot)
- :white_check_mark: Keine Nutzung von globalen Variablen oder Singletons in Klassen und Funktionen
- :white_check_mark: Aufgabentrennung: z.B. Model (Datenverarbeitung), Kontroller, Template
- :white_check_mark: Verwendung einer Template-Engine mit Autoescaping (z.B. Twig)
- Formulare mit Überprüfung der Eingaben und Fehlermeldungen
- :white_check_mark: Nutzer-Login
- :white_check_mark: Speicherung der Daten in einer Datenbank
- :white_check_mark: Datenbank: SQLite (Kein Postgres, MySQL o.ä.)
- :white_check_mark: Nutzung des eingebauten Entwicklungs-Servers

#### Mögliche Erweiterungen
- :white_check_mark: Erlaubt und erwünscht: Nutzung von weiteren PHP-Komponenten (z.B. Symfony-Komponenten)
- :white_check_mark: Verwendung eines Routers (z.B. Symfony/Router)
- :white_check_mark: Unterschiedliche Rechte-Gruppen
- :white_check_mark: Schlanke Kontroller
- :white_check_mark: Nutzung von Composer
- :white_check_mark: Nutzung von Autoloading
- :white_check_mark: Logging nach PSR-3
- Rest-Api (für Frontend evtl. nötig)
- PHPUnit-Tests
- :white_check_mark: größer Umfang

### Frontend
#### Minimalanforderungen
- :white_check_mark: Valides HTML
- :white_check_mark: Valides CSS
- :white_check_mark: Semantisches HTML
- Responsive Webdesign
- :white_check_mark: Progressive Enhancement: Kernfunktionen auch ohne JS
- :white_check_mark: Progressive Enhancement: Alle Inhalte ohne JS zu erreichen
- Keine JS-Frameworks
- :white_check_mark: Die Nutzung von CSS-Frameworks ist möglich (Bootstrap / Foundation) – aber keine Nutzung der dazugehörigen JS-Komponenten.
- Impressum
- :white_check_mark: Dokumentation als HTML-Seite(n)

#### Mögliche Erweiterungen
- :white_check_mark: CSFR-Token im Formular
- Progressive Enhancement mit Javascript
- Web-App im ROCA-Stil (Resource-oriented Client Architecture)
- größer Umfang
