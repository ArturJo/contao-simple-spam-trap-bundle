<?php

$GLOBALS['TL_DCA']['tl_form']['palettes']['default'] .= ';{simple_spam_legend},enable_time_spam,time_spam_seconds,enable_honeypot_spam';

$GLOBALS['TL_DCA']['tl_form']['fields']['enable_time_spam'] = [
    'label'     => ['Zeitbasierten Spam-Schutz aktivieren', 'Aktiviert den 8-Sekunden-Spam-Schutz.'],
    'inputType' => 'checkbox',
    'default'   => 1,
    'eval'      => ['tl_class' => 'w50 m12'],
    'sql'       => "char(1) NOT NULL default '1'"
];

$GLOBALS['TL_DCA']['tl_form']['fields']['time_spam_seconds'] = [
    'label'     => ['Zeit in Sekunden', 'Anzahl Sekunden, die zwischen Formularaufruf und Versand liegen müssen.'],
    'inputType' => 'text',
    'default'   => 8,
    'eval'      => ['tl_class' => 'w50', 'rgxp' => 'digit'],
    'sql'       => "int(10) unsigned NOT NULL default '8'"
];

$GLOBALS['TL_DCA']['tl_form']['fields']['enable_honeypot_spam'] = [
    'label'     => ['Honeypot aktivieren', 'Aktiviert das versteckte Honeypot-Feld.'],
    'inputType' => 'checkbox',
    'default'   => 1,
    'eval'      => ['tl_class' => 'w50 m12'],
    'sql'       => "char(1) NOT NULL default '1'"
];
