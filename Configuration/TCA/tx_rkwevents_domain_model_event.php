<?php
return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => true,
        //'sortby' => 'sorting',
        'default_sortby' => 'ORDER BY start DESC',
        'hideAtCopy' => true,
        'prependAtCopy' => true,
        'requestUpdate' => 'reg_required, online_event, ext_reg_link',

        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
		'searchFields' => 'title,subtitle,start,end,longitude,latitude,testimonials,description,schedule,target_group,partner,seats,costs_reg,costs_red,reg_required,reg_single,reg_end,ext_reg_link,document_type,department,categories,series,logos,currency,place,online_event, online_event_access_link,external_contact,be_user,add_info,presentations, sheet,gallery1,gallery2,reservation,workshop1,workshop2,workshop3,',
        'iconfile' => 'EXT:rkw_events/Resources/Public/Icons/tx_rkwevents_domain_model_event.gif'
    ],
    'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, subtitle, start, end, description, target_group, partner, add_info, schedule, testimonials, seats, costs_reg, costs_red, costs_red_condition, costs_tax, reg_required, reg_single, reg_end, ext_reg_link, document_type, department, series, currency, place, online_event,online_event_access_link, longitude, latitude, organizer, external_contact, be_user, presentations, sheet, gallery1, gallery2, reservation, workshop1, workshop2, workshop3',
    ],
    'types' => [
        '1' => [
            'showitem' => '
                sys_language_uid, l10n_parent, l10n_diffsource, hidden,--palette--;;1, title, subtitle,  start, end, reg_end, document_type, series, department, organizer,

                --div--;LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.tab_additionaldata,
                description, target_group, partner, add_info, schedule, testimonials,

                --div--;LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.tab_register,
                ' .
                // seats, costs_reg, costs_red, costs_red_condition, currency, costs_tax, reg_required, online_event, online_event_access_link, ext_reg_link, survey_before, survey_after, survey_after_mail_tstamp,
                'seats, costs_reg, costs_red, costs_red_condition, currency, costs_tax, reg_required, reg_single, online_event, online_event_access_link, ext_reg_link,
                
                --div--;LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.tab_place_contact,
                place, be_user, external_contact, longitude, latitude,

                --div--;LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.tab_gallery,
                //gallery1, gallery2, presentations, sheet,
                presentations, sheet,
                '

                // Hint: see /rkw_events/Configuration/TCA/Overrides/tx_rkwevents_domain_model_event.php
             //   --div--;LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.tab_reservation,
             //   reservation,

                //--div--;LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.tab_workshop,
				// workshop1, workshop2, workshop3,

                // also moved to event override file to set it to the end
              //  --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,
              //  starttime, endtime,'

            ,


            // add RTE
            'columnsOverrides' => [
                'description' => [
                    'defaultExtras' => 'richtext:rte_transform[mode=ts_links]'
                ],
                'schedule' => [
                    'defaultExtras' => 'richtext:rte_transform[mode=ts_links]'
                ],
                'testimonials' => [
                    'defaultExtras' => 'richtext:rte_transform[mode=ts_links]'
                ],
            ]
        ],
    ],
    'palettes' => [
        '1' => ['showitem' => ''],
    ],
    'columns' => [

        'sys_language_uid' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => [
                    ['LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1],
                    ['LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0],
                ],
                'default' => 0
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_rkwevents_domain_model_event',
                'foreign_table_where' => 'AND tx_rkwevents_domain_model_event.pid=###CURRENT_PID### AND tx_rkwevents_domain_model_event.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],

        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'starttime' => [
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => [
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y')),
                ],
            ],
        ],
        'endtime' => [
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => [
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y')),
                ],
            ],
        ],

        'title' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim, required'
            ],
        ],
        'subtitle' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.subtitle',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'start' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.start',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime, required',
                'checkbox' => 0,
                'default' => 0,
            ],
        ],
        'end' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.end',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime, required',
                'checkbox' => 0,
                'default' => 0,
            ],
        ],
        'longitude' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.longitude',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'readOnly' =>1,

            ],
        ],
        'latitude' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.latitude',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'readOnly' =>1,
            ],
        ],
        // only needed for SQL-query with distance calculation!
        'distance' => [
            'type' => 'passthrough'
        ],

        'testimonials' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.testimonials',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
                'wizards' => [
                    'RTE' => [
                        'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_rte.gif',
                        'notNewRecords'=> 1,
                        'RTEonly' => 1,
                        'module' => [
                            'name' => 'wizard_rte',
                        ],
                        'title' => 'LLL:EXT:cms/locallang_ttc.xlf:bodytext.W.RTE',
                        'type' => 'script'
                    ],
                ],
            ],
        ],
        'description' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim, required',
                'wizards' => [
                    'RTE' => [
                        'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_rte.gif',
                        'notNewRecords'=> 1,
                        'RTEonly' => 1,
                        'module' => [
                            'name' => 'wizard_rte',
                        ],
                        'title' => 'LLL:EXT:cms/locallang_ttc.xlf:bodytext.W.RTE',
                        'type' => 'script'
                    ],
                ],
            ],
        ],
        'target_group' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.target_group',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 5,
                'eval' => 'trim',
            ],
        ],
        'schedule' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.schedule',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
                'wizards' => [
                    'RTE' => [
                        'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_rte.gif',
                        'notNewRecords'=> 1,
                        'RTEonly' => 1,
                        'module' => [
                                'name' => 'wizard_rte',
                        ],
                        'title' => 'LLL:EXT:cms/locallang_ttc.xlf:bodytext.W.RTE',
                        'type' => 'script'
                    ],
                ],
            ],
        ],
        'partner' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.partner',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
                'wizards' => [
                    'RTE' => [
                        'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_rte.gif',
                        'notNewRecords'=> 1,
                        'RTEonly' => 1,
                        'module' => [
                            'name' => 'wizard_rte',
                        ],
                        'title' => 'LLL:EXT:cms/locallang_ttc.xlf:bodytext.W.RTE',
                        'type' => 'script'
                    ],
                ],
            ],
        ],
        'seats' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.seats',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int, required'
            ],
        ],
        'costs_reg' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.costs_reg',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim, double2, required'
            ],
        ],
        'costs_red' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.costs_red',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim, double2'
            ],
        ],

        'costs_red_condition' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.costs_red_condition',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'costs_tax' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.costs_tax',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.costs_tax.I.0', 0],
                    ['LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.costs_tax.I.1', 1],
                    ['LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.costs_tax.I.2', 2],
                ],
            ],
        ],
        'reg_required' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.reg_required',
            'config' => [
                'type' => 'check',
                'default' => 1
            ]
        ],
        'reg_single' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.reg_single',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
            'displayCond' =>'USER:RKW\\RkwEvents\\UserFunctions\\TcaDisplayCondition->displayIfDisableInternalRegistrationIsFalse',
        ],
        'reg_end' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.reg_end',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
            ],
            'displayCond' =>'USER:RKW\\RkwEvents\\UserFunctions\\TcaDisplayCondition->displayIfDisableInternalRegistrationIsFalse',
        ],
        'ext_reg_link' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.ext_reg_link',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'wizards' => [
                    '_PADDING' => 2,
                    'link' => [
                        'type' => 'popup',
                        'title' => 'LLL:EXT:cms/locallang_ttc.xlf:header_link_formlabel',
                        'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_link.gif',
                        'module' => [
                            'name' => 'wizard_link',
                        ],
                        'JSopenParams' => 'height=400,width=550,status=0,menubar=0,scrollbars=1',
                        'params' => [
                            // List of tabs to hide in link window. Allowed values are:
                            // file, mail, page, spec, folder, url
                            'blindLinkOptions' => 'mail,file,page,spec,folder',

                            // allowed extensions for file
                            //'allowedExtensions' => 'mp3,ogg',
                        ],

                    ],
                ],
                'softref' => 'typolink'
            ],
        ],
        'document_type' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.document_type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_rkwbasics_domain_model_documenttype',
                'foreign_table_where' => 'AND tx_rkwbasics_domain_model_documenttype.type = "events" AND tx_rkwbasics_domain_model_documenttype.sys_language_uid = ###REC_FIELD_sys_language_uid### ORDER BY tx_rkwbasics_domain_model_documenttype.name ASC',
                'maxitems'      => 1,
                'minitems'      => 1,
                'size'          => 5,
            ],
        ],
        'department' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.department',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_rkwbasics_domain_model_department',
                'foreign_table_where' => 'AND tx_rkwbasics_domain_model_department.sys_language_uid = ###REC_FIELD_sys_language_uid### ORDER BY tx_rkwbasics_domain_model_department.name ASC',
                'maxitems'      => 1,
                'minitems'      => 1,
                'size'          => 5,
            ],
        ],
        'categories' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.categories',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'sys_category',
                'foreign_table_where' => ' AND ((\'###PAGE_TSCONFIG_IDLIST###\' <> \'0\' AND FIND_IN_SET(sys_category.parent,\'###PAGE_TSCONFIG_IDLIST###\')) OR (\'###PAGE_TSCONFIG_IDLIST###\' = \'0\')) AND sys_category.sys_language_uid IN (-1, 0) ORDER BY sys_category.title ASC',
                'MM' => 'sys_category_record_mm',
                'MM_opposite_field' => 'items',
                'MM_match_fields' => [
                    'tablenames' => 'tx_rkwevents_domain_model_event',
                    'fieldname' => 'categories',
                ],
                'size' => 10,
                'autoSizeMax' => 50,
                'maxitems' => 9999,
                'minitems'      => 0,
                /*'renderMode' => 'tree',
                'treeConfig' => [
                    'parentField' => 'parent',
                    'appearance' => [
                        'expandAll' => TRUE,
                        'showHeader' => TRUE,
                    ],
                ],
                */
            ],
        ],
        'series' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.series',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_rkwevents_domain_model_eventseries',
                'foreign_table_where' => 'AND tx_rkwevents_domain_model_eventseries.sys_language_uid = ###REC_FIELD_sys_language_uid### ORDER BY tx_rkwevents_domain_model_eventseries.name ASC',
                'maxitems'      => 1,
                'size'          => 5,

            ],
        ],

        'logos' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.logos',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'image',
                ['maxitems' => 9999],
                'jpg, png, gif'
            ),
        ],

        'currency' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.currency',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'static_currencies',
                'default' => 49,
                'minitems' => 0,
                'maxitems' => 1,
                'appearance' => [
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],
        ],
        'place' => [
            'displayCond' =>  'FIELD:online_event:REQ:false',
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.place',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_rkwevents_domain_model_eventplace',
                'foreign_table_where' => 'AND ((\'###PAGE_TSCONFIG_IDLIST###\' <> \'0\' AND FIND_IN_SET(tx_rkwevents_domain_model_eventplace.pid,\'###PAGE_TSCONFIG_IDLIST###\')) OR (\'###PAGE_TSCONFIG_IDLIST###\' = \'0\')) AND tx_rkwevents_domain_model_eventplace.sys_language_uid = ###REC_FIELD_sys_language_uid### ORDER BY tx_rkwevents_domain_model_eventplace.name ASC, tx_rkwevents_domain_model_eventplace.city ASC',
                'maxitems'      => 1,
                'minitems' 		=>1,
                'size'          => 5,
                /*
                    'wizards' => [
                        '_VERTICAL' => 1,
                        'edit' => [
                            'type' => 'popup',
                            'title' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventplace.edit',
                            'icon' => 'edit2.gif',
                            'module' => [
                                'name' => 'wizard_edit',
                            ],
                            'popup_onlyOpenIfSelected' => 1,
                            'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1'
                        ],

                        'add' => [
                            'type' => 'script',
                            'title' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventplace.add',
                            'icon' => 'add.gif',
                            'params' => [
                                'table' => 'tx_rkwevents_domain_model_eventplace',
                                'pid' => '###CURRENT_PID###',
                                'setValue' => 'prepend'
                            ],
                            'module' => [
                                'name' => 'wizard_add'
                            ],
                            'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1'
                        ],
                    ],
                */
            ],
        ],
        'online_event' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.online_event',
            'config' => [
                'type' => 'check',
                'default' => 0,
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.online_event.I.enabled'
                    ],
                ],
            ],
        ],
        'online_event_access_link' => [
            'displayCond' =>  'FIELD:online_event:REQ:true',
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.online_event_access_link',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'wizards' => [
                    '_PADDING' => 2,
                    'link' => [
                        'type' => 'popup',
                        'title' => 'LLL:EXT:cms/locallang_ttc.xlf:header_link_formlabel',
                        'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_link.gif',
                        'module' => [
                            'name' => 'wizard_link',
                        ],
                        'JSopenParams' => 'height=400,width=550,status=0,menubar=0,scrollbars=1',
                        'params' => [
                            // List of tabs to hide in link window. Allowed values are:
                            // file, mail, page, spec, folder, url
                            'blindLinkOptions' => 'mail,file,page,spec,folder',

                            // allowed extensions for file
                            //'allowedExtensions' => 'mp3,ogg',
                        ],

                    ],
                ],
                'softref' => 'typolink'
            ],
        ],
        'external_contact' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.external_contact',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_rkwevents_domain_model_eventcontact',
                'foreign_table_where' => 'AND ((\'###PAGE_TSCONFIG_IDLIST###\' <> \'0\' AND FIND_IN_SET(tx_rkwevents_domain_model_eventcontact.pid,\'###PAGE_TSCONFIG_IDLIST###\')) OR (\'###PAGE_TSCONFIG_IDLIST###\' = \'0\')) AND tx_rkwevents_domain_model_eventcontact.sys_language_uid = ###REC_FIELD_sys_language_uid### ORDER BY tx_rkwevents_domain_model_eventcontact.last_name ASC, tx_rkwevents_domain_model_eventcontact.company ASC, tx_rkwevents_domain_model_eventcontact.email ASC',
                'maxitems'      => 9999,
                'size'          => 5,
                'wizards' => [
                    '_VERTICAL' => 1,
                    'edit' => [
                        'type' => 'popup',
                        'title' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventcontact.edit',
                        'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_edit.gif',
                        'module' => [
                            'name' => 'wizard_edit',
                        ],
                        'popup_onlyOpenIfSelected' => 1,
                        'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1'
                    ],

                    'add' => [
                        'type' => 'script',
                        'title' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventcontact.add',
                        'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_add.gif',
                        'params' => [
                            'table' => 'tx_rkwevents_domain_model_eventcontact',
                            'pid' => '###CURRENT_PID###',
                            'setValue' => 'prepend'
                        ],
                        'module' => [
                            'name' => 'wizard_add'
                        ],
                        'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1'
                    ],
                ],
            ],
        ],

		/*
		// Re-added below, if rkw_authors is active
        'internal_contact' => [
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
        ],
		*/

        'organizer' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.organizer',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_rkwevents_domain_model_eventorganizer',
                'foreign_table_where' => 'AND tx_rkwevents_domain_model_eventorganizer.sys_language_uid = ###REC_FIELD_sys_language_uid### ORDER BY tx_rkwevents_domain_model_eventorganizer.last_name ASC, tx_rkwevents_domain_model_eventorganizer.company ASC, tx_rkwevents_domain_model_eventorganizer.email ASC',
                'maxitems'      => 9999,
                'minitems' 		=> 1,
                'size'          => 5,
                'wizards' => [
                    '_VERTICAL' => 1,
                    'edit' => [
                        'type' => 'popup',
                        'title' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventorganizer.edit',
                        'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_edit.gif',
                        'module' => [
                            'name' => 'wizard_edit',
                        ],
                        'popup_onlyOpenIfSelected' => 1,
                        'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1'
                ],

                'add' => [
                        'type' => 'script',
                        'title' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_eventorganizer.add',
                        'icon' => 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_add.gif',
                        'params' => [
                            'table' => 'tx_rkwevents_domain_model_eventorganizer',
                            'pid' => '###CURRENT_PID###',
                            'setValue' => 'prepend'
                        ],
                        'module' => [
                            'name' => 'wizard_add'
                        ],
                        'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1'
                    ],
                ],
            ],
        ],

        'be_user' => [
            'displayCond' => [
                'AND' => [
                    'FIELD:ext_reg_link:REQ:false',
                    'FIELD:reg_required:REQ:true',
                    'USER:RKW\\RkwEvents\\UserFunctions\\TcaDisplayCondition->displayIfDisableInternalRegistrationIsFalse',
                ],
            ],
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.be_user',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'be_users',
                'foreign_table_where' => 'AND be_users.deleted = 0 AND be_users.email != "" ORDER BY be_users.username',
                'maxitems'      => 9999,
                'minitems'      => 1,
                'size'          => 5,
            ],
        ],

        'add_info' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.add_info',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'add_info',
                [
                    'maxitems' => 9999,
                ],
                'pdf'
            ),
        ],

        'presentations' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.presentations',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'presentation',
                [
                    'maxitems' => 9999,
                ],
                'pdf,ppt'
            ),
        ],

        'sheet' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.sheet',
            'config' => [
                'type' => 'inline',
                'internal_type' => 'db',
                'foreign_table' => 'tx_rkwevents_domain_model_eventsheet',
                'foreign_field' => 'event',
                'foreign_sortby' => 'sorting',
                'show_thumbs' => true,
                'maxitems'      => 9999,
                'size'          => 5,
                'appearance' => [
                    'elementBrowserType' => 'db'
                ],
            ],

        ],
        'gallery1' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.gallery1',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'image',
                [
                    'maxitems' => 9999,
                    'foreign_match_fields' => [
                        'fieldname' => 'gallery1'
                    ],
                ],
                'jpg, png, gif'
            ),
        ],
        'gallery2' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.gallery2',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'image',
                [
                    'maxitems' => 9999,
                    'foreign_match_fields' => [
                        'fieldname' => 'gallery2'
                    ],
                ],
                'jpg, png, gif'
            ),
        ],
        'reservation' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.reservations',
            'config' => [
            	'type' => 'inline',
                'foreign_table' => 'tx_rkwevents_domain_model_eventreservation',
                'foreign_field' => 'event',
                'maxitems'      => 9999,
                'size'          => 5,
                'appearance' => [
                    'elementBrowserType' => 'db',
                    'collapseAll' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1,
                    'enabledControls' => [
                        'info' => true,
                        'new' => false,
                        'dragdrop' => false,
                        'sort' => false,
                        'hide' => false,
                        'delete' => true,
                        'localize' => false
                    ],
                ],
            ],
        ],

		'workshop1' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.workshop1',
			'config' => [
				'type' => 'inline',
				'foreign_table' => 'tx_rkwevents_domain_model_eventworkshop',
				'foreign_table_where' => 'AND tx_rkwevents_domain_model_eventworkshop.deleted = 0',
				'maxitems'      => 9999,
				'minitems'      => 0,
				'size'          => 5,
			],
		],
		'workshop2' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.workshop2',
			'config' => [
				'type' => 'inline',
				'foreign_table' => 'tx_rkwevents_domain_model_eventworkshop',
				'foreign_table_where' => 'AND tx_rkwevents_domain_model_eventworkshop.deleted = 0',
				'maxitems'      => 9999,
				'minitems'      => 0,
				'size'          => 5,
			],
		],
		'workshop3' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.workshop3',
			'config' => [
				'type' => 'inline',
				'foreign_table' => 'tx_rkwevents_domain_model_eventworkshop',
				'foreign_table_where' => 'AND tx_rkwevents_domain_model_eventworkshop.deleted = 0',
				'maxitems'      => 9999,
				'minitems'      => 0,
				'size'          => 5,
			],
		],
        /* Re-added below, if rkw_survey is active
        'survey_before' => [
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
        ],
        'survey_after' => [
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
        ],
        'survey_after_mail_tstamp' => [
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
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y')],
                ],
            ],
        ],
        */
        'reminder_mail_tstamp' => [
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:rkw_events/Resources/Private/Language/locallang_db.xlf:tx_rkwevents_domain_model_event.reminder_mail_tstamp',
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
        ],
    ],
];
