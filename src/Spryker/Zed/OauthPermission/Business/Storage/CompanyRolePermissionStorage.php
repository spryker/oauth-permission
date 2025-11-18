<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\OauthPermission\Business\Storage;

use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\OauthPermissionStorageKeyTransfer;
use Spryker\Shared\OauthPermission\KeyBuilder\OauthPermissionKeyBuilderInterface;
use Spryker\Zed\OauthPermission\Dependency\Client\OauthPermissionToStorageRedisClientInterface;
use Spryker\Zed\OauthPermission\Dependency\Facade\OauthPermissionToPermissionFacadeInterface;
use Spryker\Zed\OauthPermission\Dependency\Service\OauthPermissionToUtilEncodingServiceInterface;

class CompanyRolePermissionStorage implements CompanyRolePermissionStorageInterface
{
    public function __construct(
        protected OauthPermissionToStorageRedisClientInterface $storageRedisClient,
        protected OauthPermissionKeyBuilderInterface $keyBuilder,
        protected OauthPermissionToPermissionFacadeInterface $permissionFacade,
        protected OauthPermissionToUtilEncodingServiceInterface $utilEncodingService
    ) {
    }

    public function storePermissions(CompanyRoleTransfer $companyRoleTransfer): void
    {
        $data = [];
        foreach ($companyRoleTransfer->getCompanyUserCollection()->getCompanyUsers() as $companyUserTransfer) {
            $data = $this->storeByCompanyUser($companyUserTransfer, $data);
        }

        if ($data) {
            $this->storageRedisClient->setMulti($data);
        }
    }

    public function storePermissionsByCompanyUser(CompanyUserTransfer $companyUserTransfer): void
    {
        $data = [];
        $data = $this->storeByCompanyUser($companyUserTransfer, $data);

        if ($data) {
            $this->storageRedisClient->setMulti($data);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param array<string, string> $data
     *
     * @return array<string, string>
     */
    protected function storeByCompanyUser(CompanyUserTransfer $companyUserTransfer, array $data): array
    {
        $permissionCollectionTransfer = $this->permissionFacade->getPermissionsByIdentifier((string)$companyUserTransfer->getIdCompanyUser());
        $oauthPermissionStorageKeyTransfer = (new OauthPermissionStorageKeyTransfer())->setIdCompanyUser((string)$companyUserTransfer->getIdCompanyUser());
        $key = $this->keyBuilder->generateKey($oauthPermissionStorageKeyTransfer);
        $data[$key] = $this->utilEncodingService->encodeJson($permissionCollectionTransfer->toArray());

        return $data;
    }
}
