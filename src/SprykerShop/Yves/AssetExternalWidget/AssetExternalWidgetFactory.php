<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\AssetExternalWidget;

use Spryker\Yves\Kernel\AbstractFactory;
use SprykerShop\Yves\AssetExternalWidget\Business\AssetExternalWidgetDataProvider;
use SprykerShop\Yves\AssetExternalWidget\Business\AssetExternalWidgetDataProviderInterface;
use SprykerShop\Yves\AssetExternalWidget\Dependency\Client\AssetExternalWidgetToAssetExternalStorageClientInterface;
use SprykerShop\Yves\AssetExternalWidget\Dependency\Client\AssetExternalWidgetToStoreClientInterface;

/**
 * @method \SprykerShop\Yves\AssetExternalWidget\AssetExternalWidgetConfig getConfig()
 */
class AssetExternalWidgetFactory extends AbstractFactory
{
    /**
     * @return \SprykerShop\Yves\AssetExternalWidget\Business\AssetExternalWidgetDataProviderInterface
     */
    public function createAssetExternalWidgetDataProvider(): AssetExternalWidgetDataProviderInterface
    {
        return new AssetExternalWidgetDataProvider(
            $this->getAssetExternalStorageClient(),
            $this->getStoreClient(),
        );
    }

    /**
     * @return \SprykerShop\Yves\AssetExternalWidget\Dependency\Client\AssetExternalWidgetToAssetExternalStorageClientInterface
     */
    public function getAssetExternalStorageClient(): AssetExternalWidgetToAssetExternalStorageClientInterface
    {
        return $this->getProvidedDependency(AssetExternalWidgetDependencyProvider::CLIENT_ASSET_EXTERNAL_STORAGE);
    }

    /**
     * @return \SprykerShop\Yves\AssetExternalWidget\Dependency\Client\AssetExternalWidgetToStoreClientInterface
     */
    public function getStoreClient(): AssetExternalWidgetToStoreClientInterface
    {
        return $this->getProvidedDependency(AssetExternalWidgetDependencyProvider::CLIENT_STORE);
    }
}
