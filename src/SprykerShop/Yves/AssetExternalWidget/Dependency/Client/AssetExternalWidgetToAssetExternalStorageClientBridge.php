<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\AssetExternalWidget\Dependency\Client;

use Generated\Shared\Transfer\AssetExternalStorageCriteriaTransfer;
use Generated\Shared\Transfer\AssetExternalStorageCollectionTransfer;

class AssetExternalWidgetToAssetExternalStorageClientBridge implements AssetExternalWidgetToAssetExternalStorageClientInterface
{
    /**
     * @var \Spryker\Client\AssetExternalStorage\AssetExternalStorageClientInterface
     */
    private $assetExternalStorageClient;

    /**
     * @param \Spryker\Client\AssetExternalStorage\AssetExternalStorageClientInterface $assetExternalStorageClient
     */
    public function __construct($assetExternalStorageClient)
    {
        $this->assetExternalStorageClient = $assetExternalStorageClient;
    }

    /**
     * @param \Generated\Shared\Transfer\AssetExternalStorageCriteriaTransfer $assetExternalStorageCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\AssetExternalStorageCollectionTransfer
     */
    public function getAssetExternalCollection(
        AssetExternalStorageCriteriaTransfer $assetExternalStorageCriteriaTransfer
    ): AssetExternalStorageCollectionTransfer {
        return $this->assetExternalStorageClient
            ->getAssetExternalCollection($assetExternalStorageCriteriaTransfer);
    }
}
