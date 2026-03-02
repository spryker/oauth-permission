<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\OauthPermission\Business\Storage;

use Generated\Shared\Transfer\CustomerIdentifierTransfer;
use Generated\Shared\Transfer\CustomerTransfer;

interface CustomerIdentifierPermissionsStorageInterface
{
    public function storePermissions(
        CustomerIdentifierTransfer $customerIdentifierTransfer,
        CustomerTransfer $customerTransfer
    ): CustomerIdentifierTransfer;
}
