<?php
namespace RKW\RkwRegistration\Tests\Integration\EventReservations;

use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use RKW\RkwEvents\Domain\Model\EventReservation;
use RKW\RkwEvents\Controller\EventCommandController;
use Nimut\TestingFramework\TestCase\FunctionalTestCase;
use RKW\RkwEvents\Domain\Repository\EventRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use RKW\RkwEvents\Domain\Repository\EventReservationRepository;

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
 * EventReservationTest
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwRegistration
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class EventReservationTest extends FunctionalTestCase
{

    /**
     * @var string[]
     */
    protected $testExtensionsToLoad = [
        'typo3conf/ext/static_info_tables',
        'typo3conf/ext/rkw_basics',
        'typo3conf/ext/rkw_events',
    ];

    /**
     * @var string[]
     */
    protected $coreExtensionsToLoad = [];

    /**
     * @var \RKW\RkwEvents\Domain\Model\EventReservation
     */
    private $subject = null;

    /**
     * @var \RKW\RkwEvents\Domain\Repository\EventRepository
     */
    private $eventRepository;

    /**
     * @var \RKW\RkwEvents\Controller\EventCommandController
     */
    private $eventCommandController = null;

    /**
     * @var \RKW\RkwEvents\Domain\Repository\EventReservationRepository
     */
    private $eventReservationRepository;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     */
    private $persistenceManager = null;

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    private $objectManager = null;

    /**
     * Setup
     */
    protected function setUp()
    {
        parent::setUp();

        $this->importDataSet(__DIR__ . '/EventReservationTest/Fixtures/Database/Global.xml');

        $this->setUpFrontendRootPage(
            1,
            [
                'EXT:rkw_basics/Configuration/TypoScript/setup.txt',
                'EXT:rkw_registration/Configuration/TypoScript/setup.txt',
                'EXT:rkw_events/Configuration/TypoScript/setup.txt',
                'EXT:rkw_events/Tests/Integration/Domain/EventReservations/EventReservationTest/Fixtures/Frontend/Configuration/Rootpage.typoscript',
            ]
        );

        $this->persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);

        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        $this->subject = $this->objectManager->get(EventReservation::class);
        $this->eventRepository = $this->objectManager->get(EventRepository::class);
        $this->eventReservationRepository = $this->objectManager->get(EventReservationRepository::class);
        $this->eventCommandController = $this->objectManager->get(EventCommandController::class);

    }

    //=============================================

    /**
     * @test
     */
    public function processPendingReservationsCommandAfterApprovalDateDoesSetReservationConfirmationDate()
    {
        /**
         * Scenario:
         *
         * Given an event is set to be automatically approved
         * And the approvalDate is set
         * And the approvalDate is in the past
         * And the registrationEndDate is still in the future
         * And seats are available
         * And a reservation to this event is set with confirmationDate = 0 (pending)
         * When I run the cronjob to process pending reservations
         * Then the reservation is confirmed
         * And the confirmationDate of the reservation is greater than 0
         */

        $this->importDataSet(__DIR__ . '/EventReservationTest/Fixtures/Database/Check010.xml');

        /** @var \RKW\RkwEvents\Domain\Model\Event */
        $event = $this->eventRepository->findByUid(1);
        //  set start date dynamically as a static start date may fail
        $event->setStart(time() + (10 * 86400));
        //  set approval date dynamically as a static approval date may fail
        $event->setApprovalDate(time() - 86400);
        //  set registration end date dynamically as a static registration date may fail
        $event->setRegEnd(time() + 86400);

        $this->eventRepository->update($event);
        $this->persistenceManager->persistAll();

        /** @var \RKW\RkwEvents\Domain\Model\EventReservation */
        $eventReservation = $this->eventReservationRepository->findByUid(1);

        static::assertSame(0, $eventReservation->getConfirmationDate());

        $this->eventCommandController->processPendingReservationsCommand();

        $eventReservation = $this->eventReservationRepository->findByUid(1);

        static::assertTrue($eventReservation->getConfirmationDate() > 0);
        static::assertSame(1, $event->getConfirmedReservations()->count());
        static::assertContains($eventReservation, $event->getConfirmedReservations());

    }

    /**
     * @test
     */
    public function processPendingReservationsCommandWithNoApprovalDateBeforeRegistratioEndDateDoesNotSetReservationConfirmationDate()
    {
        /**
         * Scenario:
         *
         * Given an event is set to be automatically approved
         * And the approvalDate is not set
         * And the regEnd is still in the future
         * And seats are available
         * And a reservation to this event is set with confirmationDate = 0 (pending)
         * When I run the cronjob to process pending reservations
         * Then the reservation is not confirmed
         * And the confirmationDate of the reservation is still 0 (pending)
         */

        $this->importDataSet(__DIR__ . '/EventReservationTest/Fixtures/Database/Check010.xml');

        /** @var \RKW\RkwEvents\Domain\Model\Event */
        $event = $this->eventRepository->findByUid(1);
        //  set start date dynamically as a static start date may fail
        $event->setStart(time() + (10 * 86400));
        //  set approval date dynamically as a static approval date may fail
        $event->setApprovalDate(0);
        //  set registration end date dynamically as a static registration date may fail
        $event->setRegEnd(time() + 86400);

        $this->eventRepository->update($event);
        $this->persistenceManager->persistAll();

        /** @var \RKW\RkwEvents\Domain\Model\EventReservation */
        $eventReservation = $this->eventReservationRepository->findByUid(1);

        static::assertSame(0, $eventReservation->getConfirmationDate());

        $this->eventCommandController->processPendingReservationsCommand();

        $eventReservation = $this->eventReservationRepository->findByUid(1);

        static::assertFalse($eventReservation->getConfirmationDate() > 0);
        static::assertSame(0, $event->getConfirmedReservations()->count());

    }

    /**
     * @test
     */
    public function processPendingReservationsCommandWithNoApprovalDateAfterRegistratioEndDateDoesSetReservationConfirmationDate()
    {
        /**
         * Scenario:
         *
         * Given an event is set to be automatically approved
         * And the approvalDate is not set
         * And the registrationEndDate is in the past
         * And seats are available
         * And a reservation to this event is set with confirmationDate = 0 (pending)
         * When I run the cronjob to process pending reservations
         * Then the reservation is confirmed
         * And the confirmationDate of the reservation is greater than 0
         */

        $this->importDataSet(__DIR__ . '/EventReservationTest/Fixtures/Database/Check010.xml');

        /** @var \RKW\RkwEvents\Domain\Model\Event */
        $event = $this->eventRepository->findByUid(1);
        //  set start date dynamically as a static start date may fail
        $event->setStart(time() + (10 * 86400));
        //  set approval date dynamically as a static approval date may fail
        $event->setApprovalDate(0);
        //  set registration end date dynamically as a static registration date may fail
        $event->setRegEnd(time() - 86400);

        $this->eventRepository->update($event);
        $this->persistenceManager->persistAll();

        /** @var \RKW\RkwEvents\Domain\Model\EventReservation */
        $eventReservation = $this->eventReservationRepository->findByUid(1);

        static::assertSame(0, $eventReservation->getConfirmationDate());

        $this->eventCommandController->processPendingReservationsCommand();

        $eventReservation = $this->eventReservationRepository->findByUid(1);

        static::assertTrue($eventReservation->getConfirmationDate() > 0);
        static::assertSame(1, $event->getConfirmedReservations()->count());

    }

    /**
     * @test
     */
    public function processPendingReservationsCommandWithEventSetToApprovalAutoEqualsFalseDoesNotProcessAnyReservations()
    {

        /**
         * Scenario:
         *
         * Given an event is not set to be automatically approved
         * And the approvalDate is set
         * And the approvalDate is in the past
         * And seats are available
         * And a reservation to this event is set with confirmationDate = 0 (pending)
         * When I run the cronjob to process pending reservations
         * Then the reservation is not confirmed
         * And the confirmationDate of the reservation is still 0 (pending)
         *
         */

        $this->importDataSet(__DIR__ . '/EventReservationTest/Fixtures/Database/Check010.xml');

        /** @var \RKW\RkwEvents\Domain\Model\Event */
        $event = $this->eventRepository->findByUid(1);
        //  set approval_auto to FALSE
        $event->setApprovalAuto(FALSE);
        //  set start date dynamically as a static start date may fail
        $event->setStart(time() + (10 * 86400));
        //  set approval date dynamically as a static approval date may fail
        $event->setApprovalDate(time() - 86400);
        //  set registration end date dynamically as a static registration date may fail
        $event->setRegEnd(time() + 86400);

        $this->eventRepository->update($event);
        $this->persistenceManager->persistAll();

        /** @var \RKW\RkwEvents\Domain\Model\EventReservation */
        $eventReservation = $this->eventReservationRepository->findByUid(1);
        static::assertSame(0, $eventReservation->getConfirmationDate());

        $eventList = $this->eventRepository->findAllUpcomingApprovableEvents($approvalAuto = TRUE);
        static::assertSame(0, $eventList->count());

    }

    /**
     * Scenario:
     *
     * Given an event has prioritized target groups
     * When I place a reservation
     * As non-member of prioritized target groups
     * Then my reservation has confirmationDate = 0
     *
     */

    /**
     * Scenario:
     *
     * Given an event has prioritized target groups
     * When I place a reservation
     * As member of prioritized target groups
     * Then my reservation has confirmationDate > 0
     *
     */

    /**
     * Scenario:
     *
     * Given an event has no prioritized target groups
     * When I place a reservation
     * Then my reservation has confirmationDate > 0
     *
     */

    /**
     * Scenario:
     *
     * Given an event has prioritized target groups
     * And the approvalAuto is true
     * And the approvalDate is set
     * And the approvalDate is in the past
     * When I place a reservation
     * Then my reservation has confirmationDate > 0
     *
     */

    /**
     * Scenario:
     *
     * Given an event has prioritized target groups
     * And the approvalAuto is false
     * And the approvalDate is set
     * And the approvalDate is in the past
     * When I place a reservation
     * As non-member of prioritized target groups
     * Then my reservation has confirmationDate == 0 (pending)
     *
     */

    /**
     * Scenario:
     *
     * Given an event has 1 seat
     * And already 1 confirmed reservation
     * When I place a reservation
     * Then it will throw an exception "Full"
     *
     */

    /**
     * TearDown
     */
    protected function tearDown()
    {
        parent::tearDown();
    }

}