<?php

namespace SolidWork\ContaoSimpleSpamTrapBundle\Widget;

use Contao\Widget;

class TimestampWidget extends Widget
{
    /**
     * Template für das Widget
     */
    protected $strTemplate = 'form_widget';

    /**
     * CSS-Klasse für das Widget
     */
    protected $strClass = 'widget widget-hidden';

    /**
     * Minimale Wartezeit in Sekunden
     */
    private $minSeconds = 8;

    /**
     * Generiert das HTML für das Zeitstempel-Feld
     */
    public function generate()
    {
        return sprintf(
            '<input type="hidden" name="%s" id="ctrl_%s" value="%s">',
            $this->strName,
            $this->strId,
            time() // Aktueller Zeitstempel
        );
    }

    /**
     * Validierung - prüft ob genug Zeit vergangen ist
     */
    public function validate()
    {
        $timestamp = (int)$this->getPost($this->strName);
        $currentTime = time();

        // Hole die konfigurierte Mindestzeit (falls gesetzt)
        if (isset($this->minTime) && $this->minTime > 0) {
            $this->minSeconds = (int)$this->minTime;
        }

        // Prüfe ob das Formular zu schnell abgeschickt wurde
        if (!$timestamp || ($currentTime - $timestamp) < $this->minSeconds) {
            $this->addError(sprintf(
                'Sie haben das Formular zu schnell abgeschickt. Bitte warten Sie mindestens %d Sekunden.',
                $this->minSeconds
            ));
        }

        return parent::validate();
    }

    /**
     * Setter für die Mindestzeit
     */
    public function __set($key, $value)
    {
        if ($key === 'minTime') {
            $this->minSeconds = (int)$value;
        }

        parent::__set($key, $value);
    }
}