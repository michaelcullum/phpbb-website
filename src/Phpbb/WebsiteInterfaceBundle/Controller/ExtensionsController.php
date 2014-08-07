<?php
/**
 *
 * @package       PhpbbWebsiteInterfaceBundle
 * @copyright (c) 2013 phpBB Group
 * @license       http://opensource.org/licenses/gpl-3.0.php GNU General Public License v3
 * @author        MichaelC
 *
 */

namespace Phpbb\WebsiteInterfaceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// Controller for Extensions pages
class ExtensionsController extends Controller
{
	public function homeAction()
	{
		// Extensions Homepage
		$templateVariables = array(
			'header_css_image' => 'mods',
		);

		return $this->render('PhpbbWebsiteInterfaceBundle:Extensions:home.html.twig', $templateVariables);
	}

	public function devRulesAction()
	{
		// Extensions Rules and Guidelines
		$templateVariables = array(
			'header_css_image' => 'mods',
		);

		return $this->render('PhpbbWebsiteInterfaceBundle:Extensions:ext_dev_rules.html.twig', $templateVariables);
	}

	public function rulesAction()
	{
		// Extensions Rules and Guidelines
		$templateVariables = array(
			'header_css_image' => 'mods',
			'policies'         => array(
				array('name' => 'Repack Policy', 'description' => 'How we handle repacking of Extensions.', 'link' => '/extensions/rules-and-guidelines/repack'),
				array('name' => 'Insta Deny Policy', 'description' => 'How we handle Insta Denies of Extensions.', 'link' => '/extensions/rules-and-guidelines/insta-deny'),
				array('name' => 'General', 'description' => 'Some general policies on how we handle validation.', 'link' => '/extensions/rules-and-guidelines/general'),
				array('name' => 'Validation checklist', 'description' => 'A reference for Extensions Authors to improve the validation process for their Extensions.', 'link' => '/extensions/rules-and-guidelines/checklist'),
			)
		);

		return $this->render('PhpbbWebsiteInterfaceBundle:Extensions:rules.html.twig', $templateVariables);
	}

	public function repack()
	{
		// Extensions Rules and Guidelines
		$templateVariables = array(
			'header_css_image' => 'mods',
		);

		return $this->render('PhpbbWebsiteInterfaceBundle:Extensions:repack.html.twig', $templateVariables);
	}
	public function instadenyAction()
	{
		// Extensions Rules and Guidelines
		$templateVariables = array(
			'header_css_image' => 'mods',
		);

		return $this->render('PhpbbWebsiteInterfaceBundle:Extensions:insta_deny.html.twig', $templateVariables);
	}
	public function generalAction()
	{
		// Extensions Rules and Guidelines
		$templateVariables = array(
			'header_css_image' => 'mods',
		);

		return $this->render('PhpbbWebsiteInterfaceBundle:Extensions:general.html.twig', $templateVariables);
	}
	public function checklistAction()
	{
		// Extensions Rules and Guidelines
		$templateVariables = array(
			'header_css_image' => 'mods',
		);

		return $this->render('PhpbbWebsiteInterfaceBundle:Extensions:checklist.html.twig', $templateVariables);
	}
}
