<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\OauthPermission\Business\Expander;

use Generated\Shared\Transfer\CompanyUserIdentifierTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

/**
 * @deprecated Use {@link \Spryker\Zed\OauthPermission\Business\Storage\CompanyUserPermissionsStorageInterface} instead.
 */
interface CompanyUserIdentifierExpanderInterface
{
    public function expandCompanyUserIdentifier(
        CompanyUserIdentifierTransfer $companyUserIdentifierTransfer,
        CompanyUserTransfer $companyUserTransfer
    ): CompanyUserIdentifierTransfer;
}
