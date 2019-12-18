<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
    {

        //=================================================================
        // Configure Plugins
        //=================================================================
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'RKW.' . $extKey,
            'Pi1',
            array(
                'Event' => 'myEvents, archive, list, listSimple, show, showAddInfo, showSheet, showGalleryOne, showGalleryTwo',
                'EventReservation' => 'new, create, update, delete, remove, optIn, edit',
                'Ajax' => 'filter, more, moreArchive'
            ),
            // non-cacheable actions
            array(
                'Event' => 'myEvents, show, list, listSimple, showAddInfo, showSheet, showGalleryOne, showGalleryTwo',
                'EventReservation' => 'new, create, update, delete, remove, optIn, edit',
                'Ajax' => 'filter, more, moreArchive'
            )
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'RKW.' . $extKey,
            'Eventmaps',
            array(
                'Event' => 'maps'
            ),
            // non-cacheable actions
            array(
                'Event' => 'maps'
            )
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'RKW.' . $extKey,
            'Eventinfo',
            array(
                'Event' => 'info'
            ),
            // non-cacheable actions
            array(
                'Event' => 'info'
            )
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'RKW.' . $extKey,
            'Eventtitle',
            array(
                'Event' => 'title'
            ),
            // non-cacheable actions
            array(
                'Event' => 'title'
            )
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'RKW.' . $extKey,
            'Galleryone',
            array(
                'Event' => 'showGalleryOne'
            )
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'RKW.' . $extKey,
            'Gallerytwo',
            array(
                'Event' => 'showGalleryTwo'
            )
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'RKW.' . $extKey,
            'Myeventreservation',
            array(
                'Event' => 'myEvents'
            ),
            // non-cacheable actions
            array(
                'Event' => 'myEvents'
            )
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'RKW.' . $extKey,
            'Seriesproposals',
            array(
                'Event' => 'seriesProposals'
            ),
            // non-cacheable actions
            array(
                'Event' => 'seriesProposals'
            )
        );


        //=================================================================
        // Register Hook for Geodata and reservation cleanup on copy
        //=================================================================
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][$extKey] = 'RKW\\RkwEvents\\Hooks\\TceMainHooks';
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass'][$extKey] = 'RKW\\RkwEvents\\Hooks\\TceMainHooks';

        //=================================================================
        //  Register Command Controller
        //=================================================================
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'RKW\\RkwEvents\\Controller\\EventCommandController';


        //=================================================================
        // Register Signal-Slots
        //=================================================================
        /**
         * @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher
         */
        $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');

        if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('rkw_registration')) {
            $signalSlotDispatcher->connect(
                'RKW\\RkwRegistration\\Tools\\Registration',
                \RKW\RkwRegistration\Tools\Registration::SIGNAL_AFTER_CREATING_OPTIN_EXISTING_USER . 'RkwEvents',
                'RKW\\RkwEvents\\Service\\RkwMailService',
                'optInRequest'
            );

            $signalSlotDispatcher->connect(
                'RKW\\RkwRegistration\\Tools\\Registration',
                \RKW\RkwRegistration\Tools\Registration::SIGNAL_AFTER_CREATING_OPTIN_USER . 'RkwEvents',
                'RKW\\RkwEvents\\Service\\RkwMailService',
                'optInRequest'
            );

            $signalSlotDispatcher->connect(
                'RKW\\RkwRegistration\\Tools\\Registration',
                \RKW\RkwRegistration\Tools\Registration::SIGNAL_AFTER_DELETING_USER,
                'RKW\\RkwEvents\\Controller\\EventReservationController',
                'removeAllOfUserSignalSlot'
            );
        }

        $signalSlotDispatcher->connect(
            'RKW\\RkwEvents\\Controller\\EventReservationController',
            \RKW\RkwEvents\Controller\EventReservationController::SIGNAL_AFTER_RESERVATION_CREATED_USER,
            'RKW\\RkwEvents\\Service\\RkwMailService',
            'confirmReservationUser'
        );

        $signalSlotDispatcher->connect(
            'RKW\\RkwEvents\\Controller\\EventReservationController',
            \RKW\RkwEvents\Controller\EventReservationController::SIGNAL_AFTER_RESERVATION_CREATED_PENDING_USER,
            'RKW\\RkwEvents\\Service\\RkwMailService',
            'confirmReservationPendingUser'
        );

        $signalSlotDispatcher->connect(
            'RKW\\RkwEvents\\Controller\\EventReservationController',
            \RKW\RkwEvents\Controller\EventReservationController::SIGNAL_AFTER_RESERVATION_CREATED_ADMIN,
            'RKW\\RkwEvents\\Service\\RkwMailService',
            'confirmReservationAdmin'
        );

        $signalSlotDispatcher->connect(
            'RKW\\RkwEvents\\Controller\\EventReservationController',
            \RKW\RkwEvents\Controller\EventReservationController::SIGNAL_AFTER_RESERVATION_UPDATE_USER,
            'RKW\\RkwEvents\\Service\\RkwMailService',
            'updateReservationUser'
        );

        $signalSlotDispatcher->connect(
            'RKW\\RkwEvents\\Controller\\EventReservationController',
            \RKW\RkwEvents\Controller\EventReservationController::SIGNAL_AFTER_RESERVATION_UPDATE_ADMIN,
            'RKW\\RkwEvents\\Service\\RkwMailService',
            'updateReservationAdmin'
        );

        $signalSlotDispatcher->connect(
            'RKW\\RkwEvents\\Controller\\EventReservationController',
            \RKW\RkwEvents\Controller\EventReservationController::SIGNAL_AFTER_RESERVATION_DELETE_USER,
            'RKW\\RkwEvents\\Service\\RkwMailService',
            'deleteReservationUser'
        );

        $signalSlotDispatcher->connect(
            'RKW\\RkwEvents\\Controller\\EventReservationController',
            \RKW\RkwEvents\Controller\EventReservationController::SIGNAL_AFTER_RESERVATION_DELETE_ADMIN,
            'RKW\\RkwEvents\\Service\\RkwMailService',
            'deleteReservationAdmin'
        );

        //=================================================================
        // Register Logger
        //=================================================================
        $GLOBALS['TYPO3_CONF_VARS']['LOG']['RKW'][$extKey]['writerConfiguration'] = array(

            // configuration for WARNING severity, including all
            // levels with higher severity (ERROR, CRITICAL, EMERGENCY)
            \TYPO3\CMS\Core\Log\LogLevel::WARNING => array(

                // add a FileWriter
                'TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter' => array(
                    // configuration for the writer
                    'logFile' => 'typo3temp/logs/tx_rkwevents.log'
                )
            ),
        );

    },
    $_EXTKEY
);

