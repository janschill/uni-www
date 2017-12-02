# WWW Semester-Projekt

## Aufgabenstellung

> Setzen Sie mit PHP (Backend) und HTML/CSS/Javascript (Frontend) eine Anwendung zur Nutzung im Browser um. Diese soll u.a. Nutzeranfragen über Formulare entgegennehmen, verarbeiten und die Ergebnisse als HTML-Seite anzeigen. Die Daten sollen dabei in einer Datenbank gespeichert werden.

### Dokumentation 
- Ziel und Funktionsumfang der Anwendung
- Aufbau der Anwendung
- Überlegungen zu den URIs
- Aufgabenteilung: Welcher Teil übernimmt welche Aufgaben?
- Warum wurde diese Aufteilung gewählt?
- Aufbau der Datenbank
- Nutzung von JS im Frontend
- Überlegungen zum Progressive Enhancement
- Besonderheiten
- Aufgetretene Probleme und deren Lösungen
- Wer hat was umgesetzt?
- Welche externen Komponenten, Scripte, CSS etc werden verwendet?
- Warum werden sie verwendet?
- Welchen vorhandenen Lösungen haben Sie als Vorlage oder Inspiration genutzt?
- Ggf. eine Erklärung, dass sie über die nötigen Rechte für externe Inhalte, Bilder und Komponenten verfügen, ggf. mit URIs. Keine Ausdrucke der AGBs beifügen!

### Mindestanforderungen (Backend)
- Objektorientierung
- PHP-Version 5.6.x oder 7.x
- Codestyle nach PSR-1 und PSR-2
- Verwendung des Front-Controller-Musters
- Kapselung von Request/Response in Objekte (z.B. Symfony/HTTPFoundation)
- Nur Frontend-Controller und Resourcen über HTTP erreichbar (/public als Documentroot)
- Keine Nutzung von globalen Variablen oder Singletons in Klassen und Funktionen
- Aufgabentrennung: z.B. Model (Datenverarbeitung), Kontroller, Template
- Verwendung einer Template-Engine mit Autoescaping (z.B. Twig)
- Formulare mit Überprüfung der Eingaben und Fehlermeldungen
- Nutzer-Login
- Speicherung der Daten in einer Datenbank
- Datenbank: SQLite (Kein Postgres, MySQL o.ä.)
- Nutzung des eingebauten Entwicklungs-Servers
- Die Abgabe muss alle genutzten Resourcen enthalten

### Mindestanforderungen (Frontend)
- Valides HTML
- Valides CSS
- Semantisches HTML
- Responsive Webdesign
- Progressive Enhancement: Kernfunktionen auch ohne JS
- Progressive Enhancement: Alle Inhalte ohne JS zu erreichen
- Keine JS-Frameworks
- Die Nutzung von CSS-Frameworks ist möglich (Bootstrap / Foundation) – aber keine Nutzung der dazugehörigen JS-Komponenten.
- Impressum
- Dokumentation als HTML-Seite(n)
