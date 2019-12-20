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
 * Class Event
 *
 * @author Carlos Meyer <cm@davitec.de>
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEvents
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Event extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * title
     *
     * @var string
     */
    protected $title;

    /**
     * subtitle
     *
     * @var string
     */
    protected $subtitle;

    /**
     * start
     *
     * @var integer
     */
    protected $start;

    /**
     * end
     *
     * @var integer
     */
    protected $end;

    /**
     * longitude
     *
     * @var string
     */
    protected $longitude;

    /**
     * latitude
     *
     * @var string
     */
    protected $latitude;

    /**
     * testimonials
     *
     * @var string
     */
    protected $testimonials;

    /**
     * description
     *
     * @var string
     */
    protected $description;

    /**
     * targetGroup
     *
     * @var string
     */
    protected $targetGroup;

    /**
     * targetGroups
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwBasics\Domain\Model\TargetGroup>
     */
    protected $targetGroups = null;

    /**
     * prioritizedTargetGroups
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwBasics\Domain\Model\TargetGroup>
     */
    protected $prioritizedTargetGroups = null;

    /**
     *    schedule
     *
     * @var string
     */
    protected $schedule;


    /**
     * partner
     *
     * @var string
     */
    protected $partner;

    /**
     * seats
     *
     * @var integer
     */
    protected $seats;

    /**
     * costsReg
     *
     * @var float
     */
    protected $costsReg;

    /**
     * costsRed
     *
     * @var float
     */
    protected $costsRed;

    /**
     * costsRedCondition
     *
     * @var string
     */
    protected $costsRedCondition;

    /**
     * costsTax
     *
     * @var integer
     */
    protected $costsTax;

    /**
     * regRequired
     *
     * @var boolean
     */
    protected $regRequired = true;

    /**
     * regSingle
     *
     * @var boolean
     */
    protected $regSingle = false;

    /**
     * regEnd
     *
     * @var integer
     */
    protected $regEnd;

    /**
     * extRegLink
     *
     * @var string
     */
    protected $extRegLink;

    /**
     * onlineEvent
     *
     * @var bool
     */
    protected $onlineEvent;

    /**
     * onlineEventAccessLink
     *
     * @var string
     */
    protected $onlineEventAccessLink;

    /**
     * approvalAuto
     *
     * @var boolean
     */
    protected $approvalAuto = false;

    /**
     * approvalDate
     *
     * @var integer
     */
    protected $approvalDate;

    /**
     * Holds place
     *
     * @var \RKW\RkwEvents\Domain\Model\EventPlace
     */
    protected $place = null;

    /**
     * type
     *
     * @var \RKW\RkwBasics\Domain\Model\DocumentType
     */
    protected $documentType = null;

    /**
     * department
     *
     * @var \RKW\RkwBasics\Domain\Model\Department
     */
    protected $department = null;

    /**
     * department
     *
     * @var \RKW\RkwProjects\Domain\Model\Projects
     */
    protected $project = null;

    /**
     * Holds surveyBefore
     *
     * @var \RKW\RkwEvents\Domain\Model\Survey
     */
    protected $surveyBefore = null;

    /**
     * Holds surveyAfter
     *
     * @var \RKW\RkwEvents\Domain\Model\Survey
     */
    protected $surveyAfter = null;

    /**
     * Categories
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
     */
    protected $categories;

    /**
     * A series of events
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\EventSeries>
     */
    protected $series = null;

    /**
     * A couple of logos
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\FileReference>
     */
    protected $logos = null;

    /**
     * currency
     *
     * @var \SJBR\StaticInfoTables\Domain\Model\Currency
     */
    protected $currency = null;

    /**
     * Holds external contact
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\EventContact>
     */
    protected $externalContact = null;

    /**
     * Holds internal contacts
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\Authors>
     */
    protected $internalContact = null;

    /**
     * Holds internal contacts
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\BackendUser>
     */
    protected $beUser = null;

    /**
     * Holds organizer
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\EventOrganizer>
     */
    protected $organizer = null;

    /**
     * Holds add info
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\FileReference>
     */
    protected $addInfo = null;


    /**
     * Holds the presentations
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\FileReference>
     */
    protected $presentations = null;


    /**
     * Holds sheets
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\EventSheet>
     */
    protected $sheet = null;


    /**
     * Holds gallery1
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\FileReference>
     */
    protected $gallery1 = null;

    /**
     * Holds gallery2
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\FileReference>
     */
    protected $gallery2 = null;


    /**
     * Holds reservations
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\EventReservation>
     */
    protected $reservation = null;

    /**
     * Holds workshop1
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\EventWorkshop>
     */
    protected $workshop1 = null;

    /**
     * Holds workshop2
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\EventWorkshop>
     */
    protected $workshop2 = null;

    /**
     * Holds workshop3
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\EventWorkshop>
     */
    protected $workshop3 = null;

    /**
     * reminderMailTstamp
     *
     * @var integer
     */
    protected $reminderMailTstamp = 0;

    /**
     * surveyAfterMailTstamp
     *
     * @var integer
     */
    protected $surveyAfterMailTstamp = 0;

    /**
     * distance
     *
     * @var string
     */
    protected $distance;

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
    protected $hidden;


    /**
     * @var integer
     */
    protected $deleted;


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
        $this->series = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->logos = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->reservation = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->addInfo = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->sheet = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->externalContact = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->internalContact = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->beUser = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->organizer = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->presentations = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->gallery1 = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->gallery2 = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->workshop1 = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->workshop2 = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->workshop3 = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * Returns the subtitle
     *
     * @return string $subtitle
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Sets the subtitle
     *
     * @param string $subtitle
     * @return void
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * Returns the start
     *
     * @return integer $start
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Sets the start
     *
     * @param integer $start
     * @return void
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * Returns the end
     *
     * @return integer $end
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Sets the end
     *
     * @param integer $end
     * @return void
     */
    public function setEnd($end)
    {
        $this->end = $end;
    }

    /**
     * Returns the longitude
     *
     * @return string $longitude
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Sets the longitude
     *
     * @param string $longitude
     * @return void
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * Returns the latitude
     *
     * @return string $latitude
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Sets the latitude
     *
     * @param string $latitude
     * @return void
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * Returns the testimonials
     *
     * @return string $testimonials
     */
    public function getTestimonials()
    {
        return $this->testimonials;
    }

    /**
     * Sets the testimonials
     *
     * @param string $testimonials
     * @return void
     */
    public function setTestimonials($testimonials)
    {
        $this->testimonials = $testimonials;
    }

    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the targetGroup
     *
     * @return string $targetGroup
     */
    public function getTargetGroup()
    {
        return $this->targetGroup;
    }

    /**
     * Sets the targetGroup
     *
     * @param string $targetGroup
     * @return void
     */
    public function setTargetGroup($targetGroup)
    {
        $this->targetGroup = $targetGroup;
    }

    /**
     * Returns the targetGroups
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwBasics\Domain\Model\TargetGroup> $targetGroups
     */
    public function getTargetGroups()
    {
        return $this->targetGroups;
    }

    /**
     * Sets the targetGroups
     *
    * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwBasics\Domain\Model\TargetGroup> $targetGroups
    * @return void
    */
    public function setTargetGroups(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $targetGroups)
    {
        $this->targetGroups = $targetGroups;
    }

    /**
     * Returns the prioritizedTargetGroups
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwBasics\Domain\Model\TargetGroup> $targetGroups
     */
    public function getPrioritizedTargetGroups()
    {
        return $this->prioritizedTargetGroups;
    }

    /**
     * Sets the prioritizedTargetGroups
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwBasics\Domain\Model\TargetGroup> $prioritizedTargetGroups
     * @return void
     */
    public function setPrioritizedTargetGroups(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $prioritizedTargetGroups)
    {
        $this->prioritizedTargetGroups = $prioritizedTargetGroups;
    }

    /**
     * Returns the schedule
     *
     * @return string $schedule
     */
    public function getSchedule()
    {
        return $this->schedule;
    }

    /**
     * Sets the schedule
     *
     * @param string $schedule
     * @return void
     */
    public function setSchedule($schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * Returns the partner
     *
     * @return string $partner
     */
    public function getPartner()
    {
        return $this->partner;
    }

    /**
     * Sets the partner
     *
     * @param string $partner
     * @return void
     */
    public function setPartner($partner)
    {
        $this->partner = $partner;
    }

    /**
     * Returns the seats
     *
     * @return integer $seats
     */
    public function getSeats()
    {
        return $this->seats;
    }

    /**
     * Sets the seats
     *
     * @param integer $seats
     * @return void
     */
    public function setSeats($seats)
    {
        $this->seats = $seats;
    }

    /**
     * Returns the costsReg
     *
     * @return float $costsReg
     */
    public function getCostsReg()
    {
        return $this->costsReg;
    }

    /**
     * Sets the costsReg
     *
     * @param float $costsReg
     * @return void
     */
    public function setCostsReg($costsReg)
    {
        $this->costsReg = $costsReg;
    }

    /**
     * Returns the costsRed
     *
     * @return float $costsRed
     */
    public function getCostsRed()
    {
        return $this->costsRed;
    }

    /**
     * Sets the costsRed
     *
     * @param float $costsRed
     * @return void
     */
    public function setCostsRed($costsRed)
    {
        $this->costsRed = $costsRed;
    }

    /**
     * Returns the costsRedCondition
     *
     * @return string $costsRedCondition
     */
    public function getCostsRedCondition()
    {
        return $this->costsRedCondition;
    }

    /**
     * Sets the costsRedCondition
     *
     * @param string $costsRedCondition
     * @return void
     */
    public function setCostsRedCondition($costsRedCondition)
    {
        $this->costsRedCondition = $costsRedCondition;
    }

    /**
     * Returns the costsTax
     *
     * @return integer $costsTax
     */
    public function getCostsTax()
    {
        return $this->costsTax;
    }

    /**
     * Sets the costsTax
     *
     * @param integer $costsTax
     * @return void
     */
    public function setCostsTax($costsTax)
    {
        $this->costsTax = $costsTax;
    }

    /**
     * Returns the regRequired
     *
     * @return boolean $regRequired
     */
    public function getRegRequired()
    {
        return $this->regRequired;
    }

    /**
     * Sets the regRequired
     *
     * @param boolean $regRequired
     * @return void
     */
    public function setRegRequired($regRequired)
    {
        $this->regRequired = $regRequired;
    }

    /**
     * Returns the boolean state of regRequired
     *
     * @return boolean
     */
    public function isRegRequired()
    {
        return $this->regRequired;
    }

    /**
     * Returns the regSingle
     *
     * @return boolean $regSingle
     */
    public function getRegSingle()
    {
        return $this->regSingle;
    }

    /**
     * Sets the regSingle
     *
     * @param boolean $regSingle
     * @return void
     */
    public function setRegSingle($regSingle)
    {
        $this->regSingle = $regSingle;
    }

    /**
     * Returns the regEnd
     *
     * @return integer $regEnd
     */
    public function getRegEnd()
    {

        return $this->regEnd;
    }

    /**
     * Sets the regEnd
     *
     * @param integer $regEnd
     * @return void
     */
    public function setRegEnd($regEnd)
    {
        $this->regEnd = $regEnd;
    }

    /**
     * Returns the extRegLink
     *
     * @return string $extRegLink
     */
    public function getExtRegLink()
    {
        return $this->extRegLink;
    }

    /**
     * Sets the extRegLink
     *
     * @param string $extRegLink
     * @return void
     */
    public function setExtRegLink($extRegLink)
    {
        $this->extRegLink = $extRegLink;
    }

    /**
     * Returns the onlineEvent
     *
     * @return bool $onlineEvent
     */
    public function getOnlineEvent()
    {
        return $this->onlineEvent;
    }

    /**
     * Sets the onlineEvent
     *
     * @param bool $onlineEvent
     * @return void
     */
    public function setOnlineEvent($onlineEvent)
    {
        $this->onlineEvent = $onlineEvent;
    }


    /**
     * Returns the onlineEventAccessLink
     *
     * @return string $onlineEventAccessLink
     */
    public function getOnlineEventAccessLink()
    {
        return $this->onlineEventAccessLink;
    }

    /**
     * Sets the onlineEventAccessLink
     *
     * @param string $onlineEventAccessLink
     * @return void
     */
    public function setOnlineEventAccessLink($onlineEventAccessLink)
    {
        $this->onlineEventAccessLink = $onlineEventAccessLink;
    }


    /**
     * Returns the place
     *
     * @return \RKW\RkwEvents\Domain\Model\EventPlace $place
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Sets the place
     *
     * @param \RKW\RkwEvents\Domain\Model\EventPlace $place
     * @return void
     */
    public function setPlace(\RKW\RkwEvents\Domain\Model\EventPlace $place)
    {
        $this->place = $place;
    }

    /**
     * Returns the document type
     *
     * @return \RKW\RkwBasics\Domain\Model\DocumentType $documentType
     */
    public function getDocumentType()
    {
        return $this->documentType;
    }

    /**
     * Sets the document type
     *
     * @param \RKW\RkwBasics\Domain\Model\DocumentType $documentType
     * @return void
     */
    public function setDocumentType(\RKW\RkwBasics\Domain\Model\DocumentType $documentType)
    {
        $this->documentType = $documentType;
    }

    /**
     * Returns the department
     *
     * @return \RKW\RkwBasics\Domain\Model\Department $department
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Sets the department
     *
     * @param \RKW\RkwBasics\Domain\Model\Department $department
     * @return void
     */
    public function setDepartment(\RKW\RkwBasics\Domain\Model\Department $department)
    {
        $this->department = $department;
    }

    /**
     * Returns the end
     *
     * @return \RKW\RkwProjects\Domain\Model\Projects
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Sets the end
     *
     * @param \RKW\RkwProjects\Domain\Model\Projects $end
     * @return void
     */
    public function setProject($end)
    {
        $this->project = $end;
    }

    /**
     * Returns the surveyBefore
     *
     * @return \RKW\RkwEvents\Domain\Model\Survey $surveyBefore
     */
    public function getSurveyBefore()
    {
        return $this->surveyBefore;
    }

    /**
     * Sets the surveyBefore
     *
     * @param \RKW\RkwEvents\Domain\Model\Survey $surveyBefore
     * @return void
     */
    public function setSurveyBefore(\RKW\RkwEvents\Domain\Model\Survey $surveyBefore)
    {
        $this->surveyBefore = $surveyBefore;
    }

    /**
     * Returns the surveyAfter
     *
     * @return \RKW\RkwEvents\Domain\Model\Survey $surveyAfter
     */
    public function getSurveyAfter()
    {
        return $this->surveyAfter;
    }

    /**
     * Sets the surveyAfter
     *
     * @param \RKW\RkwEvents\Domain\Model\Survey $surveyAfter
     * @return void
     */
    public function setSurveyAfter(\RKW\RkwEvents\Domain\Model\Survey $surveyAfter)
    {
        $this->surveyAfter = $surveyAfter;
    }

    /**
     * Adds a Category
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\Category $category
     * @return void
     */
    public function addCategory(\TYPO3\CMS\Extbase\Domain\Model\Category $category)
    {
        $this->categories->attach($category);
    }

    /**
     * Removes a Category
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\Category $categoryToRemove The Category to be removed
     * @return void
     */
    public function removeCategory(\TYPO3\CMS\Extbase\Domain\Model\Category $categoryToRemove)
    {
        $this->categories->detach($categoryToRemove);
    }

    /**
     * Returns the categories
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category> $categories
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Sets the categories
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category> $categories
     * @return void
     */
    public function setCategories(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories)
    {
        $this->categories = $categories;
    }

    /**
     * Adds a EventSeries
     *
     * @param \RKW\RkwEvents\Domain\Model\EventSeries $series
     * @return void
     */
    public function addSeries(\RKW\RkwEvents\Domain\Model\EventSeries $series)
    {
        $this->series->attach($series);
    }

    /**
     * Removes a EventSeries
     *
     * @param \RKW\RkwEvents\Domain\Model\EventSeries $seriesToRemove The EventSeries to be removed
     * @return void
     */
    public function removeSeries(\RKW\RkwEvents\Domain\Model\EventSeries $seriesToRemove)
    {
        $this->series->detach($seriesToRemove);
    }

    /**
     * Returns the series
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\EventSeries> $series
     */
    public function getSeries()
    {
        return $this->series;
    }

    /**
     * Sets the series
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\EventSeries> $series
     * @return void
     */
    public function setSeries(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $series)
    {
        $this->series = $series;
    }

    /**
     * Adds a EventPartnerLogo
     *
     * @param \RKW\RkwEvents\Domain\Model\FileReference $logo
     * @return void
     */
    public function addLogo(\RKW\RkwEvents\Domain\Model\FileReference $logo)
    {
        $this->logos->attach($logo);
    }

    /**
     * Removes a EventPartnerLogo
     *
     * @param \RKW\RkwEvents\Domain\Model\FileReference $logoToRemove The EventPartnerLogo to be removed
     * @return void
     */
    public function removeLogo(\RKW\RkwEvents\Domain\Model\FileReference $logoToRemove)
    {
        $this->logos->detach($logoToRemove);
    }

    /**
     * Returns the logos
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\FileReference> $logos
     */
    public function getLogos()
    {
        return $this->logos;
    }

    /**
     * Sets the logos
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\FileReference> $logos
     * @return void
     */
    public function setLogos(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $logos)
    {
        $this->logos = $logos;
    }

    /**
     * Returns the currency
     *
     * @return \SJBR\StaticInfoTables\Domain\Model\Currency  $currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Sets the currency
     *
     * @param \SJBR\StaticInfoTables\Domain\Model\Currency $currency
     * @return void
     */
    public function setCurrency(\SJBR\StaticInfoTables\Domain\Model\Currency $currency)
    {
        $this->currency = $currency;
    }

    /**
     * Adds a externalContact
     *
     * @param \RKW\RkwEvents\Domain\Model\EventContact $externalContact
     * @return void
     */
    public function addExternalContact(\RKW\RkwEvents\Domain\Model\EventContact $externalContact)
    {
        $this->externalContact->attach($externalContact);
    }

    /**
     * Removes a externalContact
     *
     * @param \RKW\RkwEvents\Domain\Model\EventContact $externalContact
     * @return void
     */
    public function removeExternalContact(\RKW\RkwEvents\Domain\Model\EventContact $externalContact)
    {
        $this->externalContact->detach($externalContact);
    }

    /**
     * Returns the externalContact
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\EventContact> $externalContact
     */
    public function getExternalContact()
    {
        return $this->externalContact;
    }

    /**
     * Sets the externalContact
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\EventContact> $externalContact
     * @return void
     */
    public function setExternalContact(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $externalContact)
    {
        $this->externalContact = $externalContact;
    }


    /**
     * Adds a internalContact
     *
     * @param \RKW\RkwEvents\Domain\Model\Authors $internalContact
     * @return void
     */
    public function addInternalContact(\RKW\RkwEvents\Domain\Model\Authors $internalContact)
    {
        $this->internalContact->attach($internalContact);
    }

    /**
     * Removes a internalContact
     *
     * @param \RKW\RkwEvents\Domain\Model\Authors $internalContact
     * @return void
     */
    public function removeInternalContact(\RKW\RkwEvents\Domain\Model\Authors $internalContact)
    {
        $this->internalContact->detach($internalContact);
    }

    /**
     * Returns the internalContact
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\Authors> $internalContact
     */
    public function getInternalContact()
    {
        return $this->internalContact;
    }

    /**
     * Sets the internalContact
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\Authors> $internalContact
     * @return void
     */
    public function setInternalContact(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $internalContact)
    {
        $this->internalContact = $internalContact;
    }


    /**
     * Adds a beUser
     *
     * @param \RKW\RkwEvents\Domain\Model\BackendUser $beUser
     * @return void
     */
    public function addBeUser(\RKW\RkwEvents\Domain\Model\BackendUser $beUser)
    {
        $this->beUser->attach($beUser);
    }

    /**
     * Removes a beUser
     *
     * @param \RKW\RkwEvents\Domain\Model\BackendUser $backendUser
     * @return void
     */
    public function removeBeUser(\RKW\RkwEvents\Domain\Model\BackendUser $beUser)
    {
        $this->beUser->detach($beUser);
    }

    /**
     * Returns the beUser
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\BackendUser> $beUser
     */
    public function getBeUser()
    {
        return $this->beUser;
    }

    /**
     * Sets the beUser
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\BackendUser> $beUser
     * @return void
     */
    public function setBeUser(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $beUser)
    {
        $this->beUser = $beUser;
    }


    /**
     * Adds a organizer
     *
     * @param \RKW\RkwEvents\Domain\Model\EventOrganizer $organizer
     * @return void
     */
    public function addOrganizer(\RKW\RkwEvents\Domain\Model\EventOrganizer $organizer)
    {
        $this->organizer->attach($organizer);
    }

    /**
     * Removes a organizer
     *
     * @param \RKW\RkwEvents\Domain\Model\EventOrganizer $backendUser
     * @return void
     */
    public function removeOrganizer(\RKW\RkwEvents\Domain\Model\EventOrganizer $organizer)
    {
        $this->organizer->detach($organizer);
    }

    /**
     * Returns the organizer
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\EventOrganizer> $organizer
     */
    public function getOrganizer()
    {
        return $this->organizer;
    }

    /**
     * Sets the organizer
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\EventOrganizer> $organizer
     * @return void
     */
    public function setOrganizer(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $organizer)
    {
        $this->organizer = $organizer;
    }

    /**
     * Adds a addInfo
     *
     * @param \RKW\RkwEvents\Domain\Model\FileReference $addInfo
     * @return void
     */
    public function addAddInfo(\RKW\RkwEvents\Domain\Model\FileReference $addInfo)
    {
        $this->addInfo->attach($addInfo);
    }

    /**
     * Removes a addInfo
     *
     * @param \RKW\RkwEvents\Domain\Model\FileReference $addInfo
     * @return void
     */
    public function removeAddInfo(\RKW\RkwEvents\Domain\Model\FileReference $addInfo)
    {
        $this->addInfo->detach($addInfo);
    }

    /**
     * Returns the addInfo
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\FileReference> $addInfo
     */
    public function getAddInfo()
    {
        return $this->addInfo;
    }

    /**
     * Sets the addInfo
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\FileReference> $addInfo
     * @return void
     */
    public function setAddInfo(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $addInfo)
    {
        $this->addInfo = $addInfo;
    }

    /**
     * Adds a presentation
     *
     * @param \RKW\RkwEvents\Domain\Model\FileReference $presentation
     * @return void
     */
    public function addPresentations(\RKW\RkwEvents\Domain\Model\FileReference $presentation)
    {
        $this->presentations->attach($presentation);
    }

    /**
     * Removes a presentation
     *
     * @param \RKW\RkwEvents\Domain\Model\FileReference $presentation The file to be removed
     * @return void
     */
    public function removePresentations(\RKW\RkwEvents\Domain\Model\FileReference $presentation)
    {
        $this->presentations->detach($presentation);
    }

    /**
     * Returns the presentations
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\FileReference> $presentations
     */
    public function getPresentations()
    {
        return $this->presentations;
    }

    /**
     * Sets the presentations
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\FileReference> $presentations
     * @return void
     */
    public function setPresentations(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $presentations)
    {
        $this->presentations = $presentations;
    }


    /**
     * Adds a Sheet
     *
     * @param \RKW\RkwEvents\Domain\Model\EventSheet $sheet
     * @return void
     */
    public function addSheet(\RKW\RkwEvents\Domain\Model\EventSheet $sheet)
    {
        $this->sheet->attach($sheet);
    }

    /**
     * Removes a Sheet
     *
     * @param \RKW\RkwEvents\Domain\Model\EventSheet $sheet
     * @return void
     */
    public function removeSheet(\RKW\RkwEvents\Domain\Model\EventSheet $sheet)
    {
        $this->sheet->detach($sheet);
    }

    /**
     * Returns the Sheets
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\EventSheet> $sheets
     */
    public function getSheets()
    {
        return $this->sheet;
    }

    /**
     * Sets the Sheet
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\EventSheet> $sheet
     * @return void
     */
    public function setSheets(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $sheet)
    {
        $this->sheet = $sheet;
    }

    /**
     * Adds a FileReference
     *
     * @param \RKW\RkwEvents\Domain\Model\FileReference $image
     * @return void
     */
    public function addGallery1(\RKW\RkwEvents\Domain\Model\FileReference $image)
    {
        $this->gallery1->attach($image);
    }

    /**
     * Removes a FileReference
     *
     * @param \RKW\RkwEvents\Domain\Model\FileReference $imageToRemove The EventGalleryImage to be removed
     * @return void
     */
    public function removeGallery1(\RKW\RkwEvents\Domain\Model\FileReference $imageToRemove)
    {
        $this->gallery1->detach($imageToRemove);
    }

    /**
     * Returns the reference
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\FileReference> $images
     */
    public function getGallery1()
    {
        return $this->gallery1;
    }

    /**
     * Sets the gallery1
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\FileReference> $images
     * @return void
     */
    public function setGallery1(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $images)
    {
        $this->gallery1 = $images;
    }

    /**
     * Adds a FileReference
     *
     * @param \RKW\RkwEvents\Domain\Model\FileReference $image
     * @return void
     */
    public function addGallery2(\RKW\RkwEvents\Domain\Model\FileReference $image)
    {
        $this->gallery2->attach($image);
    }

    /**
     * Removes a FileReference
     *
     * @param \RKW\RkwEvents\Domain\Model\FileReference $imageToRemove The EventGalleryImage to be removed
     * @return void
     */
    public function removeGallery2(\RKW\RkwEvents\Domain\Model\FileReference $imageToRemove)
    {
        $this->gallery2->detach($imageToRemove);
    }

    /**
     * Returns the reference
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\FileReference> $images
     */
    public function getGallery2()
    {
        return $this->gallery2;
    }

    /**
     * Sets the gallery1
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\FileReference> $images
     * @return void
     */
    public function setGallery2(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $images)
    {
        $this->gallery2 = $images;
    }

    /**
     * Adds a EventReservation
     *
     * @param \RKW\RkwEvents\Domain\Model\EventReservation $reservation
     * @return void
     */
    public function addReservation(\RKW\RkwEvents\Domain\Model\EventReservation $reservation)
    {
        $this->reservation->attach($reservation);
    }

    /**
     * Removes a EventReservation
     *
     * @param \RKW\RkwEvents\Domain\Model\EventReservation $reservationToRemove The EventReservation to be removed
     * @return void
     */
    public function removeReservation(\RKW\RkwEvents\Domain\Model\EventReservation $reservationToRemove)
    {
        $this->reservation->detach($reservationToRemove);
    }

    /**
     * Returns the reservations
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\EventReservation> $reservation
     */
    public function getReservation()
    {
        return $this->reservation;
    }

    /**
     * Sets the reservation
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\EventReservation> $reservation
     * @return void
     */
    public function setReservation(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Returns the pending reservations
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\EventReservation> $reservation
     */
    public function getPendingReservations()
    {
        $eventReservationRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwEvents\\Domain\\Repository\\EventReservationRepository');

        return $eventReservationRepository->findAllPendingReservationsByEvent($this);
    }

    /**
     * Returns the confirmed reservations
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\EventReservation> $reservation
     */
    public function getConfirmedReservations()
    {
        $eventReservationRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwEvents\\Domain\\Repository\\EventReservationRepository');

        return $eventReservationRepository->findAllConfirmedReservationsByEvent($this);
    }

    /**
     * Adds a EventWorkshop
     *
     * @param \RKW\RkwEvents\Domain\Model\EventWorkshop $workshop
     * @return void
     */
    public function addWorkshop1(\RKW\RkwEvents\Domain\Model\EventWorkshop $workshop)
    {
        $this->workshop1->attach($workshop);
    }

    /**
     * Removes a EventWorkshop
     *
     * @param \RKW\RkwEvents\Domain\Model\EventWorkshop $workshop
     * @return void
     */
    public function removeWorkshop1(\RKW\RkwEvents\Domain\Model\EventWorkshop $workshop)
    {
        $this->workshop1->detach($workshop);
    }

    /**
     * Returns the EventWorkshop
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\EventWorkshop> $workshop
     */
    public function getWorkshop1()
    {
        return $this->workshop1;
    }

    /**
     * Sets the EventWorkshop
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\EventWorkshop> $workshop
     * @return void
     */
    public function setWorkshop1(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $workshop)
    {
        $this->workshop1 = $workshop;
    }

    /**
     * Adds a EventWorkshop
     *
     * @param \RKW\RkwEvents\Domain\Model\EventWorkshop $workshop
     * @return void
     */
    public function addWorkshop2(\RKW\RkwEvents\Domain\Model\EventWorkshop $workshop)
    {
        $this->workshop2->attach($workshop);
    }

    /**
     * Removes a EventWorkshop
     *
     * @param \RKW\RkwEvents\Domain\Model\EventWorkshop $workshop
     * @return void
     */
    public function removeWorkshop2(\RKW\RkwEvents\Domain\Model\EventWorkshop $workshop)
    {
        $this->workshop2->detach($workshop);
    }

    /**
     * Returns the EventWorkshop
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\EventWorkshop> $workshop
     */
    public function getWorkshop2()
    {
        return $this->workshop2;
    }

    /**
     * Sets the EventWorkshop
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\EventWorkshop> $workshop
     * @return void
     */
    public function setWorkshop2(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $workshop)
    {
        $this->workshop2 = $workshop;
    }

    /**
     * Adds a EventWorkshop
     *
     * @param \RKW\RkwEvents\Domain\Model\EventWorkshop $workshop
     * @return void
     */
    public function addWorkshop3(\RKW\RkwEvents\Domain\Model\EventWorkshop $workshop)
    {
        $this->workshop3->attach($workshop);
    }

    /**
     * Removes a EventWorkshop
     *
     * @param \RKW\RkwEvents\Domain\Model\EventWorkshop $workshop
     * @return void
     */
    public function removeWorkshop3(\RKW\RkwEvents\Domain\Model\EventWorkshop $workshop)
    {
        $this->workshop3->detach($workshop);
    }

    /**
     * Returns the EventWorkshop
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\EventWorkshop> $workshop
     */
    public function getWorkshop3()
    {
        return $this->workshop3;
    }

    /**
     * Sets the EventWorkshop
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEvents\Domain\Model\EventWorkshop> $workshop
     * @return void
     */
    public function setWorkshop3(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $workshop)
    {
        $this->workshop3 = $workshop;
    }

    /**
     * Returns the reminderMailTstamp
     *
     * @return integer $reminderMailTstamp
     */
    public function getReminderMailTstamp()
    {
        return $this->reminderMailTstamp;
    }

    /**
     * Sets the reminderMailTstamp
     *
     * @param integer $reminderMailTstamp
     * @return void
     */
    public function setReminderMailTstamp($reminderMailTstamp)
    {
        $this->reminderMailTstamp = $reminderMailTstamp;
    }

    /**
     * Returns the surveyAfterMailTstamp
     *
     * @return integer $surveyAfterMailTstamp
     */
    public function getSurveyAfterMailTstamp()
    {
        return $this->surveyAfterMailTstamp;
    }

    /**
     * Sets the surveyAfterMailTstamp
     *
     * @param integer $surveyAfterMailTstamp
     * @return void
     */
    public function setSurveyAfterMailTstamp($surveyAfterMailTstamp)
    {
        $this->surveyAfterMailTstamp = $surveyAfterMailTstamp;
    }


    /**
     * Returns the distance
     *
     * @return integer $distance
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Sets the distance
     *
     * @param integer $distance
     * @return void
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
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

    /**
     * @return int
     */
    public function getApprovalDate()
    {
        return $this->approvalDate;
    }

    /**
     * @param int $approvalDate
     */
    public function setApprovalDate($approvalDate)
    {
        $this->approvalDate = $approvalDate;
    }

    /**
     * @return bool
     */
    public function isApprovalAuto()
    {
        return $this->approvalAuto;
    }

    /**
     * @param bool $approvalAuto
     */
    public function setApprovalAuto($approvalAuto)
    {
        $this->approvalAuto = $approvalAuto;
    }

}