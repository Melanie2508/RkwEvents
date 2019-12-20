<?php

namespace RKW\RkwEvents\Domain\Repository;

use RKW\RkwEvents\Helper\DivUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

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
 * Class EventReservationRepository
 * The repository for EventReservations
 *
 * @author Carlos Meyer <cm@davitec.de>
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEvents
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class EventReservationRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * Persistence Manager
     *
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager;


    /**
     * function findByEvent
     *
     * @param \RKW\RkwEvents\Domain\Model\Event|int $event
     * @param bool $respectStoragePid
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByEvent($event, $respectStoragePid = true)
    {
        $query = $this->createQuery();
        if (!$respectStoragePid) {
            $query->getQuerySettings()->setRespectStoragePage(false);
        }

        return $query->matching(
            $query->equals('event', $event)
        )->execute();
        //===
    }


    /**
     * function findAllPendingReservationsByEvent
     *
     * @param \RKW\RkwEvents\Domain\Model\Event|int $event
     * @param bool $respectStoragePid
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findAllPendingReservationsByEvent($event, $respectStoragePid = true)
    {
        $query = $this->createQuery();
        if (!$respectStoragePid) {
            $query->getQuerySettings()->setRespectStoragePage(false);
        }

        $query->setOrderings([
            'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
        ]);

        return $query->matching(
            $query->logicalAnd(
                $query->equals('event', $event),
                $query->equals('confirmation_date', 0)
            )
        )->execute();
        //===
    }

    /**
     * function findAllConfirmedReservationsByEvent
     *
     * @param \RKW\RkwEvents\Domain\Model\Event|int $event
     * @param bool $respectStoragePid
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findAllConfirmedReservationsByEvent($event, $respectStoragePid = true)
    {
        $query = $this->createQuery();
        if (!$respectStoragePid) {
            $query->getQuerySettings()->setRespectStoragePage(false);
        }

        $query->setOrderings([
            'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
        ]);

        return $query->matching(
            $query->logicalAnd(
                $query->equals('event', $event),
                $query->greaterThan('confirmation_date', 0)
            )
        )->execute();
        //===
    }

    /**
     * function findByFeUser
     *
     * @param \RKW\RkwRegistration\Domain\Model\FrontendUser|\RKW\RkwEvents\Domain\Model\FrontendUser $feUser
     * @param bool $respectStoragePid
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByFeUser($feUser, $respectStoragePid = true)
    {
        $query = $this->createQuery();
        if (!$respectStoragePid) {
            $query->getQuerySettings()->setRespectStoragePage(false);
        }

        $query->setOrderings(
            array(
                'crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING,
            )
        );

        return $query->matching(
            $query->equals('feUser', $feUser)
        )->execute();
        //===
    }


    /**
     * function findByEventAndFeUser
     *
     * @param \RKW\RkwEvents\Domain\Model\Event $event
     * @param \RKW\RkwRegistration\Domain\Model\FrontendUser|\RKW\RkwEvents\Domain\Model\FrontendUser $feUser
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */

    public function findByEventAndFeUser($event, $feUser)
    {
        $query = $this->createQuery();

        return $query->matching(
            $query->logicalAnd(
                $query->equals('feUser', $feUser),
                $query->equals('event', $event)
            )
        )->execute();
        //===
    }


    /**
     * Find all events that have been updated recently
     *
     * @api Used by SOAP-API
     * @param integer $timestamp
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findByTimestamp($timestamp)
    {

        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->getQuerySettings()->setIncludeDeleted(true);
        $query->getQuerySettings()->setIgnoreEnableFields(true);

        $query->matching(
            $query->greaterThanOrEqual('tstamp', intval($timestamp))
        );
        $query->setOrderings(array('tstamp' => QueryInterface::ORDER_ASCENDING));

        return $query->execute();
        //===
    }


    /**
     * Returns PersistanceManager
     *
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     */
    protected function getPersistanceManager()
    {

        if (!$this->persistenceManager) {
            $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
            $this->persistenceManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        }

        return $this->persistenceManager;
        //===
    }

}