<?php

namespace Substrakt\Callstrakt;

use \Substrakt\Platypus\NullObject;

class Callstrakt
extends \Substrakt\Platypus\Post
{
   /**
    * Returns the call to action object used on the page.
    * @return object
    */
    public function callToAction(): object
    {
        if ($callToAction = $this->get('picker')) {
            return $callToAction;
        }

        return new NullObject;
    }

   /**
    * Returns a md5 hash of string composed by the permalink of the page, the page ID and the callToAction ID.
    * @return string
    */
    public function dataID(): string
    {
        return md5("callstrakt-{$this->permalink()}-{$this->ID()}-{$this->callToAction()->ID}");
    }

   /**
    * Returns a boolean to know if we display the call to action or not.
    * @return boolean
    */
    public function display(): bool
    {
        return !!$this->get('display');
    }

   /**
    * Returns the slug of the page.
    * Metod thought to be used on the tracking side of the plugin.
    * @return string
    */
    public function slug(): string
    {
        return $this->name;
    }

   /**
    * Returns a field from ACF.
    * @param string $key The ACF field key.
    * @param string $default The default value to be used.
    * @return string | array
    */
    private function get(string $key, string $default = '')
    {
        if (isset($this->wp->ID) && $field = get_field("callstrakt_{$key}", $this->wp->ID)) {
            return $field;
        }

        return $default;
    }
}
