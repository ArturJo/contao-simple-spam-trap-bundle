<?php

$GLOBALS['TL_HOOKS']['prepareFormData'][] = [
    \SolidWork\ContaoSimpleSpamTrapBundle\EventListener\FormSpamListener::class,
    'onPrepareFormData'
];

$GLOBALS['TL_HOOKS']['compileFormFields'][] = [
    \SolidWork\ContaoSimpleSpamTrapBundle\EventListener\FormSpamListener::class,
    'onCompileFormFields'
];
