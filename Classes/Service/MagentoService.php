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

declare(strict_types = 1);

namespace TeamNeustaGmbH\M2T3\Sso\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;

class MagentoService
{

    /**
     * url
     *
     * @var string
     */
    protected $url;

    /**
     * cookieName
     *
     * @var string
     */
    protected $cookieName;

    /**
     * MagentoService constructor.
     */
    public function __construct()
    {
        $this->initConfiguration();
    }

    /**
     * initConfiguration
     *
     * @return void
     * @throws \Exception
     */
    protected function initConfiguration()
    {
        if (!empty($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['m2t3_sso']['SSO'])) {
            if (!empty($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['m2t3_sso']['SSO']['url'])) {
                $this->setUrl($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['m2t3_sso']['SSO']['url']);
            } else {
                throw new \Exception(
                    '$GLOBALS[\'TYPO3_CONF_VARS\'][\'EXTCONF\'][\'m2t3_sso\'][\'SSO\'][\'url\'] are not set',
                    1476902193
                );
            }

            if (!empty($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['m2t3_sso']['SSO']['cookieName'])) {
                $this->setCookieName($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['m2t3_sso']['SSO']['cookieName']);
            } else {
                throw new \Exception(
                    '$GLOBALS[\'TYPO3_CONF_VARS\'][\'EXTCONF\'][\'m2t3_sso\'][\'SSO\'][\'cookieName\'] are not set',
                    1476902230
                );
            }

        } else {
            throw new \Exception(
                '$GLOBALS[\'TYPO3_CONF_VARS\'][\'EXTCONF\'][\'m2t3_sso\'][\'SSO\'] are not set',
                1476902114
            );
        }
    }

    /**
     * getUser
     *
     * @return array
     *
     */
    public function getUser() :array
    {
        if ($this->cookieExists()) {
            $result = GeneralUtility::getUrl($this->getUrl(), 0, ['Cookie' => $this->getCookieValue()]);
            $userData = json_decode($result, true);
            $user = $this->validateUser($userData);
        }

        return $user ?? [];
    }

    /**
     * cookieExists
     *
     * @return bool
     */
    public function cookieExists() :bool
    {
        return !empty($_COOKIE[$this->getCookieName()]);
    }

    /**
     * @return string
     */
    public function getCookieName() :string
    {
        return $this->cookieName;
    }

    /**
     * @param string $cookieName
     */
    public function setCookieName(string $cookieName)
    {
        $this->cookieName = $cookieName;
    }

    /**
     * @return string
     */
    public function getUrl() :string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * getCookieValue
     *
     * @return string
     */
    public function getCookieValue() :string
    {
        $cookieValue = '';
        if ($this->cookieExists()) {
            $cookieValue = $this->getCookieName().'='.$_COOKIE[$this->getCookieName()];
        }

        return $cookieValue;
    }

    /**
     * validateUser
     *
     * @param array $user
     * @return array
     */
    protected function validateUser(array $user) :array
    {
        $defaults = [
            'tx_extbase_type'     => 'Tx_Extbase_Domain_Model_FrontendUser',
            'felogin_redirectPid' => '',
            'felogin_forgotHash'  => '',
            'usergroup'           => 1,
            'pid'                 => 3,
            'tstamp'              => 1476469465,
            'password'            => md5(''),
            'cruser_id'           => 3,
            'lockToDomain'        => '',
            'deleted'             => 0,
            'TSconfig'            => ''
        ];
        if ($user) {
            return array_merge($user, $defaults);
        }

        return [];
    }
}
