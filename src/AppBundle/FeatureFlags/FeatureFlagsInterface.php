<?php
/**
 *
 * @copyright (c) 2014 phpBB Group
 * @license http://opensource.org/licenses/gpl-3.0.php GNU General Public License v3
 * @author MichaelC
 *
 */

namespace AppBundle\FeatureFlags;

interface FeatureFlagsInterface
{
	/**
	 * Checks if the feature flag is enabled on this request
	 *
	 * @param  string  $flag Name of the flag
	 * @return boolean       True when enabled
	 */
	public function isEnabled($flag);
}
