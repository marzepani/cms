<?php

class SiteService extends CApplicationComponent implements ISiteService
{
	public function getLicenseKeys()
	{
		if (isset(Blocks::app()->params['config']['licenseKeys']))
			return Blocks::app()->params['config']['licenseKeys'];

		return null;
	}

	public function getSiteName()
	{
		if (isset(Blocks::app()->params['config']['siteName']))
			return Blocks::app()->params['config']['siteName'];

		return null;
	}

	public function getSiteLanguage()
	{
		if (isset(Blocks::app()->params['config']['language']))
			return Blocks::app()->params['config']['language'];

		return null;
	}

	public function getSiteUrl()
	{
		if (isset(Blocks::app()->params['config']['siteUrl']))
			return Blocks::app()->params['config']['siteUrl'];

		return null;
	}

	public function getSiteByUrl()
	{
		$serverName = Blocks::app()->request->getServerName();
		$httpServerName = 'http://'.$serverName;
		$httpsServerName = 'https://'.$serverName;

		$site = Sites::model()->find(
			'url=:url OR url=:httpUrl OR url=:httpsUrl', array(':url' => $serverName, ':httpUrl' => $httpServerName, ':httpsUrl' => $httpsServerName)
		);

		return $site;
	}

	public function getAllowedTemplateFileExtensions()
	{
		return array('html', 'php');
	}

	public function matchTemplatePathWithAllowedFileExtensions($templatePath, $srcLanguage = 'en-us')
	{
		foreach ($this->getAllowedTemplateFileExtensions() as $allowedExtension)
		{
			$templateFile = Blocks::app()->findLocalizedFile($templatePath.'.'.$allowedExtension, $srcLanguage);
			if (is_file($templateFile))
				return realpath($templateFile);
		}

		return null;
	}
}
