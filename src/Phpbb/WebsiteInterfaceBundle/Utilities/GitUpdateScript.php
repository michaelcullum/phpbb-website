<?php
/**
 *
 * @package PhpbbWebsiteInterfaceBundle
 * @copyright (c) 2014 phpBB Group
 * @license http://opensource.org/licenses/gpl-3.0.php GNU General Public License v3
 * @author MichaelC
 *
 */

namespace Phpbb\WebsiteInterfaceBundle\Utilities;

class GitUpdateScript
{
	public function __construct($root_path, \Swift_Mailer $mailer)
	{
		$this->root_path = $root_path;
		$this->mailer = $mailer;
		$this->user = false;
	}

	public function setResultId($resultId)
	{
		$this->resultId = $resultId;
	}

	public function checkUpdateScriptAuthorisation()
	{
		// The people who can use this script. Ask your TL for permission if you need it!
		$groups = array(
			4,		// Management Team
			7331,	// Development Team
			13330,	// MOD Team
			47077,	// Website Team
		);

		$users = array(
			987265, // Oyabun1

		);

		if (($this->user->inGroupArray($groups)) || in_array($this->user->data['id'], $users))
		{
			return true;
		}

		return false;
	}

	public function getCurrentDetails()
	{
		$this->last_pull_time = filemtime($this->root_path . '.git/HEAD');
		$this->revision_hash = trim(file_get_contents($this->root_path . '.git/HEAD'));

		if (substr($this->revision_hash, 0, 5) === 'ref: ')
		{
			$this->last_pull_time = filemtime($this->root_path . '.git/' . substr($this->revision_hash, 5));
			$this->revision_hash = trim(file_get_contents($this->root_path . '.git/' . substr($this->revision_hash, 5)));
		}

		return array(
			'revision_hash'			=> $this->revision_hash,
			'last_pull_time'		=> date('l jS \of F Y \a\t h:i:s A', $this->last_pull_time),
		);
	}

	public function initiateUpdate()
	{
		if (file_exists($this->root_path . 'app/updates/.update_result'))
		{
			unlink($this->root_path . 'app/updates/.update_result');
		}

		// Create update file...
		$fp = fopen($this->root_path . 'app/cache/.update', 'wb');
		fwrite($fp, 'Website Update Initiated By ' . $this->user->data['username'] . "\n");
		fclose($fp);

		$result = time() - 10;

		return $result;
	}

	public function checkForResult()
	{
		$success = false;

		if (file_exists($this->root_path . 'app/cache/.update_result'))
		{
			$filetime = filemtime($this->root_path . 'app/cache/.update_result');

			if ($filetime >= $result)
			{
				$success = true;
				$this->contents = nl2br(htmlspecialchars(file_get_contents($this->root_path . 'app/cache/.update_result')));
				$this->contents_no_break = htmlspecialchars(file_get_contents($this->root_path . 'app/cache/.update_result'));
				$this->response = '';

				storeResult();
				notifyOfUpdate();

				return array(
					'show_result'	=> true,
					'result'		=> $this->contents . '<br />' . $this->response,
				);
			}
		}

		if (!$success)
		{
			meta_refresh(10, '/update_website/result/'. $this->resultId);

			return array(
				'show_progress' => true,
			);
		}
	}

	private function notifyOfUpdate()
	{
		// Send an email to the website team with the output of the update script.
		$message = \Swift_Message::newInstance()
			->setSubject('Website Update Script Run')
			->setFrom(array('website-update@phpbb.com' => 'phpBB Contact'))
			->setTo(array('website@phpbb.com' => 'phpBB Website Team'))
			->setReturnPath('website@phpbb.com')
			->setBody(
				$this->renderView(
					'PhpbbWebsiteInterfaceBundle:Global:websiteUpdate.email.twig',
					array(
						'result' 		=> $this->contents_no_break . $this->response,
						'result_id'		=> $this->resultId,
						'update_file_count'	=> $this->update_file_count,
						'update_time'	=> date('l jS \of F Y \a\t h:i:s A', $this->last_pull_time),
					)
				)
			);
		$this->mailer->send($message);
	}

	private function storeResult()
	{
		$fp = fopen($this->root_path . 'app/updates/'. $resultId, 'wb');
		fwrite($fp, file_get_contents($this->root_path . 'app/cache/.update_result'));
		fclose($fp);

		$this->update_file_count = 0;
		$dir = $this->root_path . 'app/updates/';
		if ($handle = opendir($dir)) {
			while (($file = readdir($handle)) !== false){
				if (!in_array($file, array('.', '..')) && !is_dir($dir.$file))
					$this->update_file_count++;
			}
		}
	}
}
