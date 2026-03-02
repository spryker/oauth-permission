<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\OauthPermission\Dependency\Client;

interface OauthPermissionToStorageRedisClientInterface
{
    public function set(string $key, string $value, ?int $ttl = null): bool;

    public function setMulti(array $items): void;
}
