<?php

$EM_CONF[$_EXTKEY] = [
    'title'          => 'FAQ - Frequently Asked Questions',
    'description'    => 'Basic FAQ (Frequently Asked Questions) extension in a clean extbase/fluid structure. Questions and Question categroies with a smart plugin structure.',
    'category'       => 'fe',
    'version'        => '2.1.0',
    'state'          => 'stable',
    'author'         => 'Tim Spiekerkötter, Tim Lochmüller',
    'author_email'   => 'tl@hdnet.de',
    'author_company' => 'hdnet.de',
    'constraints'    => [
        'depends'   => [
            'autoloader' => '3.0.0-6.0.99',
            'typo3'      => '7.6.0-9.5.99',
        ],
        'conflicts' => [],
        'suggests'  => [],
    ],
];
