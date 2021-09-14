<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\AssetExternalWidget\Business;

use Generated\Shared\Transfer\AssetExternalStorageCriteriaTransfer;
use Generated\Shared\Transfer\CmsSlotContentRequestTransfer;
use Generated\Shared\Transfer\CmsSlotContentResponseTransfer;
use SprykerShop\Yves\AssetExternalWidget\Dependency\Client\AssetExternalWidgetToAssetExternalStorageClientInterface;
use SprykerShop\Yves\AssetExternalWidget\Dependency\Client\AssetExternalWidgetToStoreClientInterface;

class AssetExternalWidgetDataProvider implements AssetExternalWidgetDataProviderInterface
{
    /**
     * @var string
     */
    protected static $currentStoreName;

    /**
     * @var \SprykerShop\Yves\AssetExternalWidget\Dependency\Client\AssetExternalWidgetToAssetExternalStorageClientInterface
     */
    protected $assetExternalStorageClient;

    /**
     * @var \SprykerShop\Yves\AssetExternalWidget\Dependency\Client\AssetExternalWidgetToStoreClientInterface
     */
    protected $storeClient;

    /**
     * @param \SprykerShop\Yves\AssetExternalWidget\Dependency\Client\AssetExternalWidgetToAssetExternalStorageClientInterface $assetExternalStorageClient
     * @param \SprykerShop\Yves\AssetExternalWidget\Dependency\Client\AssetExternalWidgetToStoreClientInterface $storeClient
     */
    public function __construct(
        AssetExternalWidgetToAssetExternalStorageClientInterface $assetExternalStorageClient,
        AssetExternalWidgetToStoreClientInterface $storeClient
    ) {
        $this->assetExternalStorageClient = $assetExternalStorageClient;
        $this->storeClient = $storeClient;
    }

    /**
     * @param \Generated\Shared\Transfer\CmsSlotContentRequestTransfer $cmsSlotContentRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CmsSlotContentResponseTransfer
     */
    public function getSlotContent(CmsSlotContentRequestTransfer $cmsSlotContentRequestTransfer): CmsSlotContentResponseTransfer
    {
        $assetExternalStorageCriteriaTransfer = (new AssetExternalStorageCriteriaTransfer())
            ->setSlotKey($cmsSlotContentRequestTransfer->getCmsSlotKey())
            ->setStoreName($this->getCurrentStoreName());

        $assetExternalStorageCollectionTransfer = $this->assetExternalStorageClient
            ->getAssetExternalCollection($assetExternalStorageCriteriaTransfer);

        $content = '';
        foreach ($assetExternalStorageCollectionTransfer->getAssetsExternalStorage() as $assetExternalStorageTransfer) {
            $content .= $assetExternalStorageTransfer->getAssetContent();
        }

        return (new CmsSlotContentResponseTransfer())
            ->setContent($content);
    }

    /**
     * @return string
     */
    protected function getCurrentStoreName(): string
    {
        if (!static::$currentStoreName) {
            static::$currentStoreName = $this->storeClient->getCurrentStore()->getNameOrFail();
        }

        return static::$currentStoreName;
    }
}
