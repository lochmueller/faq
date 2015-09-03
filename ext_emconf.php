<?php

$EM_CONF[$_EXTKEY] = array(
    'title'          => 'FAQ',
    'description'    => 'Basic FAQ extension in a clean extbase/fluid structure.',
    'category'       => 'misc',
    'version'        => '0.1.0',
    'state'          => 'beta',
    'author'         => 'Tim Spiekerkötter, Tim Lochmüller',
    'author_email'   => 'tl@hdnet.de',
    'author_company' => 'hdnet.de',
    'constraints'    => array(
        'depends'   => array(
            'autoloader' => '1.7.0-1.99.99',
            'typo3'      => '6.2.0-7.99.99',
        ),
        'conflicts' => array(),
        'suggests'  => array(),
    ),
);
