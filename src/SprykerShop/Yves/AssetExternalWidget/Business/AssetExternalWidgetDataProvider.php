<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\AssetExternalWidget\Business;

use Generated\Shared\Transfer\AssetExternalStorageCollectionCriteriaTransfer;
use Generated\Shared\Transfer\CmsSlotContentRequestTransfer;
use Generated\Shared\Transfer\CmsSlotContentResponseTransfer;
use SprykerShop\Yves\AssetExternalWidget\Dependency\Client\AssetExternalWidgetToAssetExternalStorageClientInterface;
use SprykerShop\Yves\AssetExternalWidget\Dependency\Client\AssetExternalWidgetToStoreClientInterface;

class AssetExternalWidgetDataProvider implements AssetExternalWidgetDataProviderInterface
{
    /**
     * @var \SprykerShop\Yves\AssetExternalWidget\Dependency\Client\AssetExternalWidgetToAssetExternalStorageClientInterface
     */
    private $assetExternalStorageClient;

    /**
     * @var \SprykerShop\Yves\AssetExternalWidget\Dependency\Client\AssetExternalWidgetToStoreClientInterface
     */
    private $storeClient;

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
        $assetExternalStorageCollectionCriteriaTransfer = (new AssetExternalStorageCollectionCriteriaTransfer())
            ->setSlotKey($cmsSlotContentRequestTransfer->getCmsSlotKey())
            ->setStoreName($this->storeClient->getCurrentStore()->getName());

        $assetExternalStorageCollectionTransfer = $this->assetExternalStorageClient
            ->getAssetExternalCollectionForCmsSlot($assetExternalStorageCollectionCriteriaTransfer);

        $content = '';
        foreach ($assetExternalStorageCollectionTransfer->getAssetsExternalStorage() as $assetExternalStorageTransfer) {
            $content .= $assetExternalStorageTransfer->getAssetContent();
        }

        return (new CmsSlotContentResponseTransfer())
            ->setContent($content);
    }
}