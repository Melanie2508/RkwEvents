<?php

namespace RKW\RkwEvents\Controller;
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

use RKW\RkwEvents\Helper\DivUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * Class EventCommandController
 *
 * @author Carlos Meyer <cm@davitec.de>
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEvents
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class EventCommandController extends \TYPO3\CMS\Extbase\Mvc\Controller\CommandController
{
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
     * configurationManager
     *
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     */
    protected $configurationManager;

    /**
     * persistenceManager
     *
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager;

    /**
     * @var \TYPO3\CMS\Core\Log\Logger
     */
    protected $logger;

    /**
     * The settings.
     *
     * @var array
     */
    protected $settings = array();


    /**
     * Inform user regarding of an upcoming event
     *
     * @param integer $timeFrame Defines when we start to send e-mails as reminder for the user before the event starts (start
     *     time of event <= time() + $timeFrame; in seconds; default: 86400)
     */
    public function informUserUpcomingEventCommand($timeFrame = 86400)
    {
        try {
            $eventList = $this->eventRepository->findUpcomingEventsForReminder($timeFrame);
            if (count($eventList)) {

                /** @var \RKW\RkwEvents\Domain\Model\Event $event */
                foreach ($eventList as $event) {
                    if ($eventReservationList = $event->getConfirmedReservations()) {

                        // send mails
                        /** @var \RKW\RkwEvents\Service\RkwMailService $mailService */
                        $mailService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwEvents\\Service\\RkwMailService');
                        $mailService->informUpcomingEventUser($eventReservationList, $event);

                        // set timestamp in event, so that mails are not send twice
                        $event->setReminderMailTstamp(time());
                        $this->eventRepository->update($event);
                        $this->persistenceManager->persistAll();

                        $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::INFO, sprintf('Successfully sent %s reminder mails for upcoming event %s.', count($eventReservationList), $event->getUid()));
                    } else {
                        $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::INFO, sprintf('No reservations found for upcoming event %s. No reminder mail sent.', $event->getUid()));
                    }
                }
            } else {
                $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::INFO, sprintf('No relevant events found for reminder mail.'));
            }

        } catch (\Exception $e) {
            $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::ERROR, sprintf('An error occurred while trying to send an inform mail about an upcoming event. Message: %s', str_replace(array("\n", "\r"), '', $e->getMessage())));
        }

    }


    /**
     * Inform user regarding of an upcoming event
     *
     * @param integer $timeFrame Defines when we start to send e-mails with survey link after the event has ended (start time of
     *     event <= time() + $timeFrame; in seconds; default: 86400)
     */
    public function sendSurveyForPastEventCommand($timeFrame = 86400)
    {
        if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('rkw_survey')) {
            try {
                $eventList = $this->eventRepository->findAllByPastEvents($timeFrame);
                if (count($eventList)) {

                    /** @var \RKW\RkwEvents\Domain\Model\Event $event */
                    foreach ($eventList as $event) {

                        if ($eventReservationList = $event->getConfirmedReservations()) {

                            /** @var \RKW\RkwEvents\Service\RkwMailService $mailService */
                            $mailService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwEvents\\Service\\RkwMailService');
                            $mailService->sendSurveyForPastEvent($eventReservationList);

                            $event->setSurveyAfterMailTstamp(time());
                            $this->eventRepository->update($event);
                            $this->persistenceManager->persistAll();

                            $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::INFO, sprintf('Successfully sent %s survey mails for upcoming event %s.', count($eventReservationList), $event->getUid()));
                        } else {
                            $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::INFO, sprintf('No reservations found for event %s. No survey mail sent.', $event->getUid()));
                        }
                    }
                } else {
                    $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::INFO, sprintf('No relevant events found for survey mail.'));
                }

            } catch (\Exception $e) {
                $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::ERROR, sprintf('An error occurred while trying to send an survey mail about a past event. Message: %s', str_replace(array("\n", "\r"), '', $e->getMessage())));
            }
        }
    }

    /**
     * Process pending reservations after end of registration
     *
     */
    public function processPendingReservationsAfterRegistrationEndedCommand()
    {

        //  find all upcoming events, where approval/registration has ended and free seats are still available
        $eventList = $this->eventRepository->findAllUpcomingApprovedEvents($approvalAuto = TRUE);

        /** @var \RKW\RkwEvents\Domain\Model\Event $event */
        foreach ($eventList as $event) {

            if ($eventReservationList = $event->getPendingReservations()) {

                /** @var \RKW\RkwEvents\Service\RkwMailService $mailService */
                $mailService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwEvents\\Service\\RkwMailService');

                //  trigger sending an email to confirm the corresponding users they are now finally confirmed
                if (count($eventReservationList)) {

                    foreach ($eventReservationList as $eventReservation) {

                        if (DivUtility::hasFreeSeats($event, $eventReservation)) {

                            $mailService->sendFinalConfirmation($eventReservation);

                            //  set confirmationDate
                            $eventReservation->setConfirmationDate(time());
                            $this->eventReservationRepository->update($eventReservation);
                            $this->persistenceManager->persistAll();

                        } else {

                            //  @todo: delete reservation and send email?

                        }

                    }

                }

            }

        }

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
