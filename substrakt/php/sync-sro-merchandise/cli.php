<?php

namespace Substrakt\Products\Sync\CLI;

use WP_CLI as CLI;

if (class_exists('\WP_CLI')) {
    /**
     * Sync products from SRO.
     */
    CLI::add_command('products sync', function()
    {
        if (\Substrakt\Products\Sync\products()) {
            return CLI::success('Products synced successfully.');
        }

        return CLI::error('Products were unable to be synced successfully.');
    });
}
