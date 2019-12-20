<?php

namespace RKW\RkwEvents\Helper;
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

use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * DivUtility
 *
 * @author Carlos Meyer <cm@davitec.de>
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEvents
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class DivUtility
{

    /**
     * Returns true if reg time for event has ended
     *
     * @param \RKW\RkwEvents\Domain\Model\Event $event
     * @return boolean
     */
    public static function hasRegTimeEnded(\RKW\RkwEvents\Domain\Model\Event $event)
    {
        // check if reminder-mail has already been sent for online-events
        if (
            ($event->getOnlineEvent())
            && ($event->getOnlineEventAccessLink())
            && ($event->getReminderMailTstamp())
        ) {
            return true;
            //===
        }

        // check if regEnd-time or start-time is in the past
        $date = $event->getRegEnd() ? $event->getRegEnd() : $event->getStart();
        if ($date < time()) {
            return true;
        }

        //===

        return false;
        //===

    }


    /**
     * check available seats
     *
     * @param \RKW\RkwEvents\Domain\Model\Event $event
     * @param \RKW\RkwEvents\Domain\Model\EventReservation $newEventReservation
     * @return boolean
     */
    public static function hasFreeSeats(\RKW\RkwEvents\Domain\Model\Event $event, \RKW\RkwEvents\Domain\Model\EventReservation $newEventReservation)
    {

        $countConfirmedReservations = self::countConfirmedReservations($event);
        $countEventReservationsWithAddPersons = self::countEventReservationsWithAddPersons($newEventReservation);
        $availableSeats = $event->getSeats() - $countConfirmedReservations;
        if ($availableSeats >= $countEventReservationsWithAddPersons) {
            return true;
            //===
        }

        return false;
        //===
    }


    /**
     * count confirmed reservations
     *
     * @param \RKW\RkwEvents\Domain\Model\Event $event
     * @return int
     */
    public static function countConfirmedReservations($event)
    {

        $reservations = $event->getConfirmedReservations();
        $confirmedReservations = 0;
        if (count($reservations) > 0) {
            foreach ($reservations as $reservation) {

                $confirmedReservations++;
                $addPerson = $reservation->getAddPerson();
                $confirmedReservations = $confirmedReservations + count($addPerson);

            }

            return $confirmedReservations;
            //===
        } else {
            return 0;
            //===
        }

    }


    /**
     * count reservations in eventReservation (included add Persons)
     *
     * @param \RKW\RkwEvents\Domain\Model\EventReservation $eventReservation
     * @return int
     */
    public static function countEventReservationsWithAddPersons($eventReservation)
    {
        $reservations = 1;
        $addPerson = $eventReservation->getAddPerson();
        $reservations = $reservations + count($addPerson);

        return $reservations;
        //===
    }


    /**
     * merge eventReservation-data into frontendUser
     *
     * @param \RKW\RkwEvents\Domain\Model\EventReservation $eventReservation
     * @param \RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUser
     * @return void
     */
    public static function mergeFeUsers(\RKW\RkwEvents\Domain\Model\EventReservation $eventReservation, \RKW\RkwRegistration\Domain\Model\FrontendUser $frontendUser)
    {

        // we just migrate the data to our object!
        if (
            ($frontendUser->getTxRkwregistrationGender() == 99)
            && (!$eventReservation->getSalutation() == 99)
        ) {
            $frontendUser->setTxRkwregistrationGender($eventReservation->getSalutation());
        }

        if (
            (!$frontendUser->getFirstName())
            && ($eventReservation->getFirstName())
        ) {
            $frontendUser->setFirstName($eventReservation->getFirstName());
        }

        if (
            (!$frontendUser->getLastName())
            && ($eventReservation->getLastName())
        ) {
            $frontendUser->setLastName($eventReservation->getLastName());
        }

        if (
            (!\RKW\RkwRegistration\Tools\Registration::validEmail($frontendUser->getEmail()))
            && (\RKW\RkwRegistration\Tools\Registration::validEmail($eventReservation->getEmail()))
        ) {
            $frontendUser->setEmail($eventReservation->getEmail());
        }

        if (
            (!$frontendUser->getCompany())
            && ($eventReservation->getCompany())
        ) {
            $frontendUser->setCompany($eventReservation->getCompany());
        }

        if (
            (!$frontendUser->getTelephone())
            && ($eventReservation->getPhone())
        ) {
            $frontendUser->setTelephone($eventReservation->getPhone());
        }

        // set only new address data together, or even not
        if (
            (!$frontendUser->getAddress() && !$frontendUser->getZip() && !$frontendUser->getCity())
            && ($eventReservation->getAddress() && $eventReservation->getZip() && $eventReservation->getCity())
        ) {
            $frontendUser->setAddress($eventReservation->getAddress());
            $frontendUser->setZip($eventReservation->getZip());
            $frontendUser->setCity($eventReservation->getCity());
        }
    }


    /**
     * furtherResultsAvailable
     * to manage lazy loading in fluid
     *
     * @author Maximilian Fäßler
     * @param \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array $queryResult
     * @param int $limit
     * @param int $page
     * @param \RKW\RkwEvents\Domain\Model\Event &$firstItem
     * @return array
     */
    public static function prepareResultsList($queryResult, $limit, $page = 0, &$firstItem = null)
    {

        $eventList = $queryResult->toArray();

        // kill first item at first :)
        // we use this item only to be able to append events to existing groupings in frontend
        if (
            ($page > 0)
            && ($eventList[0])
            && ($eventList[0] instanceof \RKW\RkwEvents\Domain\Model\Event)
        ) {
            $firstItem = $eventList[0];
            array_shift($eventList);
        }


        // We always have our result set +1 optional result (to know if there would be more results)
        // If the count of the queryResult greater than the given limit, than there are more results
        // -> we remove the optional item in this case. Otherwise we do nothing special.
        if (count($eventList) > $limit) {
            array_pop($eventList);
        }

        return $eventList;
        //===
    }


    /**
     * groupEventsByMonth
     *
     * @author Maximilian Fäßler
     * @param array $eventList
     * @return array
     */
    public static function groupEventsByMonth($eventList)
    {

        $sortedEventList = array();
        /** @var \RKW\RkwEvents\Domain\Model\Event $event */
        foreach ($eventList as $event) {

            $startDate = new \DateTime(date('d-m-Y', $event->getStart()));
            $sortedEventList[$startDate->format("Y")][$startDate->format("m")][] = $event;
        }

        return $sortedEventList;
        //===
    }


    /**
     * groupEventsByMonth
     *
     * @author Maximilian Fäßler
     * @param array $eventList
     * @param \RKW\RkwEvents\Domain\Model\Event $lastItem
     * @return array
     */
    public static function groupEventsByMonthMore($eventList, \RKW\RkwEvents\Domain\Model\Event $lastItem = null)
    {

        $sortedEventList = array();
        $startDateLastItem = null;
        if ($lastItem) {
            $startDateLastItem = new \DateTime(date('d-m-Y', $lastItem->getStart()));
        }

        /** @var \RKW\RkwEvents\Domain\Model\Event $event */
        foreach ($eventList as $event) {

            $startDate = new \DateTime(date('d-m-Y', $event->getStart()));

            // if year and month are identical we have to add this element
            // to a another HTML-element via JSON
            if (
                ($startDateLastItem)
                && ($startDate->format("Y") == $startDateLastItem->format("Y"))
                && ($startDate->format("m") == $startDateLastItem->format("m"))
            ) {
                $sortedEventList['insert'][$startDate->format("Y")][$startDate->format("m")][] = $event;
            } else {
                $sortedEventList['append'][$startDate->format("Y")][$startDate->format("m")][] = $event;
            }
        }

        return $sortedEventList;
        //===
    }



    /**
     * workshopRegistration
     * !! returns FALSE, if not every workshop had a place for registration
     *
     * @author Maximilian Fäßler
     * @param \RKW\RkwEvents\Domain\Model\EventReservation $eventReservation
     * @return boolean
     */
    public static function workshopRegistration(\RKW\RkwEvents\Domain\Model\EventReservation $eventReservation)
    {

        $booleanReturnValue = true;

        // 3. check workshop reservation
        if (count($eventReservation->getWorkshopRegister())) {

            // (1) filter form array
            foreach ($eventReservation->getWorkshopRegister() as $unitName => $workshopUnit) {

                foreach ($workshopUnit as $workshopUid) {

                    // go ahead only if value is set (user has selected checkbox)
                    // (2) check places
                    if (intval($workshopUid)) {

                        // iterate workshopunit from event
                        $getWorkshopUnit = 'get' . ucfirst($unitName);

                        // we can't work with "$key =>" in foreach instead of iteration (cryptic output -> storage identifier)
                        $i = 1;
                        /** @var \RKW\RkwEvents\Domain\Model\EventWorkshop $eventWorkshop */
                        foreach ($eventReservation->getEvent()->$getWorkshopUnit() as $eventWorkshop) {

                            /* ! Block darunter könnte geschickter sein für an- und abmelden
                            // a) Set user to workshop, if he has select it
                            if ($eventWorkshop->getUid() == intval($workshopUid)) {

                                // count already reserved places and check, if there is space (if place limit is set)
                                if ($eventWorkshop->getAvailableSeats()) {

                                    // a) Either: Error, no place free
                                    if (count($eventWorkshop->getRegisteredFrontendUsers()) >= $eventWorkshop->getAvailableSeats()) {

                                        // Error! Set flash message in controller! Only info!
                                        // Do not set a return at this point -> let iterate further workshops!
                                        $booleanReturnValue = FALSE;

                                    } else {
                                        // b) Everything okay, set user to workshop (if not already set)
                                        if (!$eventWorkshop->getRegisteredFrontendUsers()->offsetExists($eventReservation->getFeUser()))
                                            $eventWorkshop->addRegisteredFrontendUsers($eventReservation->getFeUser());
                                    }
                                }
                            }
                            */

                            // If: Workshop not in form-array and user is registered, put him out!
                            if (!in_array($eventWorkshop->getUid(), $workshopUnit)) {

                                // remove if set
                                if ($eventWorkshop->getRegisteredFrontendUsers()->offsetExists($eventReservation->getFeUser())) {
                                    $eventWorkshop->removeRegisteredFrontendUsers($eventReservation->getFeUser());
                                }

                            } else {

                                // Else: Register (if seats still available)
                                // count already reserved places and check, if there is space (if place limit is set)
                                if ($eventWorkshop->getAvailableSeats()) {

                                    // a) Either: Error, no place free
                                    if (count($eventWorkshop->getRegisteredFrontendUsers()) >= $eventWorkshop->getAvailableSeats()) {

                                        // Error! Set flash message in controller! Only info!
                                        // Do not set a return at this point -> let iterate further workshops!
                                        $booleanReturnValue = false;

                                    } else {
                                        // b) Everything okay, set user to workshop (if not already set)
                                        if (!$eventWorkshop->getRegisteredFrontendUsers()->offsetExists($eventReservation->getFeUser())) {
                                            $eventWorkshop->addRegisteredFrontendUsers($eventReservation->getFeUser());
                                        }
                                    }
                                }
                            }
                            $i++;
                        }
                    }
                }
            }
        }

        return $booleanReturnValue;
        //===
    }

}
