<?php
/**
 * @package    Grav.Common.GPM
 *
 * @copyright  Copyright (C) 2014 - 2016 RocketTheme, LLC. All rights reserved.
 * @license    MIT License; see LICENSE file for details.
 */

namespace Grav\Common\GPM;

use Grav\Common\Grav;
use RocketTheme\Toolbox\File\YamlFile;

class Licenses
{
    protected static $licenses = 'user://data/licenses.yaml';

    /**
     * Returns the license for a Premium package
     *
     * @param $slug
     * @param $license
     *
     * @return boolean
     */
    public static function set($slug, $license)
    {
        $licenses = YamlFile::instance(self::getLicensePath());
        $data = $licenses->content();

        if (!is_string($license)) {
            unset($data['licenses'][$slug]);
        } else {
            $data['licenses'][$slug] = $license;
        }

        $licenses->save($data);
        $licenses->free();

        return true;
    }

    /**
     * Returns the license for a Premium package
     *
     * @param $slug
     *
     * @return string
     */
    public static function get($slug)
    {
        $licenses = YamlFile::instance(self::getLicensePath());
        $data = $licenses->content();
        $licenses->free();

        if (!$slug) {
            return $data['licenses'];
        }

        if (!isset($data['licenses']) || !isset($data['licenses'][$slug])) {
            return '';
        }

        return $data['licenses'][$slug];
    }

    protected static function getLicensePath()
    {
        return Grav::instance()['locator']->findResource(self::$licenses);
    }
}