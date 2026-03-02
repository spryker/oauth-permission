<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\OauthPermission\Business\Storage;

use Generated\Shared\Transfer\CompanyUserIdentifierTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\OauthPermissionStorageKeyTransfer;
use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Spryker\Shared\OauthPermission\KeyBuilder\OauthPermissionKeyBuilderInterface;
use Spryker\Zed\OauthPermission\Dependency\Client\OauthPermissionToStorageRedisClientInterface;
use Spryker\Zed\OauthPermission\Dependency\Facade\OauthPermissionToPermissionFacadeInterface;
use Spryker\Zed\OauthPermission\Dependency\Service\OauthPermissionToUtilEncodingServiceInterface;
use Spryker\Zed\OauthPermission\OauthPermissionConfig;

class CompanyUserPermissionsStorage implements CompanyUserPermissionsStorageInterface
{
    public function __construct(
        protected OauthPermissionKeyBuilderInterface $keyBuilder,
        protected OauthPermissionToStorageRedisClientInterface $storageRedisClient,
        protected OauthPermissionToPermissionFacadeInterface $permissionFacade,
        protected OauthPermissionToUtilEncodingServiceInterface $utilEncodingService,
        protected OauthPermissionConfig $permissionConfig
    ) {
    }

    public function storePermissions(
        CompanyUserIdentifierTransfer $companyUserIdentifierTransfer,
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserIdentifierTransfer {
        $permissionCollectionTransfer = $this->findPermissions($companyUserIdentifierTransfer);
        if ($permissionCollectionTransfer === null) {
            return $companyUserIdentifierTransfer;
        }

        $key = $this->generateKey($companyUserIdentifierTransfer);
        $this->storageRedisClient->set(
            $key,
            $this->utilEncodingService->encodeJson($permissionCollectionTransfer->toArray()),
            $this->permissionConfig->getStoredPermissionTTL(),
        );

        return $companyUserIdentifierTransfer;
    }

    protected function findPermissions(CompanyUserIdentifierTransfer $companyUserIdentifierTransfer): ?PermissionCollectionTransfer
    {
        if (!$companyUserIdentifierTransfer->getIdCompanyUser()) {
            return null;
        }

        return $this
            ->permissionFacade
            ->getPermissionsByIdentifier((string)$companyUserIdentifierTransfer->getIdCompanyUser());
    }

    protected function generateKey(CompanyUserIdentifierTransfer $companyUserIdentifierTransfer): string
    {
        $oauthPermissionStorageKeyTransfer = (new OauthPermissionStorageKeyTransfer())
            ->setIdCompanyUser($companyUserIdentifierTransfer->getIdCompanyUser());

        return $this->keyBuilder->generateKey($oauthPermissionStorageKeyTransfer);
    }
}
