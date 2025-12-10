<?php

namespace SolidWork\ContaoSimpleSpamTrapBundle\Widget;

use Contao\Widget;

class HoneypotWidget extends Widget
{
    /**
     * Template für das Widget
     */
    protected $strTemplate = 'form_honeypot';

    /**
     * CSS-Klasse für das Widget
     */
    protected $strClass = 'widget widget-text widget-honeypot';

    /**
     * Generiert das HTML für das Honeypot-Feld
     */
    public function generate()
    {
        return sprintf(
            '<input type="text" name="%s" id="ctrl_%s" class="hp-field" value="" ' .
            'style="position:absolute !important; left:-9999px !important; width:1px !important; height:1px !important; opacity:0 !important;" ' .
            'tabindex="-1" autocomplete="off" aria-hidden="true">',
            $this->strName,
            $this->strId
        );
    }

    /**
     * Validierung (immer leer lassen - wenn nicht leer = Spam!)
     */
    public function validate()
    {
        $value = $this->getPost($this->strName);

        // Wenn das Feld ausgefüllt ist = Spam erkannt
        if ($value !== '' && $value !== null) {
            $this->addError('Spamverdacht: Das Formular konnte nicht gesendet werden.');
        }

        return parent::validate();
    }
}