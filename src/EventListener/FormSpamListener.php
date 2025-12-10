<?php

namespace SolidWork\ContaoSimpleSpamTrapBundle\EventListener;

use Contao\Form;
use Contao\Input;
use Contao\Message;
use Contao\Widget;

class FormSpamListener
{
    /**
     * Tracking, welche Formulare bereits Spam-Felder haben
     * @var array
     */
    private static $fieldsAdded = [];

    /**
     * Hook: prepareFormData
     * Validiert die Spam-Schutz-Felder beim Absenden
     */
    public function onPrepareFormData(array &$submitted, array $labels, array $fields, Form $form): void
    {
        // Zeitbasierte Prüfung
        if ($form->enable_time_spam) {
            $secondsRequired = (int)($form->time_spam_seconds ?: 8);
            $timestamp = Input::post('form_start_timestamp');

            if (!$timestamp || (time() - (int)$timestamp) < $secondsRequired) {
                Message::addError(sprintf(
                    'Sie haben das Formular zu schnell abgeschickt. Bitte warten Sie mindestens %d Sekunden.',
                    $secondsRequired
                ));
                unset($submitted);
                return;
            }
        }

        // Honeypot-Prüfung
        if ($form->enable_honeypot_spam) {
            if (Input::post('hp_field') !== '') {
                Message::addError('Spamverdacht: Das Formular konnte nicht gesendet werden.');
                unset($submitted);
                return;
            }
        }
    }

    /**
     * Hook: loadFormField
     * Wird für JEDES Formularfeld beim Rendern aufgerufen
     * Wir nutzen dies, um unsere Spam-Felder hinzuzufügen
     */
    public function onLoadFormField(Widget $widget, string $formId, array $formData, Form $form): Widget
    {
        // Prüfe, ob wir für dieses Formular bereits Felder hinzugefügt haben
        if (!isset(self::$fieldsAdded[$form->id])) {
            self::$fieldsAdded[$form->id] = true;

            // Füge die Spam-Schutz-Felder zum Formular hinzu
            $this->injectSpamFields($form);
        }

        return $widget;
    }

    /**
     * Fügt die Spam-Schutz-Felder dynamisch zum Formular hinzu
     */
    private function injectSpamFields(Form $form): void
    {
        // Array für neue Felder
        $newFields = [];

        // Zeitstempel-Feld hinzufügen (Hidden Field)
        if ($form->enable_time_spam) {
            $timestampField = new \stdClass();
            $timestampField->id = 0; // Virtuelle ID
            $timestampField->pid = $form->id;
            $timestampField->sorting = 1;
            $timestampField->tstamp = time();
            $timestampField->type = 'hidden';
            $timestampField->name = 'form_start_timestamp';
            $timestampField->label = '';
            $timestampField->mandatory = 0;
            $timestampField->rgxp = '';
            $timestampField->placeholder = '';
            $timestampField->value = time(); // Aktueller Zeitstempel

            $newFields[] = $timestampField;
        }

        // Honeypot-Feld hinzufügen (Text Field, versteckt via CSS)
        if ($form->enable_honeypot_spam) {
            $honeypotField = new \stdClass();
            $honeypotField->id = 0; // Virtuelle ID
            $honeypotField->pid = $form->id;
            $honeypotField->sorting = 2;
            $honeypotField->tstamp = time();
            $honeypotField->type = 'text';
            $honeypotField->name = 'hp_field';
            $honeypotField->label = '';
            $honeypotField->mandatory = 0;
            $honeypotField->rgxp = '';
            $honeypotField->placeholder = '';
            $honeypotField->class = 'hp';
            $honeypotField->value = '';
            // Wichtig: Verstecken via inline-Style
            $honeypotField->cssID = serialize(['', '']);

            $newFields[] = $honeypotField;
        }

        // Felder am Anfang des Formulars einfügen
        if (!empty($newFields)) {
            // Merge mit bestehenden Feldern
            $form->formFields = array_merge($newFields, (array)$form->formFields);
        }
    }
}