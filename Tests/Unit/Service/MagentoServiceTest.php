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

namespace TeamNeustaGmbH\M2T3\Sso\Tests\Unit\Service;

use TeamNeustaGmbH\M2T3\Sso\Service\MagentoService;

class MagentoServiceTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * magentoService
     *
     * @var MagentoService
     */
    protected $magentoService;

    /**
     * initConfigurationShouldThrowExceptionIfConfigNotExist
     *
     * @test
     * @return void
     */
    public function initConfigurationShouldThrowExceptionIfConfigNotExist()
    {
        unset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['m2t3_sso']['SSO']);
        $this->expectException(\Exception::class);
        $this->expectExceptionCode(1476902114);
        $this->expectExceptionMessage(
            '$GLOBALS[\'TYPO3_CONF_VARS\'][\'EXTCONF\'][\'m2t3_sso\'][\'SSO\'] are not set'
        );
        new MagentoService();
    }

    /**
     * initConfigurationShouldThrowExceptionIfUrlIsNotConfiguredInConfig
     *
     * @test
     * @return void
     */
    public function initConfigurationShouldThrowExceptionIfUrlIsNotConfiguredInConfig()
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['m2t3_sso']['SSO'] = [
            'foo'
        ];
        $this->expectException(\Exception::class);
        $this->expectExceptionCode(1476902193);
        $this->expectExceptionMessage(
            '$GLOBALS[\'TYPO3_CONF_VARS\'][\'EXTCONF\'][\'m2t3_sso\'][\'SSO\'][\'url\'] are not set'
        );
        new MagentoService();
    }

    /**
     * initConfigurationShouldThrowExceptionIfUrlAreSetButCookieNameIsNotConfiguredInConfig
     *
     * @test
     * @return void
     */
    public function initConfigurationShouldThrowExceptionIfUrlAreSetButCookieNameIsNotConfiguredInConfig()
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['m2t3_sso']['SSO'] = [
            'url' => 'asdf'
        ];
        $this->expectException(\Exception::class);
        $this->expectExceptionCode(1476902230);
        $this->expectExceptionMessage(
            '$GLOBALS[\'TYPO3_CONF_VARS\'][\'EXTCONF\'][\'m2t3_sso\'][\'SSO\'][\'cookieName\'] are not set'
        );
        new MagentoService();
    }

    /**
     * getUserShouldReturnEmptyArrayIfCookieAreNotSet
     *
     * @test
     * @return void
     */
    public function getUserShouldReturnEmptyArrayIfCookieAreNotSet()
    {
        $this->assertSame([], $this->magentoService->getUser());
    }

    /**
     * getUserShouldReturnUserDataIfCookieExist
     *
     * @test
     * @return void
     */
    public function getUserShouldReturnUserDataIfCookieExist()
    {
        $_COOKIE['magentoFrontend'] = 'value';
        $this->assertSame(
            [
                'uid'                 => 1,
                'username'            => 'peter',
                'usergroup'           => 1,
                'disable'             => 0,
                'starttime'           => 0,
                'endtime'             => 0,
                'name'                => '',
                'first_name'          => '',
                'middle_name'         => '',
                'last_name'           => '',
                'address'             => '',
                'telephone'           => '',
                'fax'                 => '',
                'email'               => '',
                'crdate'              => 1476469465,
                'uc'                  => '',
                'title'               => '',
                'zip'                 => '',
                'city'                => '',
                'country'             => '',
                'www'                 => '',
                'company'             => '',
                'image'               => 0,
                'lastlogin'           => 1476471194,
                'is_online'           => 1476471147,
                'tx_extbase_type'     => 'Tx_Extbase_Domain_Model_FrontendUser',
                'felogin_redirectPid' => '',
                'felogin_forgotHash'  => '',
                'pid'                 => 3,
                'tstamp'              => 1476469465,
                'password'            => 'd41d8cd98f00b204e9800998ecf8427e',
                'cruser_id'           => 3,
                'lockToDomain'        => '',
                'deleted'             => 0,
                'TSconfig'            => '',
            ],
            $this->magentoService->getUser()
        );
    }

    /**
     * setUp
     *
     * @return void
     */
    protected function setUp()
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['m2t3_sso']['SSO'] = [
            'url'        => __DIR__.'/../../Fixture/userExample.json',
            'cookieName' => 'magentoFrontend'
        ];
        $this->magentoService = new MagentoService();
    }
}
