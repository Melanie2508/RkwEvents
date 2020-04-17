<?php

// Extend TCA when rkw_authors is available
if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('rkw_authors')) {

	$GLOBALS['TCA']['tx_rkwevents_domain_model_event']['columns']['internal_contact'] = [
		'exclude' => 0,
		'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.internal_contact',
		'config' => [
			'type' => 'select',
			'renderType' => 'selectMultipleSideBySide',
			'foreign_table' => 'tx_rkwauthors_domain_model_authors',
			'foreign_table_where' => 'AND tx_rkwauthors_domain_model_authors.internal = 1 AND ((\'###PAGE_TSCONFIG_IDLIST###\' <> \'0\' AND FIND_IN_SET(tx_rkwauthors_domain_model_authors.pid,\'###PAGE_TSCONFIG_IDLIST###\')) OR (\'###PAGE_TSCONFIG_IDLIST###\' = \'0\')) AND tx_rkwauthors_domain_model_authors.sys_language_uid = ###REC_FIELD_sys_language_uid### ORDER BY tx_rkwauthors_domain_model_authors.last_name ASC',
			'maxitems'      => 9999,
			'minitems'      => 0,
			'size'          => 5,
		],
	];
	$GLOBALS['TCA']['tx_rkwevents_domain_model_event']['types']['1']['showitem'] = str_replace(', external_contact,', ', internal_contact, external_contact,', $GLOBALS['TCA']['tx_rkwevents_domain_model_event']['types']['1']['showitem']);
}

// Extend TCA when rkw_projects is available
if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('rkw_projects')) {
    $GLOBALS['TCA']['tx_rkwevents_domain_model_event']['columns']['project'] = [
        'exclude' => 0,
        'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.project',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectMultipleSideBySide',
            'foreign_table' => 'tx_rkwprojects_domain_model_projects',
            'foreign_table_where' => 'AND ((\'###PAGE_TSCONFIG_IDLIST###\' <> \'0\' AND FIND_IN_SET(tx_rkwprojects_domain_model_projects.pid,\'###PAGE_TSCONFIG_IDLIST###\')) OR (\'###PAGE_TSCONFIG_IDLIST###\' = \'0\')) AND tx_rkwprojects_domain_model_projects.sys_language_uid = ###REC_FIELD_sys_language_uid### ORDER BY tx_rkwprojects_domain_model_projects.short_name ASC',
            'maxitems'      => 1,
            'minitems'      => 0,
            'size'          => 5,
        ],
    ];
    $GLOBALS['TCA']['tx_rkwevents_domain_model_event']['types']['1']['showitem'] = str_replace(', department,', ', department, project,', $GLOBALS['TCA']['tx_rkwevents_domain_model_event']['types']['1']['showitem']);
}

// Extend TCA when rkw_survey is available
if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('rkw_survey')) {

    $GLOBALS['TCA']['tx_rkwevents_domain_model_event']['columns']['survey_before'] = [
        'exclude' => 0,
        'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.survey_before',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectMultipleSideBySide',
            'foreign_table' => 'tx_rkwsurvey_domain_model_survey',
            'foreign_table_where' => 'AND ((\'###PAGE_TSCONFIG_IDLIST###\' <> \'0\' AND FIND_IN_SET(tx_rkwsurvey_domain_model_survey.pid,\'###PAGE_TSCONFIG_IDLIST###\')) OR (\'###PAGE_TSCONFIG_IDLIST###\' = \'0\')) AND tx_rkwsurvey_domain_model_survey.deleted = 0 AND tx_rkwsurvey_domain_model_survey.hidden = 0',
            'maxitems'      => 1,
            'minitems' 		=> 0,
            'size'          => 5,
        ],
    ];

    $GLOBALS['TCA']['tx_rkwevents_domain_model_event']['columns']['survey_after'] = [
        'exclude' => 0,
        'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.survey_after',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectMultipleSideBySide',
            'foreign_table' => 'tx_rkwsurvey_domain_model_survey',
            'foreign_table_where' => 'AND ((\'###PAGE_TSCONFIG_IDLIST###\' <> \'0\' AND FIND_IN_SET(tx_rkwsurvey_domain_model_survey.pid,\'###PAGE_TSCONFIG_IDLIST###\')) OR (\'###PAGE_TSCONFIG_IDLIST###\' = \'0\')) AND tx_rkwsurvey_domain_model_survey.deleted = 0 AND tx_rkwsurvey_domain_model_survey.hidden = 0',
            'maxitems'      => 1,
            'minitems' 		=> 0,
            'size'          => 5,
        ],
    ];

    $GLOBALS['TCA']['tx_rkwevents_domain_model_event']['columns']['survey_after_mail_tstamp'] = [
        'exclude' => 1,
        'l10n_mode' => 'mergeIfNotBlank',
        'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.survey_after_mail_tstamp',
        'config' => [
            'type' => 'input',
            'size' => 13,
            'max' => 20,
            'eval' => 'datetime',
            'checkbox' => 0,
            'default' => 0,
            'readOnly' => 1,
            'range' => [
                'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y')),
            ],
        ],
    ];

    // @toDo: Not sure if this lines should be shown (was also commented out before in the top of the file],
    //$GLOBALS['TCA']['tx_rkwevents_domain_model_event']['types']['1']['showitem'] = str_replace(', ext_reg_link,', ', ext_reg_link,survey_before,survey_after,survey_after_mail_tstamp,', $GLOBALS['TCA']['tx_rkwevents_domain_model_event']['types']['1']['showitem']);

    // add tab only, if internal registration is not disabled
    $tcaDisplayCondition = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwEvents\\UserFunctions\\TcaDisplayCondition');
    if ($tcaDisplayCondition->displayIfDisableInternalRegistrationIsFalse()) {
        // add tab, if internal registration is allowed
        $GLOBALS['TCA']['tx_rkwevents_domain_model_event']['types']['1']['showitem'] .=
            '--div--;LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.tab_reservation,
            reservation,';
    }
    // add access tab in both cases to the end
    $GLOBALS['TCA']['tx_rkwevents_domain_model_event']['types']['1']['showitem'] .=
        '--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
        starttime, endtime,';


}
