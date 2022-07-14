<?php

declare(strict_types=1);


namespace Utils\Networking\UseCase;

use Utils\Networking\Object\IpV4;

interface GetLocalHostIpV4
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
