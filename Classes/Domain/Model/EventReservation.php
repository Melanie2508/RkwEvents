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
 * Class EventReservation
 *
 * @author Carlos Meyer <cm@davitec.de>
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEvents
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class EventReservation extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{


    /**
     * event
     *
     * @var \RKW\RkwEvents\Domain\Model\Event
     */
    protected $event = null;

    /**
     * addPerson
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\EventReservationAddPerson>
     * @cascade remove
     */
    protected $addPerson = null;

    /**
     * feUser
     *
     * @var \RKW\RkwEvents\Domain\Model\FrontendUser
     */
    protected $feUser = null;

    /**
     * salutation
     *
     * @var integer
     */
    protected $salutation = 99;

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
     * company
     *
     * @var string
     */
    protected $company;

    /**
     * address
     *
     * @var string
     */
    protected $address;

    /**
     * zip
     *
     * @var string
     */
    protected $zip;

    /**
     * city
     *
     * @var string
     */
    protected $city;

    /**
     * phone
     *
     * @var string
     */
    protected $phone;

    /**
     * fax
     *
     * @var string
     */
    protected $fax;

    /**
     * email
     *
     * @var string
     */
    protected $email;

    /**
     * targetGroup
     *
     * @var \RKW\RkwBasics\Domain\Model\TargetGroup
     */
    protected $targetGroup = null;

    /**
     * remark
     *
     * @var string
     */
    protected $remark;


    /**
     * workshopRegister
     *
     * @var array
     */
    protected $workshopRegister;


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
     * serverHost
     *
     * @var string
     */
    protected $serverHost = '';

    /**
     * confirmationDate
     *
     * @var integer
     */
    protected $confirmationDate;

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->addPerson = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the remark
     *
     * @return string $remark
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * Sets the remark
     *
     * @param string $remark
     * @return void
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;
    }


    /**
     * Adds a EventReservationAddPerson
     *
     * @param \RKW\RkwEvents\Domain\Model\EventReservationAddPerson $addPerson
     * @return void
     */
    public function addAddPerson(\RKW\RkwEvents\Domain\Model\EventReservationAddPerson $addPerson)
    {
        $this->addPerson->attach($addPerson);
    }

    /**
     * Removes a EventReservationAddPerson
     *
     * @param \RKW\RkwEvents\Domain\Model\EventReservationAddPerson $addPersonToRemove The EventReservationAddPerson to be removed
     * @return void
     */
    public function removeAddPerson(\RKW\RkwEvents\Domain\Model\EventReservationAddPerson $addPersonToRemove)
    {
        $this->addPerson->detach($addPersonToRemove);
    }

    /**
     * Returns the addPerson
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\EventReservationAddPerson> $addPerson
     */
    public function getAddPerson()
    {
        return $this->addPerson;
    }

    /**
     * Sets the addPerson
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\EventReservationAddPerson> $addPerson
     * @return void
     */
    public function setAddPerson(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $addPerson)
    {
        $this->addPerson = $addPerson;
    }

    /**
     * Returns the feUser
     *
     * @return  \RKW\RkwEvents\Domain\Model\FrontendUser
     */
    public function getFeUser()
    {
        return $this->feUser;
    }

    /**
     * Sets the feUser
     *
     * @param \RKW\RkwRegistration\Domain\Model\FrontendUser|\RKW\RkwEvents\Domain\Model\FrontendUser $feUser
     * @return void
     */
    public function setFeUser($feUser)
    {
        $this->feUser = $feUser;
    }

    /**
     * Returns the event
     *
     * @return \RKW\RkwEvents\Domain\Model\Event $event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Sets the event
     *
     * @param \RKW\RkwEvents\Domain\Model\Event $event
     * @return void
     */
    public function setEvent(\RKW\RkwEvents\Domain\Model\Event $event)
    {
        $this->event = $event;
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
     * Returns the company
     *
     * @return string $company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Sets the company
     *
     * @param string $company
     * @return void
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * Returns the address
     *
     * @return string $address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Sets the address
     *
     * @param string $address
     * @return void
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Returns the zip
     *
     * @return string $zip
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Sets the zip
     *
     * @param string $zip
     * @return void
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * Returns the city
     *
     * @return string $city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Sets the city
     *
     * @param string $city
     * @return void
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Returns the phone
     *
     * @return string $phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Sets the phone
     *
     * @param string $phone
     * @return void
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * Returns the fax
     *
     * @return string $fax
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Sets the fax
     *
     * @param string $fax
     * @return void
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    }

    /**
     * Returns the email
     *
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the email
     *
     * @param string $email
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }


    /**
     * Returns the workshopRegister
     *
     * @return string $workshopRegister
     */
    public function getWorkshopRegister()
    {
        return $this->workshopRegister;
    }

    /**
     * Sets the workshopRegister
     *
     * @param string $workshopRegister
     * @return void
     */
    public function setWorkshopRegister($workshopRegister)
    {
        $this->workshopRegister = $workshopRegister;
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

    /**
     * Sets the serverHost value
     *
     * @param string $serverHost
     * @return void
     */
    public function setServerHost($serverHost)
    {
        $this->serverHost = $serverHost;
    }

    /**
     * Returns the serverHost value
     *
     * @return string
     */
    public function getServerHost()
    {
        return $this->serverHost;
    }

    /**
     * @return \RKW\RkwBasics\Domain\Model\TargetGroup
     */
    public function getTargetGroup()
    {
        return $this->targetGroup;
    }

    /**
     * @param \RKW\RkwBasics\Domain\Model\TargetGroup $targetGroup
     * @return void
     */
    public function setTargetGroup($targetGroup)
    {
        $this->targetGroup = $targetGroup;
    }

    /**
     * Returns the confirmationDate
     *
     * @return int
     */
    public function getConfirmationDate()
    {
        return $this->confirmationDate;
    }

    /**
     * Sets the confirmationDate
     *
     * @param int $confirmationDate
     * @return void
     */
    public function setConfirmationDate($confirmationDate)
    {
        $this->confirmationDate = $confirmationDate;
    }
}