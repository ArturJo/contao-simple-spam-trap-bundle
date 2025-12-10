<?php

namespace SolidWork\ContaoSimpleSpamTrapBundle\EventListener;

use Contao\Form;
use Contao\FormFieldModel;
use Contao\Widget;

class FormSpamListener
{
    /**
     * Tracking, welche Formulare bereits erweitert wurden
     */
    private static $processedForms = [];

    /**
     * Hook: loadFormField
     * Fügt die Spam-Schutz-Widgets zum Formular hinzu
     */
    public function onLoadFormField(Widget $widget, string $formId, array $formData, Form $form): Widget
    {
        // Nur einmal pro Formular ausführen
        if (isset(self::$processedForms[$form->id])) {
            return $widget;
        }

        self::$processedForms[$form->id] = true;

        // Sammle neue Felder
        $newFields = [];

        // Füge Zeitstempel-Widget hinzu
        if ($form->enable_time_spam) {
            $timestampModel = new \stdClass();
            $timestampModel->id = 0;
            $timestampModel->pid = $form->id;
            $timestampModel->sorting = 0;
            $timestampModel->type = 'timestamp';
            $timestampModel->name = 'form_start_timestamp';
            $timestampModel->label = '';
            $timestampModel->minTime = (int)($form->time_spam_seconds ?: 8);

            $newFields[] = $timestampModel;
        }

        // Füge Honeypot-Widget hinzu
        if ($form->enable_honeypot_spam) {
            $honeypotModel = new \stdClass();
            $honeypotModel->id = 0;
            $honeypotModel->pid = $form->id;
            $honeypotModel->sorting = 1;
            $honeypotModel->type = 'honeypot';
            $honeypotModel->name = 'hp_field';
            $honeypotModel->label = '';

            $newFields[] = $honeypotModel;
        }

        // Füge die neuen Felder am Anfang des Formulars ein
        if (!empty($newFields)) {
            $form->formFields = array_merge($newFields, (array)$form->formFields);
        }

        return $widget;
    }
}