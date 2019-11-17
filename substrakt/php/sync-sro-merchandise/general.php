<?php

namespace Substrakt\Products\Sync;

/**
 * Takes all the products that contain a remote ID.
 * @return array
 */
function productsWithRemoteIds(): array
{
    global $wpdb;

    $postmeta   = $wpdb->postmeta;
    $postsTable = $wpdb->posts;

    $results = $wpdb->get_results("
        SELECT $postsTable.*, meta_value AS remote_id
        FROM $postmeta
        LEFT JOIN $postsTable
        ON $postsTable.ID=$postmeta.post_id
        WHERE $postmeta.meta_key='product_remote_id'
        AND trim(meta_value) <> ''
        AND $postsTable.post_type='product'
    ", 'ARRAY_A');

    return array_column($results, 'ID', 'remote_id');
}

/**
 * Makes a get request to SRO in order to take the merchandise.
 * https://tickets.londoncoliseum.org/feed/merchandises?json
 * @return array
 */
function SROFeedProducts(): array
{
    $client = new \GuzzleHttp\Client([
        'base_uri' => 'https://tickets.londoncoliseum.org/feed/',
        'timeout'  => 30.0,
    ]);

    try {
        $response = json_decode(
            $client->request('GET', 'merchandises', [
                'query' => [
                    'json' => 'true',
                ]
            ])->getBody()->getContents()
        );

        return $response->feed->Merchandises->Merchandise ?? [];

    } catch (\Exception $e) {
        return [];
    }
}

/**
 *  Receives an array with data of the product to sync and includes/ updates it in the site database.
 * @param array $productParams
 * @return boolean
 */
function updateProduct(array $productParams): bool
{
    $logger = new \Monolog\Logger('logger');

    if (!empty($productParams)) {
        $logger->info('Updating product', [
            $productParams->remote_id,
            $productParams->post_title,
        ]);

        return boolval(wp_insert_post($productParams));
    }

    return false;
}
