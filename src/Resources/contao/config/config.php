<?php

$GLOBALS['TL_HOOKS']['prepareFormData'][] = [
    EventListener\FormSpamListener::class,
    'onPrepareFormData'
];

$GLOBALS['TL_HOOKS']['compileFormFields'][] = [
    EventListener\FormSpamListener::class,
    'onCompileFormFields'
];
