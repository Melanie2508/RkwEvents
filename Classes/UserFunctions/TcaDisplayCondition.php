<?php

namespace RKW\RkwEvents\UserFunctions;

use Konafets\Typo3Debugbar\Overrides\DebuggerUtility;
use \RKW\RkwBasics\Helper\Common;
use \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

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
 * Class TcaDisplayCondition
 *
 * @package   RKW_RkwSearch
 * @author    Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @licence http://www.gnu.org/copyleft/gpl.htm GNU General Public License, version 2 or later
 */
class TcaDisplayCondition
{

    /**
     * @var array Contains the TypoScript settings
     */
    protected $settings;


    /**
     * Checks if typoscript setting "disableInternalRegistration" is active
     *
     * @return bool
     */
    public function displayIfDisableInternalRegistrationIsFalse()
    {
        $settings = $this->getSettings();
        // if true: Don't show entry
        // if false: Show entry
        return (bool) $settings['disableInternalRegistration'] ? false : true;
        //===
    }


    /**
     * Returns TYPO3 settings
     *
     * @param string $which Which type of settings will be loaded
     * @return array
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    protected function getSettings($which = ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS)
    {
        return Common::getTyposcriptConfiguration('Rkwevents', $which);
        //===
    }
}