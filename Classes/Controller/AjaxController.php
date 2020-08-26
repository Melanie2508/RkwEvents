<?php

namespace RKW\RkwEvents\Controller;

use RKW\RkwEvents\Utility\DivUtility;
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
 * Class AjaxController
 *
 * @author Carlos Meyer <cm@davitec.de>
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEvents
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class AjaxController extends \RKW\RkwAjax\Controller\AjaxAbstractController
{
    /**
     * eventRepository
     *
     * @var \RKW\RkwEvents\Domain\Repository\EventRepository
     * @inject
     */
    protected $eventRepository = null;


    /**
     * filterAction
     *
     * @param array $filter
     * @param integer $page
     * @param bool $archive
     * @return string
     */
    public function filterAction($filter = array(), $page = 0, $archive = false)
    {
        // 1. filter the filterArray ;-)
        foreach ($filter as $key => $value) {
            $filter[$key] = filter_var($value, FILTER_SANITIZE_STRING);
        }

        // 2. get event list
        $listItemsPerView = intval($this->settings['itemsPerPage']) ? intval($this->settings['itemsPerPage']) : 10;
        $queryResult = $this->eventRepository->findByFilterOptions($filter, $listItemsPerView, intval($page), boolval($archive));

        // 3. proof if we have further results (query with listItemsPerQuery + 1)
        $lastItem = null;
        $eventList = DivUtility::prepareResultsList($queryResult, $listItemsPerView, intval($page), $lastItem);

        // 4. Check if we need to display a more-link
        $showMoreLink = count($eventList) < count($queryResult) ? true : false;
        if ($page > 0) {
            $showMoreLink = count($eventList) < (count($queryResult) - 1) ? true : false;
        }

        // 5. sort event list (group by month) - only if no distance search is performed
        $sortedEventList = array();
        if (
            ($page > 0)
            && (!$filter['address'])
        ) {
            $sortedEventList = DivUtility::groupEventsByMonthMore($eventList, $lastItem);

        } else {
            if (!$filter['address']) {
                $sortedEventList = DivUtility::groupEventsByMonth($eventList);
            }
        }

        // get new list
        $replacements = array(
            'ajaxTypeNum'  => intval($this->settings['ajaxTypeNum']),
            'showPid'      => intval($this->settings['showPid']),
            'pageMore'     => $page + 1,
            'showMoreLink' => $showMoreLink,
            'filter'       => $filter,
            'noGrouping'   => ($filter['address'] ? true : $this->settings['list']['noGrouping']),
        );

        if ($this->settings['version'] == 1) {
            /** @deprecated  */
            $relatedId = '';
            $action = '';
            $template = '';
        }

        if ($page > 0) {

            // set Data for old AjaxApi
            if ($this->settings['version'] == 1) {
                /** @deprecated  */
                $relatedId = 'tx-rkwevents-grid-section';
                $action = 'append';
                $template = 'Ajax/List/More.html';
            }

            // if a distance search is performed or noGrouping is explicitly set we do not group by month
            if ($filter['address'] OR $filter['noGrouping']) {

                $replacements['sortedEventList'] = $eventList;
                $replacements['geosearch'] = true;
                $replacements['noGrouping'] = true;

            } else {

                // set append list
                if ($sortedEventList['append']) {
                    $replacements['sortedEventList'] = $sortedEventList['append'];
                }

                // set insert list
                if (
                    ($lastItem instanceof \RKW\RkwEvents\Domain\Model\Event)
                    && ($sortedEventList['insert'])
                ) {

                    $startDateLastItem = new \DateTime(date('d-m-Y', $lastItem->getStart()));
                    $replacements['sortedEventList'] = $sortedEventList['insert'];
                    $replacements['noGrouping'] = true;
                    $replacements['showMoreLink'] = false;

                    // set Data for old AjaxApi
                    if ($this->settings['version'] == 1) {
                        /** @deprecated  */
                        // set Data for old AjaxApi
                        $relatedId = 'tx-rkwevents-results-' . $startDateLastItem->format("Y") . '-' . $startDateLastItem->format("m");
                    }

                }
            }

        } else {

            // set Data for old AjaxApi
            if ($this->settings['version'] == 1) {
                /** @deprecated  */
                // set Data for old AjaxApi
                $relatedId = 'tx-rkwevents-result-section';
                $action = 'replace';
                $template = 'Ajax/List/List.html';
            }

            // if a distance search is performed or noGrouping is explicitly set we do not group by month
            if ($filter['address'] OR $filter['noGrouping']) {

                $replacements['sortedEventList'] = $eventList;
                $replacements['geosearch'] = true;
                $replacements['noGrouping'] = true;

            } else {
                $replacements['sortedEventList'] = $sortedEventList;
                $replacements['noGrouping'] = $this->settings['list']['noGrouping'];
            }
        }


        /** New version */
        if ($this->settings['version'] == 2) {

            $this->view->assignMultiple($replacements);

        } else {

            /** @deprecated  */
            // get JSON helper
            /** @var \RKW\RkwBasics\Helper\Json $jsonHelper */
            $jsonHelper = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\\RkwBasics\\Helper\\Json');
            $jsonHelper->setHtml(
                $relatedId,
                $replacements,
                $action,
                $template
            );
            print (string)$jsonHelper;
            exit();
            //===
        }
    }
}

