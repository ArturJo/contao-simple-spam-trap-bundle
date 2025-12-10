<?php

namespace SolidWork\ContaoSimpleSpamTrapBundle\Widget;

use Contao\Widget;

class HoneypotWidget extends Widget
{
    /**
     * Template.
     *
     * @var string
     */
    protected $strTemplate = 'form_honeypot';

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
    protected $strClass = 'widget widget-honeypot';

    /**
     * Generate the honeypot field.
     *
     * @return string
     */
    public function generate(): string
    {
        return sprintf(
            '<input type="text" name="%s" id="ctrl_%s" class="hp-field" value="" autocomplete="off" tabindex="-1" aria-hidden="true">',
            $this->strName,
            $this->strId
        );
    }

    /**
     * Validate: the field must stay empty.
     */
    public function validate(): void
    {
        $value = $this->getPost($this->strName);

        if ('' !== (string) $value) {
            $this->addError($GLOBALS['TL_LANG']['ERR']['honeypot'] ?? 'Spamverdacht: Das Formular konnte nicht gesendet werden.');
        }

        parent::validate();
    }
}
