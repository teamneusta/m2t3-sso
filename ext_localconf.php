<?php
/**
 * This file is part of the TeamNeustaGmbH/m2t3 package.
 *
 * Copyright (c) 2017 neusta GmbH | Ein team neusta Unternehmen
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * @license https://opensource.org/licenses/BSD-3-Clause  BSD-3-Clause License
 */

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

if (!empty($EXT_CONFIG) && $EXT_CONFIG['enableFetchUserIfNoSession']) {
    $TYPO3_CONF_VARS['SVCONF']['auth']['setup']['FE_fetchUserIfNoSession'] = 1;
} else {
    $TYPO3_CONF_VARS['SVCONF']['auth']['setup']['FE_alwaysFetchUser'] = 1;
}

// m2t3_sso
if (empty($TYPO3_CONF_VARS['EXTCONF'][$_EXTKEY]['SSO'])) {
    $TYPO3_CONF_VARS['EXTCONF'][$_EXTKEY] = [
        'SSO' => [
            'url'        => '',
            'cookieName' => ''
        ]
    ];
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService(
    $_EXTKEY,
    'auth' /* sv type */,
    'TeamNeustaGmbH\\M2T3\\Sso\\Service\\AuthenticationService' /* sv key */,
    [
        'title'       => 'Authentication service',
        'description' => 'Authentication service for LDAP and SSO environment.',

        'subtype' => 'getUserFE,authUserFE',

        'available' => true,
        'priority'  => 80,
        'quality'   => 80,

        'os'   => '',
        'exec' => '',

        'className' => 'TeamNeustaGmbH\\M2T3\\Sso\\Service\\AuthenticationService',
    ]
);
