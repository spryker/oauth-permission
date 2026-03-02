<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\OauthPermission\Business\Storage;

use Generated\Shared\Transfer\CompanyUserIdentifierTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

interface CompanyUserPermissionsStorageInterface
{
    public function storePermissions(
        CompanyUserIdentifierTransfer $companyUserIdentifierTransfer,
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserIdentifierTransfer;
}
