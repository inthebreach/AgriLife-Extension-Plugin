<?php
namespace AgriLife\Extension;

use \AgriLife\Core\Plugin\PluginBase;
use \AgriLife\Core\PostType\PostTypeFactory;
use \AgriLife\Core\Parser\PostTypeLabelParser;
use \AgriLife\Core\Parser\PostTypeArgParser;
use \AgriLife\Core\Taxonomy\TaxonomyFactory;
use \AgriLife\Core\Parser\TaxonomyLabelParser;
use \AgriLife\Core\Parser\TaxonomyArgParser;

/**
 * Initializes the plugin functionality
 * @package AgriLife-Extension
 * @since 1.0.0
 */
class Init extends PluginBase {

	protected function __construct() {}

	public function init() {

		$this->plugin_slug = 'agrilife-extension';

	}

}