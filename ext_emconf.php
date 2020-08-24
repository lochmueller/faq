<?php

$EM_CONF[$_EXTKEY] = [
    'title'          => 'FAQ - Frequently Asked Questions',
    'description'    => 'Basic FAQ (Frequently Asked Questions) extension in a clean extbase/fluid structure. Questions and Question categroies with a smart plugin structure.',
    'category'       => 'fe',
    'version'        => '3.1.0-dev',
    'state'          => 'stable',
    'author'         => 'Tim Spiekerkötter, Tim Lochmüller',
    'author_email'   => 'tl@hdnet.de',
    'author_company' => 'hdnet.de',
    'constraints'    => [
        'depends'   => [
            'php' => '7.2.0-7.4.99',
            'autoloader' => '6.0.0-6.2.99',
            'typo3'      => '9.5.0-9.5.99',
        ],
        'conflicts' => [],
        'suggests'  => [],
    ],
];
