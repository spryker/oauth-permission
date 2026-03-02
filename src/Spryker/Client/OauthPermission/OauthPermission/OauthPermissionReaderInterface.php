<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\OauthPermission\OauthPermission;

use Generated\Shared\Transfer\PermissionCollectionTransfer;

/**
 * @deprecated Use {@link \Spryker\Client\OauthPermission\OauthPermission\PermissionReaderInterface} instead.
 */
interface OauthPermissionReaderInterface
{
    public function getPermissionsFromOauthToken(): PermissionCollectionTransfer;
}
