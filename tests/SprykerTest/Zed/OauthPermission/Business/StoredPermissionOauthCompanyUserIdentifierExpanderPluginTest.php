<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\OauthPermission\Business;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyUserIdentifierTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\OauthPermissionStorageKeyTransfer;
use Spryker\Shared\OauthPermission\KeyBuilder\OauthPermissionKeyBuilder;
use Spryker\Shared\PermissionExtension\Dependency\Plugin\PermissionPluginInterface;
use Spryker\Zed\CompanyRole\Communication\Plugin\PermissionStoragePlugin;
use Spryker\Zed\OauthPermission\Business\OauthPermissionBusinessFactory;
use Spryker\Zed\OauthPermission\Communication\Plugin\OauthCompanyUser\StoredPermissionOauthCompanyUserIdentifierExpanderPlugin;
use Spryker\Zed\OauthPermission\Dependency\Client\OauthPermissionToStorageRedisClientInterface;
use Spryker\Zed\OauthPermission\OauthPermissionDependencyProvider;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group OauthPermission
 * @group Business
 * @group StoredPermissionOauthCompanyUserIdentifierExpanderPluginTest
 * Add your own group annotations below this line
 */
class StoredPermissionOauthCompanyUserIdentifierExpanderPluginTest extends Unit
{
    /**
     * @var string
     */
    protected const PERMISSION_PLUGIN_KEY = 'TestStoredPermissionPlugin';

    /**
     * @var \SprykerTest\Zed\OauthPermission\OauthPermissionBusinessTester
     */
    protected $tester;

    /**
     * @var array<string, string>
     */
    protected array $storedValues = [];

    public function testExpandCompanyUserIdentifierStoresRolePermissionsOfCompanyUserUnderItsUuidKey(): void
    {
        // Arrange
        $this->tester->preparePermissionStorageDependency(new PermissionStoragePlugin());
        $this->tester->setDependency(OauthPermissionDependencyProvider::CLIENT_STORAGE_REDIS, $this->createStorageRedisClientSpy(), OauthPermissionBusinessFactory::class);
        $companyUserTransfer = $this->tester->haveCompanyUserWithPermissions($this->createPermissionPluginMock());

        // Act
        $this->createPlugin()->expandCompanyUserIdentifier($this->createCompanyUserIdentifierTransfer($companyUserTransfer), $companyUserTransfer);

        // Assert
        $storageKey = $this->generateStorageKey($companyUserTransfer->getUuidOrFail());
        $this->assertArrayHasKey($storageKey, $this->storedValues);
        $this->assertSame([static::PERMISSION_PLUGIN_KEY], array_column(json_decode($this->storedValues[$storageKey], true)['permissions'], 'key'));
    }

    protected function createPlugin(): StoredPermissionOauthCompanyUserIdentifierExpanderPlugin
    {
        $plugin = new StoredPermissionOauthCompanyUserIdentifierExpanderPlugin();
        $plugin->setBusinessFactory($this->tester->getFactory());

        return $plugin;
    }

    protected function createCompanyUserIdentifierTransfer(CompanyUserTransfer $companyUserTransfer): CompanyUserIdentifierTransfer
    {
        return (new CompanyUserIdentifierTransfer())
            ->setIdCustomer($companyUserTransfer->getCustomerOrFail()->getIdCustomer())
            ->setCustomerReference($companyUserTransfer->getCustomerOrFail()->getCustomerReference())
            ->setIdCompanyUser($companyUserTransfer->getUuidOrFail());
    }

    protected function generateStorageKey(string $companyUserUuid): string
    {
        return (new OauthPermissionKeyBuilder())->generateKey(
            (new OauthPermissionStorageKeyTransfer())->setIdCompanyUser($companyUserUuid),
        );
    }

    protected function createStorageRedisClientSpy(): OauthPermissionToStorageRedisClientInterface
    {
        $storageRedisClientMock = $this->createMock(OauthPermissionToStorageRedisClientInterface::class);
        $storageRedisClientMock->method('set')
            ->willReturnCallback(function (string $key, string $value): bool {
                $this->storedValues[$key] = $value;

                return true;
            });

        return $storageRedisClientMock;
    }

    protected function createPermissionPluginMock(): PermissionPluginInterface
    {
        $permissionPluginMock = $this->createMock(PermissionPluginInterface::class);
        $permissionPluginMock->method('getKey')->willReturn(static::PERMISSION_PLUGIN_KEY);

        return $permissionPluginMock;
    }
}
