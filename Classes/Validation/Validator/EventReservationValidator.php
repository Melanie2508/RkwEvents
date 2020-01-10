<?php

namespace RKW\RkwEvents\Validation\Validator;

use RKW\RkwEvents\Helper\DivUtility;
use \RKW\RkwBasics\Helper\Common;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

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
 * Class EventReservationValidator
 *
 * @author Carlos Meyer <cm@davitec.de>
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEvents
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class EventReservationValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{

    /**
     * TypoScript Settings
     *
     * @var array
     */
    protected $settings = null;

    /**
     * validation
     *
     * @var \RKW\RkwEvents\Domain\Model\EventReservation $newEventReservation
     * @return boolean
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public function isValid($newEventReservation)
    {

        // initialize typoscript settings
        $this->getSettings();

        // get mandatory fields
        $mandatoryFieldsMainPerson = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(",", $this->settings['mandatoryFields']['eventReservationMainPerson']);
        $mandatoryFieldsAdditionalPersons = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(",", $this->settings['mandatoryFields']['eventReservationAdditionalPersons']);

        //  conditionally add targetGroup to the mandatory fields, if prioritizedTargetGroups is set on the event.
        if ($newEventReservation->getEvent()->getPrioritizedTargetGroups()->count() > 0) {
            $mandatoryFieldsMainPerson[] = 'targetGroup';
        }

        $isValid = true;

        // 1. Check mandatory fields main person
        if ($mandatoryFieldsMainPerson) {

            foreach ($mandatoryFieldsMainPerson as $field) {

                $getter = 'get' . ucfirst($field);
                if (method_exists($newEventReservation, $getter)) {

                    if (
                        (
                            ($field == 'salutation')
                            && (trim($newEventReservation->$getter()) == 99)
                        )
                        ||
                        (
                            ($field != 'salutation')
                            && (!trim($newEventReservation->$getter()))
                        )
                    ) {

                        $propertyName = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                            'tx_rkwevents_validator.' . lcfirst($field),
                            'rkw_events'
                        );

                        $this->result->forProperty(lcfirst($field))->addError(
                            new \TYPO3\CMS\Extbase\Error\Error(
                                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                                    'tx_rkwevents_validator.not_filled',
                                    'rkw_events',
                                    array($propertyName)
                                ), 1449314603
                            )
                        );
                        $isValid = false;
                    }
                }
            }
        }


        // 2. Check mandatory fields additional persons (check only, if some value is set)
        /** @var \RKW\RkwEvents\Domain\Model\EventReservationAddPerson $additionalPerson */

        if ($mandatoryFieldsAdditionalPersons) {

            foreach ($mandatoryFieldsAdditionalPersons as $field) {


                $getter = 'get' . ucfirst($field);
                $i = 0;
                foreach ($newEventReservation->getAddPerson() as $additionalPerson) {


                    if (method_exists($additionalPerson, $getter)) {


                        if (
                            ($additionalPerson->getSalutation() != 99)
                            || $additionalPerson->getFirstName()
                            || $additionalPerson->getLastName()
                        ) {


                            if (
                                (
                                    ($field == 'salutation')
                                    && (trim($additionalPerson->$getter()) == 99)
                                )
                                ||
                                (
                                    ($field != 'salutation')
                                    && (!trim($additionalPerson->$getter()))
                                )
                            ) {

                                $propertyName = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                                    'tx_rkwevents_validator.additional_' . lcfirst($field) . '_' . $i,
                                    'rkw_events'
                                );

                                $this->result->forProperty('addPerson.' . $i . '.' . lcfirst($field))->addError(
                                    new \TYPO3\CMS\Extbase\Error\Error(
                                        \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                                            'tx_rkwevents_validator.not_filled',
                                            'rkw_events',
                                            array($propertyName)
                                        ), 1449314603
                                    )
                                );
                                $isValid = false;
                            }
                        }
                    }
                    $i++;
                }
            }
        }


        // 3. check workshop reservation
        if (count($newEventReservation->getWorkshopRegister())) {

            // (1) filter form array
            foreach ($newEventReservation->getWorkshopRegister() as $unitName => $workshopUnit) {

                foreach ($workshopUnit as $workshopUid) {

                    // go ahead only if value is set (user has selected checkbox)
                    // (2) check places
                    if (intval($workshopUid)) {

                        // iterate workshopunit from event
                        $getWorkshopUnit = 'get' . ucfirst($unitName);

                        // we can't work with "$key =>" in foreach instead of iteration (cryptic output -> storage identifier)
                        // Gedanke MF: Möglicherweise ist hier "$newEventReservation->getEvent()->$getWorkshopUnit()->getKey()" eine Lösung
                        $i = 1;
                        /** @var \RKW\RkwEvents\Domain\Model\EventWorkshop $eventWorkshop */
                        foreach ($newEventReservation->getEvent()->$getWorkshopUnit() as $eventWorkshop) {
                            if ($eventWorkshop->getUid() == intval($workshopUid)) {

                                // count already reserved places and check, if there is space (if place limit is set)
                                if ($eventWorkshop->getAvailableSeats()) {

                                    if (count($eventWorkshop->getRegisteredFrontendUsers()) >= $eventWorkshop->getAvailableSeats()) {
                                        $this->result->forProperty('workshopRegister.' . $unitName . '.' . $i)->addError(
                                            new \TYPO3\CMS\Extbase\Error\Error(
                                                \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                                                    'tx_rkwevents_validator.workshop_no_places',
                                                    'rkw_events'
                                                ), 1481623579
                                            )
                                        );
                                        $isValid = false;
                                    }
                                }
                            }
                            $i++;
                        }
                    }
                }
            }
        }


        return $isValid;
        //===
    }


    /**
     * Returns TYPO3 settings
     *
     * @return array
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    protected function getSettings()
    {

        if (!$this->settings) {
            $this->settings = Common::getTyposcriptConfiguration('Rkwevents');
        }

        if (!$this->settings) {
            return array();
        }

        //===

        return $this->settings;
        //===
    }

}

