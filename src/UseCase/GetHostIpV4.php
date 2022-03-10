<?php

declare(strict_types=1);


namespace NetUtils\UseCase;

use NetUtils\Object\IpV4;

interface GetHostIpV4
{
	/**
	 * @return IpV4
	 */
	public static function getPublicAddress(): IpV4;

	/**
	 * @return IpV4
	 */
	public static function getLocalAddress(): IpV4;
}
