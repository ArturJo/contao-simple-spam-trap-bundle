# Contao Simple Spam Trap Bundle

Kurzbeschreibung: Dieses Bundle ergänzt Contao-Formulare um zwei einfache, aber effektive Spam-Schutzmechanismen:

- Zeitfalle (Timestamp): Das Formular darf erst nach einer Mindestzeit abgeschickt werden.
- Honeypot: Ein verstecktes Eingabefeld, das echte Nutzer nicht ausfüllen. Bots tappen hinein und werden blockiert.

## Funktionsumfang
- Zeitbasierter Schutz mit Standardwert 8 Sekunden (serverseitige Prüfung)
- Honeypot-Feld mit Barrierefreiheits-Vorkehrungen (tabindex="-1", aria-hidden)
- Deutsche Standard-Fehlermeldungen
- Frontend-CSS wird automatisch eingebunden: `bundles/contaosimplespamtrap/css/spam-trap.css`

## Installation
Mit Composer:

    composer require solidwork/contao-simple-spam-trap-bundle

Mit dem Contao Manager:
- Paket „solidwork/contao-simple-spam-trap-bundle“ suchen und installieren
- Anschließend den Contao Manager ausführen (Abhängigkeiten installieren)

Voraussetzungen laut composer.json:
- PHP: ^7.4 oder ^8.0
- Contao Core Bundle: ^4.13

## Verwendung in Contao (Formulargenerator)
Dieses Bundle registriert zwei zusätzliche Formularfeld-Typen, die Sie Ihrem Formular manuell hinzufügen können:

1. Feldtyp „Zeitbasierter Spam-Schutz“ (intern: TL_FFL['timestamp'])
   - Rendert ein verstecktes Feld mit dem aktuellen Zeitstempel.
   - Bei der Validierung wird geprüft, ob zwischen Anzeigen des Formulars und Absenden mindestens 8 Sekunden vergangen sind.

2. Feldtyp „Honeypot-Spam-Schutz“ (intern: TL_FFL['honeypot'])
   - Rendert ein unsichtbares Textfeld. Bleibt es leer, ist alles ok. Enthält es Text, wird das Formular als Spam abgewiesen.

Vorgehen:
- Inhalte → Formulargenerator → gewünschtes Formular öffnen → „Neues Feld“ → als Feldtyp „Zeitbasierter Spam-Schutz“ bzw. „Honeypot-Spam-Schutz“ auswählen → speichern.

Hinweise:
- Die Feldnamen vergeben Sie wie gewohnt selbst; es gibt keine fest verdrahteten Namen.
- Der Timestamp-Standardwert beträgt 8 Sekunden. Eine Anpassung ist technisch über ein DCA-Attribut `minTime` am Feld möglich (für fortgeschrittene Nutzer/Entwickler). Das Bundle liefert dafür kein eigenes Backend-Feld.

## Templates und Styling
- Honeypot verwendet das Template `form_honeypot` (Datei im Bundle vorhanden). Sie können dieses Template wie gewohnt im Theme überschreiben.
- Das Timestamp-Feld wird als Hidden-Input generiert und benötigt kein eigenes Template.
- CSS-Klassen:
  - `.spam-honeypot-wrapper`, `.widget-honeypot`, `.hp-field` (werden per CSS unsichtbar positioniert)
  - `.widget-timestamp` (ist standardmäßig ausgeblendet)

## Fehlermeldungen (Standard)
- Zu schnell abgeschickt: „Sie haben das Formular zu schnell abgeschickt. Bitte warten Sie mindestens X Sekunden.“
- Honeypot gefüllt: „Spamverdacht: Das Formular konnte nicht gesendet werden.“

## Troubleshooting
- Formular wird „zu schnell“ bemängelt: Warten Sie beim Testen mindestens 8 Sekunden, bevor Sie absenden. Eine Anpassung der Mindestzeit ist per DCA-Attribut `minTime` möglich (Entwickleranpassung).
- Häufige Honeypot-Auslöser: Prüfen Sie, ob eigenes JavaScript/CSS das Feld (Klasse `.hp-field`) befüllt oder sichtbar macht.
- CSS nicht geladen: Prüfen Sie, ob die Datei `bundles/contaosimplespamtrap/css/spam-trap.css` öffentlich erreichbar ist (Front-end Asset-Pipeline/Cache leeren).

## Kompatibilität
Getestet mit Contao 4.13 LTS.

## Lizenz
LGPL-3.0-or-later