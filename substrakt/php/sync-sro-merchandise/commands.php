<?php

namespace Substrakt\Products\Sync;

/**
 * Runs all the needed to sync products from SRO.
 * They are being taken from the feed: https://tickets.londoncoliseum.org/feed/merchandises?json
 * @return boolean
 */
function products(): bool
{
    do_action("substrakt\products\sync\start");

    // Get all the products from the SRO feed.
    $SROFeedProducts = SROFeedProducts();

    // Get all the products that have a remote ID in an array structured ['remote_id' => 'id']
    $productsWithRemoteIds = productsWithRemoteIds();

    foreach ($SROFeedProducts as $SROFeedProduct) {
        // Prepare all the products to have a wordpress ID if they exist on the DB
        // so they are updated rather than creating a new product.
        $params = [
            'post_title' => $SROFeedProduct->Name,
            'post_type' => 'product',
            'meta_input' => [
                'product_remote_id' => $SROFeedProduct->Id ?? '',
                'sro_link'          => $SROFeedProduct->DirectLink ?? '',
                'description'       => $SROFeedProduct->Description ?? '',
            ],
        ];

        if (isset($productsWithRemoteIds[$SROFeedProduct->Id])) {
            $params['ID'] = $productsWithRemoteIds[$SROFeedProduct->Id];
        }

        updateProduct($params);
    }

    do_action("substrakt\products\sync\\end");

    return true;
}
