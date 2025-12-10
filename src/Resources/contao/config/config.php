<?php

$GLOBALS['TL_HOOKS']['prepareFormData'][] = [
    \SolidWork\ContaoSimpleSpamTrapBundle\EventListener\FormSpamListener::class,
    'onPrepareFormData'
];

$GLOBALS['TL_HOOKS']['loadFormField'][] = [
    \SolidWork\ContaoSimpleSpamTrapBundle\EventListener\FormSpamListener::class,
    'onLoadFormField'
];

// CSS für Honeypot-Feld laden
if (TL_MODE === 'FE') {
    $GLOBALS['TL_CSS'][] = 'bundles/contaosimplespamtrap/css/spam-trap.css|static';
}