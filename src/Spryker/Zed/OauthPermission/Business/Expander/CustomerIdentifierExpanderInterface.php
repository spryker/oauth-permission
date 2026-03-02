<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\OauthPermission\Business\Expander;

use Generated\Shared\Transfer\CustomerIdentifierTransfer;
use Generated\Shared\Transfer\CustomerTransfer;

/**
 * @deprecated Use {@link \Spryker\Zed\OauthPermission\Business\Storage\CustomerIdentifierPermissionsStorageInterface} instead.
 */
interface CustomerIdentifierExpanderInterface
{
    public function expandCustomerIdentifierWithPermissions(
        CustomerIdentifierTransfer $customerIdentifierTransfer,
        CustomerTransfer $customerTransfer
    ): CustomerIdentifierTransfer;
}
