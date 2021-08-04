<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\AssetExternalWidget;

use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;
use SprykerShop\Yves\AssetExternalWidget\Dependency\Client\AssetExternalWidgetToAssetExternalStorageClientBridge;
use SprykerShop\Yves\AssetExternalWidget\Dependency\Client\AssetExternalWidgetToStoreClientBridge;

class AssetExternalWidgetDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CLIENT_ASSET_EXTERNAL_STORAGE = 'CLIENT_ASSET_EXTERNAL_STORAGE';
    public const CLIENT_STORE = 'CLIENT_STORE';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = $this->addAssetExternalStorageClient($container);
        $container = $this->addStoreClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addAssetExternalStorageClient(Container $container): Container
    {
        $container->set(static::CLIENT_ASSET_EXTERNAL_STORAGE, function (Container $container) {
            return new AssetExternalWidgetToAssetExternalStorageClientBridge(
                $container->getLocator()->assetExternalStorage()->client()
            );
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addStoreClient(Container $container): Container
    {
        $container->set(static::CLIENT_STORE, function (Container $container) {
            return new AssetExternalWidgetToStoreClientBridge(
                $container->getLocator()->store()->client()
            );
        });

        return $container;
    }
}
