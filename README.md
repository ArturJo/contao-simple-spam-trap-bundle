# Contao Simple Spam Trap Bundle

**Kurzbeschreibung:** Dieses Bundle erweitert den Contao-Formulargenerator um zwei einfache, aber effektive Spam-Schutzmechanismen:

- Zeitbasierter Schutz (Zeitfalle): Ein Formular darf erst nach X Sekunden abgesendet werden.
- Honeypot: Ein verstecktes Eingabefeld, das echte Nutzer nicht ausfüllen. Bots tappen hinein und werden blockiert.

## Funktionen
- Aktivierbarer 8-Sekunden-Standard mit frei wählbarer Zeitspanne
- Automatisches Hinzufügen eines versteckten Zeitstempelfeldes
- Automatisches Hinzufügen eines Honeypot-Feldes
- Benutzerfreundliche Fehlermeldungen im Frontend (deutsch)

## Installation
Mit Composer
    composer require solidwork/contao-simple-spam-trap-bundle

Mit dem Contao Manager
- Paket "solidwork/contao-simple-spam-trap-bundle" suchen und installieren
- Anschließend den Contao Manager ausführen (Abhängigkeiten installieren) und den Datenbank-Assistenten durchlaufen lassen, falls erforderlich

Voraussetzungen laut composer.json
- PHP: ^7.4 oder ^8.0
- Contao Core Bundle: ^4.13

## Verwendung in Contao
1. Im Backend unter Inhalte → Formulargenerator ein Formular öffnen.
2. In der Standard-Palette erscheint der neue Abschnitt "Einfacher Spam-Schutz" (simple_spam_legend) mit folgenden Feldern:
   - "Zeitbasierten Spam-Schutz aktivieren" (enable_time_spam)
   - "Zeit in Sekunden" (time_spam_seconds)
   - "Honeypot aktivieren" (enable_honeypot_spam)
3. Gewünschte Optionen aktivieren und speichern.

Das Bundle fügt beim Rendern automatisch folgende Felder hinzu:
- form_start_timestamp (hidden)
- hp_field (text, versteckt)

Bei Verstößen erhält der Nutzer Meldungen wie:
- "Sie haben das Formular zu schnell abgeschickt. Bitte warten Sie mindestens X Sekunden."
- "Spamverdacht: Das Formular konnte nicht gesendet werden."

## Hinweise und Best Practices
- CSS: Das Honeypot-Feld erhält die Klasse "hp" und wird zusätzlich inline mit display:none versteckt. Achten Sie darauf, dieses Feld nicht versehentlich sichtbar zu machen.
- Barrierefreiheit: Das Feld ist mit tabindex="-1" und ohne Label versehen.
- Caching: Der Zeitstempel wird serverseitig beim Rendern gesetzt. Bei statischem HTML-Caching kann der Zeitstempel in der Vergangenheit liegen – das ist unkritisch, da nur ein Minimum an Sekunden gefordert wird.
- Kompatibilität: Getestet mit Contao 4.13. Ältere Versionen werden nicht unterstützt.

## Troubleshooting
- Formular wird "zu schnell" bemängelt: Passen Sie den Wert "Zeit in Sekunden" im Formular an.
- Häufige Honeypot-Auslöser: Prüfen Sie, ob benutzerdefiniertes JavaScript/CSS das Feld "hp_field" beeinflusst.
- Keine neuen Felder sichtbar: Die Felder werden automatisch beim Rendern eingefügt. Im Frontend-HTML sollten Sie "form_start_timestamp" und "hp_field" sehen (hp_field ist versteckt).

## Lizenz
LGPL-3.0-or-later