<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "rkw_events"
 *
 * Auto generated by Extension Builder 2015-07-15
 *
 * Manual updates:
 * Only the data in the array - anything else is removed by next write.
 * "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
	'title' => 'RKW Events',
	'description' => 'Provides a possibility to list and handle events',
	'category' => 'plugin',
    'author' => 'Carlos Meyer, Maximilian Fäßler, Steffen Kroggel, Christian Dilger',
    'author_email' => 'cm@davitec.de, maximilian@faesslerweb.de, developer@steffenkroggel.de, c.dilger@addorange.de',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => '1',
	'createDirs' => '',
	'clearCacheOnLoad' => 0,
	'version' => '8.7.19',
	'constraints' => [
        'depends' => [
            'typo3' => '7.6.0-8.7.99',
            'static_info_tables' => '6.3.7',
            'rkw_basics' => '8.7.22-8.7.99',
            'rkw_mailer' => '8.7.0-8.7.99'
        ],
		'conflicts' => [
		],
		'suggests' => [
		],
	],
];