<?php
/**
 *
 * @copyright (c) 2014 phpBB Group
 * @license http://opensource.org/licenses/gpl-3.0.php GNU General Public License v3
 * @author MichaelC
 *
 */

namespace AppBundle\FeatureFlags;

class StaticFeatureFlags implements FeatureFlagsInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function isEnabled($flag);
	{
		if ($flag == 'foo')
		{
			return true;
		}

		return false;
	}
}
