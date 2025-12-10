<?php

namespace SolidWork\ContaoSimpleSpamTrapBundle\EventListener;

use Contao\Form;
use Contao\Input;
use Contao\Message;

class FormSpamListener
{
    public function onPrepareFormData(array &$submitted, array $labels, array $fields, Form $form): void
    {
        if ($form->enable_time_spam) {
            $secondsRequired = (int) ($form->time_spam_seconds ?: 8);
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

        if ($form->enable_honeypot_spam) {
            if (Input::post('hp_field') !== '') {
                Message::addError('Spamverdacht: Das Formular konnte nicht gesendet werden.');
                unset($submitted);
                return;
            }
        }
    }

    public function onCompileFormFields(array $fields, string $formId, Form $form): array
    {
        if ($form->enable_time_spam) {
            $fields[] = [
                'name'  => 'form_start_timestamp',
                'type'  => 'hidden',
                'value' => time()
            ];
        }

        if ($form->enable_honeypot_spam) {
            $fields[] = [
                'name'       => 'hp_field',
                'type'       => 'text',
                'label'      => '',
                'class'      => 'hp',
                'value'      => '',
                'attributes' => 'autocomplete="off" tabindex="-1" style="display:none"'
            ];
        }

        return $fields;
    }
}
