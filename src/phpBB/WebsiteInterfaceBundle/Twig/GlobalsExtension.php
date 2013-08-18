<?php

namespace phpBB\WebsiteInterfaceBundle\Twig;

class GlobalsExtension extends \Twig_Extension
{
	public function getGlobals()
	{
		$generalVars = array(
			'package_version'		=> '3.0.11',
			'package_release_date'	=> '2012-08-25',
			'bot'					=> false, // TODO: Set this to true for bots
		);

		$pathVars = array(
			'about_path'		=> '/about/',
			'advertise_path'	=> '/about/advertise/',
			'demo_path'			=> '/demo/',
			'downloads_path'	=> '/downloads/',
			'cdb_path'			=> '/customise/db/',
			'support_path'		=> '/support/',
			'development_path'	=> '/development/',
			'community_path'	=> '/community/',
			'contact_path'		=> '/about/contact_us.php',
			'get_involved_path'	=> '/get-involved/',
			'mods_db_path'		=> '/customise/db/modifications-1/',
			'styles_db_path'	=> '/customise/db/styles-2/',
			'shop_path'			=> '/shop/',
			'blog_link'			=> '//blog.phpbb.com/',
		);

		$variables = array_merge($generalVars, $pathVars);

		return $variables;
	}

	public function getName()
    {
        return 'phpbb_extension_globals';
    }
}
