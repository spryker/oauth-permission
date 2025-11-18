<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\OauthPermission\Communication\Plugin\CompanyUser;

use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Spryker\Zed\CompanyUserExtension\Dependency\Plugin\CompanyUserPostUpdatePluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Spryker\Zed\OauthPermission\Business\OauthPermissionFacadeInterface getFacade()
 * @method \Spryker\Zed\OauthPermission\OauthPermissionConfig getConfig()
 * @method \Spryker\Zed\OauthPermission\Communication\OauthPermissionCommunicationFactory getFactory()
 * @method \Spryker\Zed\OauthPermission\Business\OauthPermissionBusinessFactory getBusinessFactory()
 */
class OauthPermissionCompanyUserPostUpdatePlugin extends AbstractPlugin implements CompanyUserPostUpdatePluginInterface
{
    /**
     * {@inheritDoc}
     * - Invalidates customers associated with the given company user after it is saved.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyUserResponseTransfer $companyUserResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function postUpdate(CompanyUserResponseTransfer $companyUserResponseTransfer): CompanyUserResponseTransfer
    {
        $this->getBusinessFactory()->createCompanyRolePermissionStorage()->storePermissionsByCompanyUser($companyUserResponseTransfer->getCompanyUser());

        return $companyUserResponseTransfer;
    }
}
