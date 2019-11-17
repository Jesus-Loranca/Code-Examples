<?php
/* http://patorjk.com/software/taag/#p=display&f=Slant&t=Callstrakt

   ______      ____     __             __   __
  / ____/___ _/ / /____/ /__________ _/ /__/ /_
 / /   / __ `/ / / ___/ __/ ___/ __ `/ //_/ __/
/ /___/ /_/ / / (__  ) /_/ /  / /_/ / ,< / /_
\____/\__,_/_/_/____/\__/_/   \__,_/_/|_|\__/


Plugin Name: Callstrakt
Plugin URI:  http://substrakt.com/callstrakt
Description: Call to Action, Image, Text, Button
Version:     1.1.6
Author:      Substrakt
Author URI:  http://substrakt.com
Domain Path: /languages
Text Domain: callstrakt
*/

define('CALLSTRAKT_PATH', __DIR__ . '/');
define('CALLSTRAKT_URL',  plugins_url() . '/callstrakt/');

if (file_exists(CALLSTRAKT_PATH . 'vendor/autoload.php')) {
    require CALLSTRAKT_PATH . 'vendor/autoload.php';
}

require CALLSTRAKT_PATH . 'acf/content.php';
require CALLSTRAKT_PATH . 'acf/display.php';

require CALLSTRAKT_PATH . 'helpers/utilities.php';

require CALLSTRAKT_PATH . 'hooks/actions.php';
require CALLSTRAKT_PATH . 'hooks/enqueues.php';

require CALLSTRAKT_PATH . 'models/Callstrakt.php';
require CALLSTRAKT_PATH . 'models/CallToAction.php';

require CALLSTRAKT_PATH . 'post-types/call-to-action.php';

require CALLSTRAKT_PATH . 'taxonomies/display-option.php';
