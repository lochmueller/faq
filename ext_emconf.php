<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'FAQ - Frequently Asked Questions',
    'description' => 'Basic FAQ (Frequently Asked Questions) extension in a clean extbase/fluid structure. Questions and Question categroies with a smart plugin structure.',
    'category' => 'fe',
    'version' => '6.0.0',
    'state' => 'stable',
    'author' => 'Tim Spiekerkötter, Tim Lochmüller',
    'author_email' => 'tl@hdnet.de',
    'author_company' => 'hdnet.de',
    'constraints' => [
        'depends' => [
            'php' => '8.2.0-8.5.99',
            'typo3' => '13.4.0-14.3.99',
            'form' => '13.4.0-14.3.99',
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'HDNET\\Faq\\' => 'Classes'
        ]
    ],
];
