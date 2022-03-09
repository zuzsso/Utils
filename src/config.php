<?php

use function DI\autowire;

return [
	GetHostPublicIpV4::class => autowire(HostPublicIpV4Getter::class)
];
