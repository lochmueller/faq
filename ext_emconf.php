<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'FAQ - Frequently Asked Questions',
    'description' => 'Basic FAQ (Frequently Asked Questions) extension in a clean extbase/fluid structure. Questions and Question categroies with a smart plugin structure.',
    'category' => 'fe',
    'version' => '5.1.2',
    'state' => 'stable',
    'author' => 'Tim Spiekerkötter, Tim Lochmüller',
    'author_email' => 'tl@hdnet.de',
    'author_company' => 'hdnet.de',
    'constraints' => [
        'depends' => [
            'php' => '7.4.0-8.1.99',
            'autoloader' => '7.2.0-7.99.99',
            'typo3' => '11.5.0-11.99.99',
        ],
    ],
];
