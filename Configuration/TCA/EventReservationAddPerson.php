<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rkwevents_domain_model_eventreservationaddperson', 'EXT:rkw_events/Resources/Private/Language/locallang_csh_tx_rkwevents_domain_model_eventreservationaddperson.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rkwevents_domain_model_eventreservationaddperson');
$GLOBALS['TCA']['tx_rkwevents_domain_model_eventreservationaddperson'] = array(
	'ctrl' => array(
        'adminOnly' => 1,
        'title'	=> 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventreservationaddperson',
		'label' => 'last_name',
		'label_alt' => 'first_name',
		'label_alt_force' => TRUE,
        'default_sortby' => 'ORDER BY last_name ASC',
        'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'delete' => 'deleted',
		'enablecolumns' => array(

		),
		'searchFields' => 'event_reservation, salutation,first_name,last_name,',
		'iconfile' => 'EXT:rkw_events/Resources/Public/Icons/tx_rkwevents_domain_model_eventreservationaddperson.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'event_reservation, salutation, first_name, last_name',
	),
	'types' => array(
		'1' => array('showitem' => 'event_reservation, salutation, first_name, last_name'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(

        'event_reservation' => array(
            'config' => array(
                'type' => 'passthrough',
            ),
        ),

        'salutation' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventreservationaddperson.salutation',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array('LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventreservationaddperson.salutation.I.99', 99),
                    array('LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventreservationaddperson.salutation.I.0', 0),
                    array('LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventreservationaddperson.salutation.I.1', 1)
                ),
                'size' => 1,
                'maxitems' => 1,
                'eval' => ''
            ),
        ),
        'tx_rkwregistration_title' => array(
            'label'=>'LLL:EXT:rkw_registration/Resources/Private/Language/locallang_db.xlf:tx_rkwregistration_domain_model_frontenduser.tx_rkwregistration_title',
            'exclude' => 0,
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_rkwregistration_domain_model_title',
                'foreign_table_where' => 'AND tx_rkwregistration_domain_model_title.hidden = 0 AND tx_rkwregistration_domain_model_title.deleted = 0 ORDER BY name ASC',
                'minitems' => 0,
                'maxitems' => 1,
                'items' => array(
                    array('LLL:EXT:rkw_registration/Resources/Private/Language/locallang_db.xlf:tx_rkwregistration_domain_model_frontenduser.tx_rkwregistration_title.I.neutral', 0),
                ),
            ),
        ),
		'first_name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventreservationaddperson.first_name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'last_name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventreservationaddperson.last_name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
	),
);
