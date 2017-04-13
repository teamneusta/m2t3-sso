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

use Prophecy\Prophecy\ObjectProphecy;
use TeamNeustaGmbH\M2T3\Sso\Service\AuthenticationService;
use TeamNeustaGmbH\M2T3\Sso\Service\MagentoService;

class AuthenticationServiceTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

    /**
     * authenticationService
     *
     * @var AuthenticationService
     */
    protected $authenticationService;

    /**
     * magentoService
     *
     * @var MagentoService | ObjectProphecy
     */
    protected $magentoService;

    /**
     * userFixture
     *
     * @var array
     */
    protected $userFixture = [];

    public function setUp()
    {
        $this->setUserFixture();
        $this->authenticationService = new AuthenticationService();
        $this->magentoService = $this->prophesize(MagentoService::class);
        $this->authenticationService->injectMagentoService($this->magentoService->reveal());
        parent::setUp();
    }

    protected function setUserFixture()
    {
        $this->userFixture = [
            'tx_extbase_type'     => 'Tx_Extbase_Domain_Model_FrontendUser',
            'felogin_redirectPid' => '',
            'felogin_forgotHash'  => '',
            'uid'                 => 2,
            'pid'                 => 3,
            'tstamp'              => 1476469465,
            'username'            => 'peter',
            'password'            => md5(''),
            'usergroup'           => '1',
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
            'cruser_id'           => 3,
            'lockToDomain'        => '',
            'deleted'             => 0,
            'uc'                  => '',
            'title'               => '',
            'zip'                 => '',
            'city'                => '',
            'country'             => '',
            'www'                 => '',
            'company'             => '',
            'image'               => 0,
            'TSconfig'            => '',
            'lastlogin'           => 1476471194,
            'is_online'           => 1476471147
        ];
    }

    public function autUserShouldReturnStatusCodeDataProvider() :array
    {
        $this->setUserFixture();

        return [
            'empty user authentication failed' => [
                'user'     => [],
                'expected' => 0
            ],
            'user authentication success'      => [
                'user'     => $this->userFixture,
                'expected' => 200
            ]
        ];
    }

    /**
     * autUserShouldReturnStatusCode
     *
     * @test
     * @dataProvider autUserShouldReturnStatusCodeDataProvider
     * @param array $user
     * @param int $expected
     */
    public function autUserShouldReturnStatusCode(array $user, int $expected)
    {
        $this->magentoService->getUser()->shouldBeCalled()->willReturn($user);
        $this->assertEquals($expected, $this->authenticationService->authUser($user));
    }

    /**
     * getUserShouldBeCallingMagentoService
     *
     * @test
     * @return void
     */
    public function getUserShouldBeCallingMagentoService()
    {
        $this->magentoService->getUser()->shouldBeCalled()->willReturn($this->userFixture);
        $this->assertSame($this->userFixture, $this->authenticationService->getUser());
    }
}
