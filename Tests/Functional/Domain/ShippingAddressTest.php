<?php
namespace RKW\RkwEvents\Tests\Functional\Domain;

use Nimut\TestingFramework\TestCase\FunctionalTestCase;
use RKW\RkwEvents\Domain\Model\EventReservation;
use RKW\RkwEvents\Domain\Repository\EventRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

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
 * ShippingAddress
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEvents
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ShippingAddressTest extends FunctionalTestCase
{

    /**
     * @var string[]
     */
    protected $testExtensionsToLoad = [
        'typo3conf/ext/rkw_basics',
        'typo3conf/ext/static_info_tables',
        'typo3conf/ext/rkw_registration',
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
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     */
    private $persistenceManager = null;

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    private $objectManager = null;

    /**
     * Setup
     * @throws \Exception
     */
    protected function setUp()
    {
        parent::setUp();

        $this->importDataSet(__DIR__ . '/../Fixtures/Database/Pages.xml');
        $this->importDataSet(__DIR__ . '/../Fixtures/Database/Events.xml');

        $this->setUpFrontendRootPage(
            1,
            [
                'EXT:rkw_registration/Configuration/TypoScript/setup.txt',
            ]
        );

        $this->persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);

        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->eventRepository = $this->objectManager->get(EventRepository::class);

        $this->subject = $this->objectManager->get(EventReservation::class);

    }

    /**
     * @test
     */
    public function aShippingAddressCanBeAdded()
    {
        $event = $this->eventRepository->findByUid(1);

        $mockShippingAddress = $this->getMock('\RKW\RkwRegistration\Domain\Model\ShippingAddress');

        $this->subject->setEvent($event);
        $this->subject->setShippingAddress($mockShippingAddress);

        static::assertEquals($this->subject->getShippingAddress(), $mockShippingAddress);
        static::assertSame($this->subject->getShippingAddress(), $mockShippingAddress);
    }

    /**
     * TearDown
     */
    protected function tearDown()
    {
        parent::tearDown();
    }

}