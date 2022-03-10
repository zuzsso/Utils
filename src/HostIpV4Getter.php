<?php

declare(strict_types=1);

namespace NetUtils;

use NetUtils\Object\IpV4;
use NetUtils\UseCase\GetHostIpV4;

class HostIpV4Getter implements GetHostIpV4
{
	/**
	 * @inheritDoc
	 */
	public static function getPublicAddress(): IpV4
	{
		// create a new cURL resource
		$ch = curl_init();

		// set URL and other appropriate options
		curl_setopt($ch, CURLOPT_URL, "http://ipecho.net/plain");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// grab URL and pass it to the browser

		$ip = curl_exec($ch);

		// close cURL resource, and free up system resources
		curl_close($ch);

		return IpV4::constructFromString($ip);
	}

	/**
	 * @inheritDoc
	 */
	public static function getLocalAddress(): Ipv4
	{
		return IpV4::constructFromString(getHostByName(getHostName()));
	}
}
