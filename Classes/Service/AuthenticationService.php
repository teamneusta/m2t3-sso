<?php
declare(strict_types = 1);

namespace TeamNeustaGmbH\M2T3\Sso\Service;

/**
 * This file is part of the TeamNeustaGmbH/m2t3 package.
 *
 * Copyright (c) 2017 neusta GmbH | Ein team neusta Unternehmen
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * @license https://opensource.org/licenses/BSD-3-Clause  BSD-3-Clause License
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class AuthenticationService
 */
class AuthenticationService extends \TYPO3\CMS\Sv\AuthenticationService
{
    /**
     * magentoService
     *
     * @var MagentoService
     */
    protected $magentoService;

    /**
     * AuthenticationService constructor.
     */
    public function __construct()
    {
        $this->magentoService = GeneralUtility::makeInstance(MagentoService::class);
    }

    /**
     * Authenticate a user (Check various conditions for the user that might invalidate its authentication, eg. password match, domain, IP, etc.)
     *
     * @param array $user Data of user.
     * @return int >= 200: User authenticated successfully.
     *                     No more checking is needed by other auth services.
     *             >= 100: User not authenticated; this service is not responsible.
     *                     Other auth services will be asked.
     *             > 0:    User authenticated successfully.
     *                     Other auth services will still be asked.
     *             <= 0:   Authentication failed, no more checking needed
     *                     by other auth services.
     */
    public function authUser(array $user): int
    {
        $ok = 100;

        if (!empty($this->magentoService->getUser())) {
            $ok = 0;
        }

        return $ok;
    }

    /**
     * @return bool|mixed
     */
    public function getUser()
    {
        return $this->magentoService->getUser() ?: false;
    }
}
