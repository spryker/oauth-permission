<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\OauthPermission\Communication\Plugin\CompanyRole;

use Generated\Shared\Transfer\CompanyRoleTransfer;
use Spryker\Zed\CompanyRoleExtension\Dependency\Plugin\CompanyRolePostSavePluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Spryker\Zed\OauthPermission\Business\OauthPermissionFacadeInterface getFacade()
 * @method \Spryker\Zed\OauthPermission\OauthPermissionConfig getConfig()
 * @method \Spryker\Zed\OauthPermission\Communication\OauthPermissionCommunicationFactory getFactory()
 * @method \Spryker\Zed\OauthPermission\Business\OauthPermissionBusinessFactory getBusinessFactory()
 */
class OauthPermissionUpdateCompanyRolePostSavePlugin extends AbstractPlugin implements CompanyRolePostSavePluginInterface
{
    /**
     * {@inheritDoc}
     * - Updates permissions in storage for all company users associated with the company role after it is saved.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyRoleTransfer
     */
    public function postSave(CompanyRoleTransfer $companyRoleTransfer): CompanyRoleTransfer
    {
        $this->getBusinessFactory()->createCompanyRolePermissionStorage()->storePermissions($companyRoleTransfer);

        return $companyRoleTransfer;
    }
}
