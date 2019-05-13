<?php

namespace RKW\RkwEvents\Domain\Model;
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
 * Class EventReservationAddPerson
 *
 * @author Carlos Meyer <cm@davitec.de>
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEvents
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class EventReservationAddPerson extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * event
     *
     * @var \RKW\RkwEvents\Domain\Model\EventReservation
     */
    protected $eventReservation = null;

    /**
     * salutation
     *
     * @var integer
     */
    protected $salutation = 99;

    /**
     * title
     *
     * @var string
     */
    protected $title;

    /**
     * txRkwregistrationTitle
     *
     * @var \RKW\RkwRegistration\Domain\Model\Title
     */
    protected $txRkwregistrationTitle = null;

    /**
     * firstName
     *
     * @var string
     */
    protected $firstName;

    /**
     * lastName
     *
     * @var string
     */
    protected $lastName;

    /**
     * @var integer
     */
    protected $crdate;


    /**
     * @var integer
     */
    protected $tstamp;

    /**
     * @var integer
     */
    protected $deleted;

    /**
     * @var integer
     */
    protected $hidden;


    /**
     * Returns the eventReservation
     *
     * @return \RKW\RkwEvents\Domain\Model\EventReservation $eventReservation
     */
    public function getEventReservation()
    {
        return $this->eventReservation;
    }

    /**
     * Sets the eventReservation
     *
     * @param \RKW\RkwEvents\Domain\Model\EventReservation $eventReservation
     * @return void
     */
    public function setEventReservation(\RKW\RkwEvents\Domain\Model\EventReservation $eventReservation)
    {
        $this->eventReservation = $eventReservation;
    }

    /**
     * Returns the salutation
     *
     * @return integer $salutation
     */
    public function getSalutation()
    {
        return $this->salutation;
    }

    /**
     * Sets the salutation
     *
     * @param integer $salutation
     * @return void
     */
    public function setSalutation($salutation)
    {
        $this->salutation = $salutation;
    }

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the txRkwregistrationTitle
     *
     * @return \RKW\RkwRegistration\Domain\Model\Title $txRkwregistrationTitle
     */
    public function getTxRkwregistrationTitle()
    {
        return $this->txRkwregistrationTitle;
    }

    /**
     * Sets the txRkwregistrationTitle
     *
     * Hint: default "null" is needed to make value in forms optional
     *
     * @param \RKW\RkwRegistration\Domain\Model\Title $txRkwregistrationTitle
     * @return void
     */
    public function setTxRkwregistrationTitle(\RKW\RkwRegistration\Domain\Model\Title $txRkwregistrationTitle = null)
    {
        if ($txRkwregistrationTitle) {
            $this->txRkwregistrationTitle = $txRkwregistrationTitle;
        }
    }

    /**
     * Returns the firstName
     *
     * @return string $firstName
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Sets the firstName
     *
     * @param string $firstName
     * @return void
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * Returns the lastName
     *
     * @return string $lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Sets the lastName
     *
     * @param string $lastName
     * @return void
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }


    /**
     * Returns the crdate value
     *
     * @return integer
     * @api
     */
    public function getCrdate()
    {

        return $this->crdate;
    }


    /**
     * Returns the tstamp value
     *
     * @return integer
     * @api
     */
    public function getTstamp()
    {
        return $this->tstamp;
    }

    /**
     * Sets the hidden value
     *
     * @param integer $hidden
     * @api
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }


    /**
     * Returns the hidden value
     *
     * @return integer
     * @api
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * Sets the deleted value
     *
     * @param integer $deleted
     * @api
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }


    /**
     * Returns the deleted value
     *
     * @return integer
     * @api
     */
    public function getDeleted()
    {
        return $this->deleted;
    }


}