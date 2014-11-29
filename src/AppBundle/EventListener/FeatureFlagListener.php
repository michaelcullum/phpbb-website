<?php
/**
 *
 * @copyright (c) 2014 phpBB Group
 * @license http://opensource.org/licenses/gpl-3.0.php GNU General Public License v3
 * @author MichaelC
 *
 */

namespace AppBundle\EventListener;

class FeatureFlagListener
{
	protected $features;

	function __construct(\AppBundle\FeatureFlags\FeatureFlagsInterface $features)
	{
		$this->features = $features;
	}

	public function onKernelRequest($event)
	{
		$request = $event->getRequest();
		$flag = $request->attributes->get('_feature_flag') ?: '';
		$whenFlag = $request->attributes->get('_when_flag') ?: '';
		$alternativeFlag = $request->attributes->get('_alternative_controller') ?: '';

		if(!$this->features->isEnabled($flag))
		{
			throw new NotFoundHttpException();
		}

		if($this->features->isEnabled($whenFlag) && $alternativeFlag != '')
		{
			$request->attributes->set('_controller', $alternativeFlag);
		}
	}
}
