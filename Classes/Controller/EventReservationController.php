<?php

namespace RKW\RkwEvents\Controller;

use RKW\RkwEvents\Helper\DivUtility;
use \RKW\RkwBasics\Helper\Common;
use \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Class EventReservationController
 *
 * @author Carlos Meyer <cm@davitec.de>
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEvents
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class EventReservationController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * Signal name for use in ext_localconf.php
     *
     * @const string
     */
    const SIGNAL_AFTER_RESERVATION_CREATED_ADMIN = 'afterReservationCreatedAdmin';

    /**
     * Signal name for use in ext_localconf.php
     *
     * @const string
     */
    const SIGNAL_AFTER_RESERVATION_CREATED_USER = 'afterReservationCreatedUser';

    /**
     * Signal name for use in ext_localconf.php
     *
     * @const string
     */
    const SIGNAL_AFTER_RESERVATION_CREATED_PENDING_USER = 'afterReservationCreatedPendingUser';

    /**
     * Signal name for use in ext_localconf.php
     *
     * @const string
     */
    const SIGNAL_AFTER_RESERVATION_UPDATE_ADMIN = 'afterUpdateReservationAdmin';

    /**
     * Signal name for use in ext_localconf.php
     *
     * @const string
     */
    const SIGNAL_AFTER_RESERVATION_UPDATE_USER = 'afterUpdateReservationUser';

    /**
     * Signal name for use in ext_localconf.php
     *
     * @const string
     */
    const SIGNAL_AFTER_RESERVATION_DELETE_ADMIN = 'afterDeleteReservationAdmin';

    /**
     * Signal name for use in ext_localconf.php
     *
     * @const string
     */
    const SIGNAL_AFTER_RESERVATION_DELETE_USER = 'afterDeleteReservationUser';

    /**
     * eventRepository
     *
     * @var \RKW\RkwEvents\Domain\Repository\EventRepository
     * @inject
     */
    protected $eventRepository = null;

    /**
     * eventReservationRepository
     *
     * @var \RKW\RkwEvents\Domain\Repository\EventReservationRepository
     * @inject
     */
    protected $eventReservationRepository = null;

    /**
     * eventReservationAddPersonRepository
     *
     * @var \RKW\RkwEvents\Domain\Repository\EventReservationAddPersonRepository
     * @inject
     */
    protected $eventReservationAddPersonRepository = null;

    /**
     * BackendUserRepository
     *
     * @var \RKW\RkwEvents\Domain\Repository\BackendUserRepository
     * @inject
     */
    protected $backendUserRepository;

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     * @inject
     */
    protected $objectManager;

    /**
     * Persistence Manager
     *
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager;


    /**
     * frontendUserRepository
     *
     * @var \RKW\RkwEvents\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected $frontendUserRepository = null;

    /**
     * logged FrontendUser
     *
     * @var \RKW\RkwEvents\Domain\Model\FrontendUser
     */
    protected $frontendUser = null;

    /**
     * @var \TYPO3\CMS\Core\Log\Logger
     */
    protected $logger;

    /**
     * targetGroupRepository
     *
     * @var \RKW\RkwBasics\Domain\Repository\TargetGroupRepository
     * @inject
     */
    protected $targetGroupRepository = null;

    /**
     * initializeAction
     * !! The whole controller depends on the RkwRegistration Extension. Throw an error on dependency problems !!
     *
     * @return void
     */
    public function initializeAction()
    {
        if (!\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('rkw_registration')) {
            $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::ERROR, sprintf('Error while initializing EventReservationController: Required extension RkwRegistration is not loaded!'));
            trigger_error('Error: Operation not allowed.', E_USER_ERROR);
            exit;
        }
    }


    /**
     * action new
     *
     * @param \RKW\RkwEvents\Domain\Model\Event $event
     * @param \RKW\RkwEvents\Domain\Model\EventReservation $newEventReservation
     * @ignorevalidation $event
     * @ignorevalidation $newEventReservation
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     */
    public function newAction(\RKW\RkwEvents\Domain\Model\Event $event, \RKW\RkwEvents\Domain\Model\EventReservation $newEventReservation = null)
    {
        // Hinweis falls man sich bereits für diese Veranstaltung angemeldet hat wäre super (nur eingeloggt user)!
        if ($this->getFrontendUser()) {

            $eventReservationResult = $this->eventReservationRepository->findByEventAndFeUser($event, $this->getFrontendUser());
            if (count($eventReservationResult)) {

                // already registered!
                $this->addFlashMessage(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('eventReservationController.error.exists', 'rkw_events')
                );

                $uri = $this->uriBuilder->reset()
                    ->setTargetPageUid($this->settings['myEventsPid'])
                    ->uriFor('myEvents', null, 'Event', null, 'Pi1');

                $this->addFlashMessage(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'eventReservationController.hint.reservations',
                        'rkw_events',
                        array(
                            0 => "<a href='" . $uri . "'>",
                            1 => "</a>",
                        )
                    )
                );

                // already registered
                $this->redirect('show', 'Event', null, array('event' => $event), intval($this->settings['showPid']));
                //===
            }
        }

        if (!$newEventReservation) {
            $newEventReservation = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwEvents\\Domain\\Model\\EventReservation');
        }

        $newEventReservation->setEvent($event);

        $this->view->assign('event', $event);
        $this->view->assign('newEventReservation', $newEventReservation);
        $this->view->assign('frontendUser', $this->getFrontendUser());
        $this->view->assign('targetGroups', $this->targetGroupRepository->findAll());
        $this->view->assign('validFrontendUserEmail', \RKW\RkwRegistration\Tools\Registration::validEmail($this->getFrontendUser()));

    }


    /**
     * action create
     *
     * @param \RKW\RkwEvents\Domain\Model\EventReservation $newEventReservation
     * @param integer $terms
     * @param integer $privacy
     * @validate $newEventReservation \RKW\RkwEvents\Validation\Validator\EventReservationValidator
     * @return void
     * @throws \RKW\RkwRegistration\Exception
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    public function createAction(\RKW\RkwEvents\Domain\Model\EventReservation $newEventReservation, $terms = null, $privacy = null)
    {
        // 1. Check for existing reservations based on email.
        $frontendUser = $this->frontendUserRepository->findByUsername($newEventReservation->getEmail());
        if (count($frontendUser)) {

            $eventReservationResult = $this->eventReservationRepository->findByEventAndFeUser($newEventReservation->getEvent(), $frontendUser);
            if (count($eventReservationResult)) {

                // already registered!
                $this->addFlashMessage(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'eventReservationController.error.exists', 'rkw_events'
                    ),
                    '',
                    \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
                );

                $uri = $this->uriBuilder->reset()
                    ->setTargetPageUid($this->settings['myEventsPid'])
                    ->uriFor('myEvents', null, 'Event', null, 'Pi1');

                $this->addFlashMessage(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'eventReservationController.hint.reservations',
                        'rkw_events',
                        array(
                            0 => "<a href='" . $uri . "'>",
                            1 => "</a>",
                        )
                    )
                );

                // already registered
                $this->redirect('show', 'Event', null, array('event' => $newEventReservation->getEvent()), intval($this->settings['showPid']));
                //===
            }
        }

        // 2. Check available seats
        if (!DivUtility::hasFreeSeats($newEventReservation->getEvent(), $newEventReservation)) {

            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'eventReservationController.error.seats', 'rkw_events'
                ),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('show', 'Event', null, array('event' => $newEventReservation->getEvent()), $this->settings['showPid']);
            //===
        }

        // 3. Check if registration-time is over since the user may have been waiting too long
        if (DivUtility::hasRegTimeEnded($newEventReservation->getEvent())) {

            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'eventReservationController.error.registration_time', 'rkw_events'
                ),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );

            $this->redirect('show', 'Event', null, array('event' => $newEventReservation->getEvent()), intval($this->settings['showPid']));
            //===
        }


        // 4. Check for terms
        if (!$terms) {

            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'eventReservationController.error.acceptTerms', 'rkw_events'
                ),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );

            $this->forward('new', null, null, array('newEventReservation' => $newEventReservation, 'event' => $newEventReservation->getEvent()));
            //===
        }


        // 5. check if email is valid
        if (!\RKW\RkwRegistration\Tools\Registration::validEmail($newEventReservation->getEmail())) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'eventReservationController.error.no_valid_email', 'rkw_events'
                ),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );

            $this->forward('new', null, null, array('newEventReservation' => $newEventReservation, 'event' => $newEventReservation->getEvent()));
            //===
        }


        // 6. privacy
        if (!$privacy) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'registrationController.error.accept_privacy', 'rkw_registration'
                ),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->forward('new', null, null, array('newEventReservation' => $newEventReservation, 'event' => $newEventReservation->getEvent()));
            //===
        }


        // if user is logged in and has a valid email, create the reservation now!
        if (
            ($this->getFrontendUser())
            && (\RKW\RkwRegistration\Tools\Registration::validEmail($this->getFrontendUser()))
        ) {
            // for standardization for reservation creation (also possible with optin)
            $this->finalSaveReservation($newEventReservation, $this->getFrontendUser());

            // add privacy info
            \RKW\RkwRegistration\Tools\Privacy::addPrivacyData($this->request, $this->getFrontendUser(), $newEventReservation, 'new event reservation');

            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('eventReservationController.message.reservationCreated', 'rkw_events'),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::OK
            );

        } else {

            // check if email is not already used - relevant for logged in users with no email-address (e.g. via Facebook or Twitter)
            if (
                ($this->getFrontendUser())
                && (!\RKW\RkwRegistration\Tools\Registration::validEmailUnique($newEventReservation->getEmail(), $this->getFrontendUser()))
            ) {

                $this->addFlashMessage(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'eventReservationController.error.email_already_in_use', 'rkw_events'
                    ),
                    '',
                    \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
                );

                $this->forward('new', null, null, array('newEventReservation' => $newEventReservation, 'event' => $newEventReservation->getEvent()));
                //===
            }

            // register new user or simply send opt-in to existing user
            /** @var \RKW\RkwRegistration\Tools\Registration $registration */
            $registration = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwRegistration\\Tools\\Registration');
            $registration->register(
                array(
                    'tx_rkwregistration_gender' => $newEventReservation->getSalutation(),
                    'first_name'                => $newEventReservation->getFirstName(),
                    'last_name'                 => $newEventReservation->getLastName(),
                    'company'                   => $newEventReservation->getCompany(),
                    'address'                   => $newEventReservation->getAddress(),
                    'zip'                       => $newEventReservation->getZip(),
                    'city'                      => $newEventReservation->getCity(),
                    'email'                     => $newEventReservation->getEmail(),
                    'username'                  => ($this->getFrontendUser() ? $this->getFrontendUser()->getUsername() : $newEventReservation->getEmail()),
                ),
                false,
                $newEventReservation,
                'rkwEvents',
                $this->request
            );

            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'eventReservationController.message.reservationCreatedEmail', 'rkw_events',
                    '',
                    \TYPO3\CMS\Core\Messaging\AbstractMessage::OK
                )
            );
        }


        $this->redirect('show', 'Event', null, array('event' => $newEventReservation->getEvent()), intval($this->settings['showPid']));
        //===
    }


    /**
     * action optIn
     * Comment by Maximilian Fäßler: We get tricky validation issues here (https://rkwticket.rkw.de/issues/2803)
     * -> So we ignore the validation itself and checking with interal alias "instanceof" for trustful data
     * -> Benefit: We can set more helpful error messages for frontend users
     * Added by Maximilian Fäßler | FäßlerWeb
     *
     * @param \RKW\RkwEvents\Domain\Model\Event $event
     * @ignorevalidation $event
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     * @throws \TYPO3\CMS\Extbase\Persistence\Generic\Exception\TooDirtyException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
     */
    public function optInAction(\RKW\RkwEvents\Domain\Model\Event $event)
    {
        // General error:
        if (
            !$event instanceof \RKW\RkwEvents\Domain\Model\Event
            || $event->_isDirty()
        ) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('eventReservationController.error.somethingWentWrong', 'rkw_events'),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('show', 'Event', null, array('event' => $event), intval($this->settings['showPid']));
            //===
        }

        // Check if the event is still open for internal registration
        if (
            $event->getExtRegLink()
            || !$event->getRegRequired()
        ) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('eventReservationController.error.optInDisabled', 'rkw_events'),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('show', 'Event', null, array('event' => $event), intval($this->settings['showPid']));
            //===
        }

        $tokenYes = preg_replace('/[^a-zA-Z0-9]/', '', ($this->request->hasArgument('token_yes') ? $this->request->getArgument('token_yes') : ''));
        $tokenNo = preg_replace('/[^a-zA-Z0-9]/', '', ($this->request->hasArgument('token_no') ? $this->request->getArgument('token_no') : ''));
        $userSha1 = preg_replace('/[^a-zA-Z0-9]/', '', $this->request->getArgument('user'));

        /** @var \RKW\RkwRegistration\Tools\Registration $register */
        $register = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwRegistration\\Tools\\Registration');
        $check = $register->checkTokens($tokenYes, $tokenNo, $userSha1, $this->request, $data);

        if ($check == 1) {

            // 1. get reservation from registration and save it
            if (
                ($data['registration'])
                && ($registration = $data['registration'])
                && ($registration instanceof \RKW\RkwRegistration\Domain\Model\Registration)
                && ($newEventReservation = $registration->getData())
                && ($newEventReservation instanceof \RKW\RkwEvents\Domain\Model\EventReservation)
                && ($data['frontendUser'])
                && ($feUser = $data['frontendUser'])
                && ($feUser instanceof \RKW\RkwRegistration\Domain\Model\FrontendUser)
            ) {

                // 1. we need to re-fetch the event here, since the number of available seats or the dates may have been changed
                /** @var \RKW\RkwEvents\Domain\Model\Event $event */
                $event = $this->eventRepository->findByIdentifier($newEventReservation->getEvent()->getUid());
                $newEventReservation->setEvent($event);

                // 2. Check for existing reservations based on email.
                $eventReservationResult = $this->eventReservationRepository->findByEventAndFeUser($event, $feUser);
                if (count($eventReservationResult)) {

                    $this->addFlashMessage(
                        \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('eventReservationController.error.exists', 'rkw_events'),
                        '',
                        \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
                    );

                    $uri = $this->uriBuilder->reset()
                        ->setTargetPageUid($this->settings['loginPid'])
                        ->build();

                    $this->addFlashMessage(
                        \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                            'eventReservationController.hint.reservations',
                            'rkw_events',
                            array(
                                0 => "<a href='" . $uri . "'>",
                                1 => "</a>",
                            )
                        )
                    );

                    $this->redirect('show', 'Event', null, array('event' => $event), intval($this->settings['showPid']));
                    //===
                }

                // 3. Check available places
                if (!DivUtility::hasFreeSeats($event, $newEventReservation)) {

                    $this->addFlashMessage(
                        \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('eventReservationController.error.seats', 'rkw_events'),
                        '',
                        \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
                    );

                    $this->redirect('show', 'Event', null, array('event' => $event), intval($this->settings['showPid']));
                    //====
                }

                // 4. Check if registration-time is over since the user may have been waiting too long
                if (DivUtility::hasRegTimeEnded($event)) {

                    $this->addFlashMessage(
                        \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('eventReservationController.error.registration_time', 'rkw_events'),
                        '',
                        \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
                    );

                    $this->redirect('show', 'Event', null, array('event' => $event), intval($this->settings['showPid']));
                    //====
                }


                // 5. Create reservation!
                $this->finalSaveReservation($newEventReservation, $feUser, $registration);

                $this->addFlashMessage(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'eventReservationController.message.reservationCreated', 'rkw_events'
                    )
                );

                $this->redirect('show', 'Event', null, array('event' => $event), intval($this->settings['showPid']));
                //====

            }


        } elseif ($check == 2) {

            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'eventReservationController.message.reservationCanceled', 'rkw_events'
                )
            );

            $this->redirect('show', 'Event', null, array('event' => $event), intval($this->settings['showPid']));
            //====

        }


        $this->addFlashMessage(
            \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                'eventReservationController.error.reservationError', 'rkw_events'
            ),
            '',
            \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
        );

        $this->redirect('show', 'Event', null, array('event' => $event), intval($this->settings['showPid']));
        //====
    }


    /**
     * action show
     *
     * @param \RKW\RkwEvents\Domain\Model\EventReservation $eventReservation
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     */
    public function showAction($eventReservation)
    {
        if ($this->getFrontendUser()) {

            //security check
            if ($eventReservation->getFeUser() != $this->getFrontendUser()) {

                $this->addFlashMessage(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'eventReservationController.message.error.notPermitted', 'rkw_events'
                    ),
                    '',
                    \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
                );

                $this->redirect('list', 'Event', null, array(), $this->settings['listPid']);
                //===
            }

            $event = $eventReservation->getEvent();
            $this->view->assign('eventReservation', $eventReservation);
            $this->view->assign('event', $event);

        } else {

            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'eventReservationController.message.noUserLoggedIn', 'rkw_events'
                ),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );

            $this->redirect('list', 'Event', null, array(), $this->settings['listPid']);
            //===
        }
    }


    /**
     * action edit
     *
     * @param \RKW\RkwEvents\Domain\Model\EventReservation $eventReservation
     * @ignorevalidation $eventReservation
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     */
    public function editAction(\RKW\RkwEvents\Domain\Model\EventReservation $eventReservation)
    {
        if ($this->getFrontendUser()) {

            //security check
            if ($eventReservation->getFeUser() != $this->getFrontendUser()) {

                $this->addFlashMessage(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'eventReservationController.message.error.notPermitted', 'rkw_events'
                    ),
                    '',
                    \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
                );

                $this->redirect('list', 'Event', null, array(), $this->settings['listPid']);
                //===
            }

            // this "editMode" is a sign / marker and a simple way to use the FormFields-Partial in multiple ways
            $this->view->assign('editMode', 1);

            $this->view->assign('eventReservation', $eventReservation);
            $this->view->assign('event', $eventReservation->getEvent());

        } else {

            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'eventReservationController.message.noUserLoggedIn', 'rkw_events'
                ),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );

            $this->redirect('list', 'Event', null, array(), $this->settings['listPid']);
            //===
        }

    }


    /**
     * action update
     *
     * @param \RKW\RkwEvents\Domain\Model\EventReservation $eventReservation
     * @validate $eventReservation \RKW\RkwEvents\Validation\Validator\EventReservationValidator
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    public function updateAction(\RKW\RkwEvents\Domain\Model\EventReservation $eventReservation)
    {
        if ($feUser = $this->getFrontendUser()) {

            // 1. security check
            if ($eventReservation->getFeUser() != $feUser) {
                $this->addFlashMessage(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'eventReservationController.message.error.notPermitted', 'rkw_events'
                    ),
                    '',
                    \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
                );

                $this->redirect('list', 'Event', null, array(), $this->settings['listPid']);
                //===
            }


            // 2. only add additional persons that have at least one relevant field set
            /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
            $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
            /** @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage $tempObjectStorage */
            $tempObjectStorage = $objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage');

            // fetch all relevant objects in a temporary object storage
            foreach ($eventReservation->getAddPerson() as $addPerson) {
                if (
                    $addPerson->getFirstName()
                    || $addPerson->getLastName()
                ) {
                    $tempObjectStorage->attach($addPerson);
                }
            }

            // override existing object storage
            $eventReservation->setAddPerson($tempObjectStorage);

            // 2.2 Sub-operation: Register workshop reservations
            $workshopResult = DivUtility::workshopRegistration($eventReservation);
            // if there is no longer place in a workshop, set message. Don't break reservation! Just an info.
            if (!$workshopResult) {
                $this->addFlashMessage(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'eventReservationController.error.workshop_full', 'rkw_events'
                    ),
                    '',
                    \TYPO3\CMS\Core\Messaging\AbstractMessage::INFO
                );
            }

            // 3. some merging of FE-user
            if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('rkw_registration')) {
                DivUtility::mergeFeUsers($eventReservation, $feUser);

                /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
                $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

                /** @var \RKW\RkwRegistration\Domain\Repository\FrontendUserRepository $frontendUserRepository */
                $frontendUserRepository = $objectManager->get('RKW\\RkwRegistration\\Domain\\Repository\\FrontendUserRepository');
                $frontendUserRepository->update($feUser);
            }

            // 4. finally save the whole stuff
            $this->eventReservationRepository->update($eventReservation);

            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'eventReservationController.message.updateSuccess', 'rkw_events'
                ),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::OK
            );

            // 5. send final confirmation mail to user
            $this->signalSlotDispatcher->dispatch(__CLASS__, self::SIGNAL_AFTER_RESERVATION_UPDATE_USER, array($feUser, $eventReservation));

            // 6. send information mail to be-users
            $adminMails = array();
            if ($beUsers = $eventReservation->getEvent()->getBeUser()) {
                /** @var \RKW\RkwEvents\Domain\Model\BackendUser $beUser */
                foreach ($beUsers as $beUser) {
                    if ($beUser->getEmail()) {
                        $adminMails[] = $beUser;
                    }
                }
            }

            // 7. send information mail to external users
            if ($externalContacts = $eventReservation->getEvent()->getExternalContact()) {
                /** @var  $externalContact \RKW\RkwEvents\Domain\Model\EventContact */
                foreach ($externalContacts as $externalContact) {
                    if ($externalContact->getEmail()) {
                        $adminMails[] = $externalContact;
                    }
                }
            }

            // 8. send information mail to admins from TypoScript
            $adminUidList = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $this->settings['mail']['backendUser']);
            if ($adminUidList) {
                foreach ($adminUidList as $adminUid) {

                    /** @var \RKW\RkwEvents\Domain\Model\BackendUser $admin */
                    $admin = $this->backendUserRepository->findByUid($adminUid);
                    if (
                        ($admin)
                        && ($admin->getEmail())
                    ) {
                        $adminMails[] = $admin;
                    }
                }
            }
            $this->signalSlotDispatcher->dispatch(__CLASS__, self::SIGNAL_AFTER_RESERVATION_UPDATE_ADMIN, array($adminMails, $eventReservation));

            $this->redirect('myEvents', 'Event', null, array('event' => $eventReservation->getEvent()));
            //===

        } else {

            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'eventReservationController.message.noUserLoggedIn', 'rkw_events'
                ),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );

            $this->redirect('list', 'Event', null, array(), $this->settings['listPid']);
            //===
        }
    }


    /**
     * action delete
     *
     * @param \RKW\RkwEvents\Domain\Model\EventReservation $eventReservation
     * @ignorevalidation $eventReservation
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     */
    public function deleteAction(\RKW\RkwEvents\Domain\Model\EventReservation $eventReservation)
    {
        if ($this->getFrontendUser()) {

            //security check
            if ($eventReservation->getFeUser() != $this->getFrontendUser()) {

                $this->addFlashMessage(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'eventReservationController.message.error.notPermitted', 'rkw_events'
                    ),
                    '',
                    \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
                );

                $this->redirect('list', 'Event', null, array(), $this->settings['listPid']);
                //===
            }

            $this->view->assign('eventReservation', $eventReservation);
            $this->view->assign('event', $eventReservation->getEvent());

        } else {

            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'eventReservationController.message.noUserLoggedIn', 'rkw_events'
                ),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );

            $this->redirect('list', 'Event', null, array(), $this->settings['listPid']);
            //===
        }

    }


    /**
     * Removes an reservation
     *
     * @param \RKW\RkwEvents\Domain\Model\EventReservation $eventReservation
     * @ignorevalidation $eventReservation
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function removeAction(\RKW\RkwEvents\Domain\Model\EventReservation $eventReservation)
    {
        if ($this->getFrontendUser()) {

            // 1. security check
            if ($eventReservation->getFeUser() != $this->frontendUser) {
                $this->addFlashMessage(
                    \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'eventReservationController.message.error.notPermitted', 'rkw_events'
                    ),
                    '',
                    \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
                );

                $this->redirect('list', 'Event', null, array(), $this->settings['listPid']);
                //===
            }

            // 2. remove reservation and additional users
            foreach ($eventReservation->getAddPerson() as $addPerson) {
                $this->eventReservationAddPersonRepository->remove($addPerson);
            }
            $this->eventReservationRepository->remove($eventReservation);

            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'eventReservationController.message.deleteSuccess', 'rkw_events'
                ),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::OK
            );

            // 2.2 remove additional workshop reservations
            foreach ($eventReservation->getEvent()->getWorkshop1() as $workshop) {
                if ($workshop->getRegisteredFrontendUsers()->offsetExists($eventReservation->getFeUser())) {
                    $workshop->removeRegisteredFrontendUsers($eventReservation->getFeUser());
                }
            }
            foreach ($eventReservation->getEvent()->getWorkshop2() as $workshop) {
                if ($workshop->getRegisteredFrontendUsers()->offsetExists($eventReservation->getFeUser())) {
                    $workshop->removeRegisteredFrontendUsers($eventReservation->getFeUser());
                }
            }
            foreach ($eventReservation->getEvent()->getWorkshop3() as $workshop) {
                if ($workshop->getRegisteredFrontendUsers()->offsetExists($eventReservation->getFeUser())) {
                    $workshop->removeRegisteredFrontendUsers($eventReservation->getFeUser());
                }
            }

            // 3. send final confirmation mail to user
            $this->signalSlotDispatcher->dispatch(__CLASS__, self::SIGNAL_AFTER_RESERVATION_DELETE_USER, array($this->getFrontendUser(), $eventReservation));

            // 4. send information mail to be-users
            $adminMails = array();
            if ($beUsers = $eventReservation->getEvent()->getBeUser()) {
                /** @var \RKW\RkwEvents\Domain\Model\BackendUser $beUser */
                foreach ($beUsers as $beUser) {
                    if ($beUser->getEmail()) {
                        $adminMails[] = $beUser;
                    }
                }
            }

            // 5. send information mail to external users
            if ($externalContacts = $eventReservation->getEvent()->getExternalContact()) {
                /** @var  $externalContact \RKW\RkwEvents\Domain\Model\EventContact */
                foreach ($externalContacts as $externalContact) {
                    if ($externalContact->getEmail()) {
                        $adminMails[] = $externalContact;
                    }
                }
            }

            // 6. send information mail to admins from TypoScript
            $adminUidList = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $this->settings['mail']['backendUser']);
            if ($adminUidList) {
                foreach ($adminUidList as $adminUid) {

                    /** @var \RKW\RkwEvents\Domain\Model\BackendUser $admin */
                    $admin = $this->backendUserRepository->findByUid($adminUid);
                    if (
                        ($admin)
                        && ($admin->getEmail())
                    ) {
                        $adminMails[] = $admin;
                    }
                }
            }
            $this->signalSlotDispatcher->dispatch(__CLASS__, self::SIGNAL_AFTER_RESERVATION_DELETE_ADMIN, array($adminMails, $this->getFrontendUser(), $eventReservation));

            $this->redirect('myEvents', 'Event');
            //===

        } else {

            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'eventReservationController.message.noUserLoggedIn', 'rkw_events'
                ),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );

            $this->redirect('list', 'Event', null, array(), $this->settings['listPid']);
            //===
        }

    }


    /**
     * Removes all reservations of a FE-User
     * Used by Signal-Slot
     *
     * @param \RKW\RkwRegistration\Domain\Model\FrontendUser $feUser
     * @return void
     */
    public function removeAllOfUserSignalSlot(\RKW\RkwRegistration\Domain\Model\FrontendUser $feUser)
    {
        try {
            $eventReservations = $this->eventReservationRepository->findByFeUser($feUser, false);
            $settings = $this->getSettings();

            if ($eventReservations) {

                /** @var \RKW\RkwEvents\Domain\Model\EventReservation $eventReservation */
                foreach ($eventReservations as $eventReservation) {

                    // 1. only cancel events that are about to come
                    if ($eventReservation->getEvent()->getStart() < time()) {
                        continue;
                        //===
                    }

                    // 2. remove reservation and additional users
                    foreach ($eventReservation->getAddPerson() as $addPerson)
                        $this->eventReservationAddPersonRepository->remove($addPerson);
                    $this->eventReservationRepository->remove($eventReservation);
                    $this->persistenceManager->persistAll();

                    // 3. send final confirmation mail to user
                    $this->signalSlotDispatcher->dispatch(__CLASS__, self::SIGNAL_AFTER_RESERVATION_DELETE_USER, array($feUser, $eventReservation));

                    // 4. send information mail to be-users
                    $adminMails = array();
                    if ($beUsers = $eventReservation->getEvent()->getBeUser()) {
                        /** @var \RKW\RkwEvents\Domain\Model\BackendUser $beUser */
                        foreach ($beUsers as $beUser) {
                            if ($beUser->getEmail()) {
                                $adminMails[] = $beUser;
                            }
                        }
                    }

                    // 5. send information mail to external users
                    if ($externalContacts = $eventReservation->getEvent()->getExternalContact()) {
                        /** @var  $externalContact \RKW\RkwEvents\Domain\Model\EventContact */
                        foreach ($externalContacts as $externalContact) {
                            if ($externalContact->getEmail()) {
                                $adminMails[] = $externalContact;
                            }
                        }
                    }

                    // 6. send information mail to admins from TypoScript
                    $adminUidList = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $settings['mail']['backendUser']);
                    if ($adminUidList) {
                        foreach ($adminUidList as $adminUid) {

                            /** @var \RKW\RkwEvents\Domain\Model\BackendUser $admin */
                            $admin = $this->backendUserRepository->findByUid($adminUid);
                            if (
                                ($admin)
                                && ($admin->getEmail())
                            ) {
                                $adminMails[] = $admin;
                            }
                        }
                    }

                    $this->signalSlotDispatcher->dispatch(__CLASS__, self::SIGNAL_AFTER_RESERVATION_DELETE_ADMIN, array($adminMails, $feUser, $eventReservation));
                    $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::INFO, sprintf('Deleted event reservation with uid %s of user with uid %s via signal-slot.', $eventReservation->getUid(), $feUser->getUid()));

                }
            }
        } catch (\Exception $e) {
            $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::ERROR, sprintf('Error while deleting event reservation of user via signal-slot: %s', $e->getMessage()));
        }
    }


    /**
     * finalSaveOrder
     * Adds the order finally to database and sends information mails to user and admin
     * This function is used by "createOptInReservationAction" and "create"-function
     * Added by Maximilian Fäßler | FäßlerWeb
     *
     * @param \RKW\RkwEvents\Domain\Model\EventReservation $newEventReservation
     * @param \RKW\RkwRegistration\Domain\Model\FrontendUser $feUser
     * @param \RKW\RkwRegistration\Domain\Model\Registration $registration
     * @return void
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException
     * @throws \TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException
     */
    protected function finalSaveReservation(\RKW\RkwEvents\Domain\Model\EventReservation $newEventReservation, \RKW\RkwRegistration\Domain\Model\FrontendUser $feUser, \RKW\RkwRegistration\Domain\Model\Registration $registration = null)
    {
        // optional service: Merge form data (eventReservation) in frontendUser, if some field is empty
        if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('rkw_registration')) {
            DivUtility::mergeFeUsers($newEventReservation, $feUser);

            /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
            $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

            /** @var \RKW\RkwRegistration\Domain\Repository\FrontendUserRepository $frontendUserRepository */
            $frontendUserRepository = $objectManager->get('RKW\\RkwRegistration\\Domain\\Repository\\FrontendUserRepository');
            $frontendUserRepository->update($feUser);
        }

        // 1. set FeUser
        $newEventReservation->setFeUser($feUser);

        // 2. save reservation
        // only add additional persons that have at least one relevant field set
        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        /** @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage $tempObjectStorage */
        $tempObjectStorage = $objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage');

        // fetch all relevant objects in a temporary object storage
        foreach ($newEventReservation->getAddPerson() as $addPerson) {
            if (
                $addPerson->getFirstName()
                || $addPerson->getLastName()
            ) {
                $tempObjectStorage->attach($addPerson);
            }
        }
        // override existing object storage
        $newEventReservation->setAddPerson($tempObjectStorage);

        // 2.2 Sub-operation: Register workshop reservations
        $workshopResult = DivUtility::workshopRegistration($newEventReservation);
        // if there is no longer place in a workshop, set message. Don't break reservation! Just an info.
        if (!$workshopResult) {
            $this->addFlashMessage(
                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'eventReservationController.error.workshop_full', 'rkw_events'
                ),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::INFO
            );
        }

        //  check target group
        if ($newEventReservation->getEvent()->getPrioritizedTargetGroups()->count() === 0 || $newEventReservation->getEvent()->getPrioritizedTargetGroups()->offsetExists($this->targetGroupRepository->findByUid($newEventReservation->getTargetGroup()->getUid()))) {
            $newEventReservation->setConfirmationDate(time());
        }

        $this->eventReservationRepository->add($newEventReservation);
        $this->persistenceManager->persistAll();

        // 2.3 add domain entry
        $newEventReservation->setServerHost(filter_var($_SERVER['HTTP_HOST'], FILTER_SANITIZE_URL));

        // 3. add it to event
        $event = $newEventReservation->getEvent();
        //  @todo: Die Reservierung wird gesetzt ohne Rücksicht auf confirmed
        $event->addReservation($newEventReservation);
        $this->eventRepository->update($event);
        $this->persistenceManager->persistAll();

        // 4. send final confirmation mail to user, depending on yet confirmed or not
        if ($newEventReservation->getConfirmationDate() > 0) {
            $this->signalSlotDispatcher->dispatch(__CLASS__, self::SIGNAL_AFTER_RESERVATION_CREATED_USER, array($feUser, $newEventReservation));
        } else {
            $this->signalSlotDispatcher->dispatch(__CLASS__, self::SIGNAL_AFTER_RESERVATION_CREATED_PENDING_USER, array($feUser, $newEventReservation));
        }

        // 5. send information mail to be-users
        $adminMails = array();
        if ($beUsers = $newEventReservation->getEvent()->getBeUser()) {
            /** @var \RKW\RkwEvents\Domain\Model\BackendUser $beUser */
            foreach ($beUsers as $beUser) {
                if ($beUser->getEmail()) {
                    $adminMails[] = $beUser;
                }
            }
        }

        // 6. send information mail to external users
        if ($externalContacts = $newEventReservation->getEvent()->getExternalContact()) {
            /** @var  $externalContact \RKW\RkwEvents\Domain\Model\EventContact */
            foreach ($externalContacts as $externalContact) {
                if ($externalContact->getEmail()) {
                    $adminMails[] = $externalContact;
                }
            }
        }

        // 7. send information mail to admins from TypoScript
        $adminUidList = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $this->settings['mail']['backendUser']);
        if ($adminUidList) {
            foreach ($adminUidList as $adminUid) {

                /** @var \RKW\RkwEvents\Domain\Model\BackendUser $admin */
                $admin = $this->backendUserRepository->findByUid($adminUid);
                if (
                    ($admin)
                    && ($admin->getEmail())
                ) {
                    $adminMails[] = $admin;
                }
            }
        }

        $this->signalSlotDispatcher->dispatch(__CLASS__, self::SIGNAL_AFTER_RESERVATION_CREATED_ADMIN, array($adminMails, $newEventReservation));
    }


    /**
     * Id of logged User
     *
     * @return integer
     */
    protected function getFrontendUserId()
    {
        // is $GLOBALS set?
        if (
            ($GLOBALS['TSFE'])
            && ($GLOBALS['TSFE']->loginUser)
            && ($GLOBALS['TSFE']->fe_user->user['uid'])
        ) {
            return intval($GLOBALS['TSFE']->fe_user->user['uid']);
            //===
        }

        return false;
        //===
    }


    /**
     * Returns current logged in user object
     *
     * @return \RKW\RkwEvents\Domain\Model\FrontendUser|NULL
     */
    protected function getFrontendUser()
    {
        $this->frontendUser = $this->frontendUserRepository->findByIdentifier($this->getFrontendUserId());

        if ($this->frontendUser instanceof \TYPO3\CMS\Extbase\Domain\Model\FrontendUser) {
            return $this->frontendUser;
        }

        //===

        return null;
        //===
    }


    /**
     * Returns SignalSlotDispatcher
     *
     * @return \TYPO3\CMS\Extbase\SignalSlot\Dispatcher
     */
    protected function getSignalSlotDispatcher()
    {
        if (!$this->signalSlotDispatcher) {
            $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
            $this->signalSlotDispatcher = $objectManager->get('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');
        }

        return $this->signalSlotDispatcher;
        //===
    }


    /**
     * Remove ErrorFlashMessage
     *
     * @see \TYPO3\CMS\Extbase\Mvc\Controller\ActionController::getErrorFlashMessage()
     */
    protected function getErrorFlashMessage()
    {
        return false;
        //===
    }


    /**
     * Returns TYPO3 settings
     *
     * @param string $which Which type of settings will be loaded
     * @return array
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    protected function getSettings($which = ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS)
    {
        return Common::getTyposcriptConfiguration('Rkwevents', $which);
        //===
    }


    /**
     * Returns logger instance
     *
     * @return \TYPO3\CMS\Core\Log\Logger
     */
    protected function getLogger()
    {
        if (!$this->logger instanceof \TYPO3\CMS\Core\Log\Logger) {
            $this->logger = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Log\LogManager')->getLogger(__CLASS__);
        }

        return $this->logger;
        //===
    }
}