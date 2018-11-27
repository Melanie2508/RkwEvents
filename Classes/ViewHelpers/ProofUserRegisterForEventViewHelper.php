<?php

namespace RKW\RkwEvents\ViewHelpers;
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
 * Class ProofUserRegisterForEvent
 *
 * @author Carlos Meyer <cm@davitec.de>
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEvents
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ProofUserRegisterForEventViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * return TRUE, if given frontendUser are registered (for given event)
     *
     * @param \RKW\RkwEvents\Domain\Model\Event $event
     * @param \RKW\RkwEvents\Domain\Model\FrontendUser $frontendUser
     * @return bool
     */
    public function render($event, $frontendUser)
    {

        /** @var \RKW\RkwEvents\Domain\Model\EventReservation $reservation */
        foreach ($event->getReservation() as $reservation) {

            if ($reservation->getFeUser()->getUid() == $frontendUser->getUid()) {
                return true;
                //===
            }
        }

        return false;
        //===
    }

}