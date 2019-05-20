<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_rkwevents_domain_model_eventreservation', 'EXT:rkw_events/Resources/Private/Language/locallang_csh_tx_rkwevents_domain_model_eventreservation.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_rkwevents_domain_model_eventreservation');
$GLOBALS['TCA']['tx_rkwevents_domain_model_eventreservation'] = array(
	'ctrl' => array(
        //'adminOnly' => 1,
        'title'	=> 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventreservation',
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
		'searchFields' => 'event,remark,add_person,fe_user,salutation,first_name,last_name,company,address,zip,city,phone,email,server_host,',
		'iconfile' => 'EXT:rkw_events/Resources/Public/Icons/tx_rkwevents_domain_model_eventreservation.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'event, fe_user, salutation, first_name, last_name, company, address, zip, city, phone, email, remark, add_person, server_host,',
	),
	'types' => array(
		'1' => array('showitem' => 'event, fe_user, salutation, first_name, last_name, company, address, zip, city, phone, email, remark, add_person, server_host'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(

		'remark' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventreservation.remark',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			)
		),
        'add_person' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventreservation.add_person',
            'config' => array(
                'type' => 'inline',
                'foreign_table' => 'tx_rkwevents_domain_model_eventreservationaddperson',
                'foreign_field' => 'event_reservation',
                'maxitems'      => 4,
                'size'          => 5,
                'appearance' => array(
                    'elementBrowserType' => 'db',
                    'collapseAll' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1,
                    'enabledControls' => array(
                        'info' => true,
                        'new' => false,
                        'dragdrop' => false,
                        'sort' => false,
                        'hide' => false,
                        'delete' => true,
                        'localize' => false
                    ),
                ),
                /*'wizards' => array(
                    '_VERTICAL' => 1,
                    'edit' => array(
                        'type' => 'popup',
                        'title' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.edit',
                        'module' => array(
                            'name' => 'wizard_edit',
                        ),
                        'popup_onlyOpenIfSelected' => 1,
                        'icon' => 'edit2.gif',
                        'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1'
                    ),
                    'add' => array(
                        'type' => 'script',
                        'title' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.add',
                        'icon' => 'add.gif',
                        'params' => array(
                            'table' => 'tx_rkwevents_domain_model_eventreservationaddperson',
                            'pid' => '###CURRENT_PID###',
                            'setValue' => 'prepend'
                        ),
                        'module' => array(
                            'name' => 'wizard_add'
                        )
                    ),
                )
                */
            ),
        ),
		'fe_user' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventreservation.fe_user',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'fe_users',
				'foreign_table_where' => 'AND fe_users.deleted = 0  AND fe_users.disable = 0 AND fe_users.email <> "" ORDER BY fe_users.username',
				'minitems' => 1,
				'maxitems' => 1,
			),
		),
        'event' => array(
            'config' => array(
                'type' => 'passthrough',
            ),
        ),
		'salutation' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventreservationaddress.salutation',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventreservationaddress.salutation.I.99', 99),
					array('LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventreservationaddress.salutation.I.0', 0),
					array('LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventreservationaddress.salutation.I.1', 1)
				),
				'default' => 99,
				'size' => 1,
				'maxitems' => 1,
			)
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
			'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventreservationaddress.first_name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim, required'
			)
		),
		'last_name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventreservationaddress.last_name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim, required'
			)
		),
		'company' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventreservationaddress.company',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'address' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventreservationaddress.address',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim, required'
			)
		),
		'zip' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventreservationaddress.zip',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim, required'
			)
		),
		'city' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventreservationaddress.city',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim, required'
			)
		),
		'phone' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventreservationaddress.phone',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'fax' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventreservationaddress.fax',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'email' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventreservationaddress.email',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,email'
			)
		),
		'server_host' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventreservation.server_host',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
				'readOnly' => 1,
			),
		),
        'shipping_address' => array(
            'label'=>'LLL:EXT:rkw_order/Resources/Private/Language/locallang_db.xlf:tx_rkwregistration_domain_model_eventreservation.shippingaddress',
            'exclude' => 0,
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_rkwregistration_domain_model_shippingaddress',
                'foreign_table_where' => 'AND tx_rkwregistration_domain_model_shippingaddress.hidden = 0 AND tx_rkwregistration_domain_model_shippingaddress.deleted = 0 ORDER BY name ASC',
                'minitems' => 0,
                'maxitems' => 1,
                'items' => array(
                    array('LLL:EXT:rkw_order/Resources/Private/Language/locallang_db.xlf:tx_rkwregistration_domain_model_shippingaddress.please_choose', 0),
                ),
            ),
        ),

	),
);
