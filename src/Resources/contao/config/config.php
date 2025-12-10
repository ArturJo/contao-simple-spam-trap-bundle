<?php

// Register front end form fields.
$GLOBALS['TL_FFL']['honeypot'] = \SolidWork\ContaoSimpleSpamTrapBundle\Widget\HoneypotWidget::class;
$GLOBALS['TL_FFL']['timestamp'] = \SolidWork\ContaoSimpleSpamTrapBundle\Widget\TimestampWidget::class;

// Load CSS in the front end.
if ('FE' === TL_MODE) {
    $GLOBALS['TL_CSS'][] = 'bundles/contaosimplespamtrap/css/spam-trap.css|static';
}
