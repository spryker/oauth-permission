<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\OauthPermission\Business\Storage;

use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

interface CompanyRolePermissionStorageInterface
{
    public function storePermissions(CompanyRoleTransfer $companyRoleTransfer): void;

    public function storePermissionsByCompanyUser(CompanyUserTransfer $companyUserTransfer): void;
}
