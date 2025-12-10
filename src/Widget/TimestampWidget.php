<?php

namespace SolidWork\ContaoSimpleSpamTrapBundle\Widget;

use Contao\Widget;

class TimestampWidget extends Widget
{
    /**
     * Template.
     *
     * @var string
     */
    protected $strTemplate = 'form_timestamp';

    /**
     * The widget should be submitted and validated.
     *
     * @var bool
     */
    protected $blnSubmitInput = true;

    /**
     * CSS class.
     *
     * @var string
     */
    protected $strClass = 'widget widget-timestamp';

    /**
     * Minimum number of seconds between form display and submit.
     *
     * @var int
     */
    protected $minSeconds = 8;

    /**
     * Map the custom DCA field "minTime" to the internal property.
     *
     * {@inheritdoc}
     */
    public function __set($key, $value): void
    {
        if ('minTime' === $key) {
            $this->minSeconds = (int) $value;
        }

        parent::__set($key, $value);
    }

    /**
     * Validate the timestamp.
     */
    public function validate(): void
    {
        $submitted = (int) $this->getPost($this->strName);
        $now = time();

        if (!$submitted || ($now - $submitted) < $this->minSeconds) {
            $this->addError(
                $GLOBALS['TL_LANG']['ERR']['timestamp']
                ?? sprintf('Sie haben das Formular zu schnell abgeschickt. Bitte warten Sie mindestens %d Sekunden.', $this->minSeconds)
            );
        }

        parent::validate();
    }

    /**
     * Generate a hidden field with the current timestamp.
     *
     * @return string
     */
    public function generate(): string
    {
        return sprintf(
            '<input type="hidden" name="%s" id="ctrl_%s" value="%s">',
            $this->strName,
            $this->strId,
            time()
        );
    }
}
