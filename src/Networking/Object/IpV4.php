<?php

declare(strict_types=1);

namespace Utils\Networking\Object;

use LogicException;

class IpV4 {
    private int $firstOctet;
    private int $secondOctet;
    private int $thirdOctect;
    private int $fourthOctet;

    private function __construct(int $firstOctet, int $secondOctet, int $thirdOctet, int $fourthOctet) {
        $this->firstOctet = $firstOctet;
        $this->secondOctet = $secondOctet;
        $this->thirdOctect = $thirdOctet;
        $this->fourthOctet = $fourthOctet;
    }

    /**
     * @param string $ipInStringFormat
     * @return static
     */
    public static function constructFromString(string $ipInStringFormat): self {
        $valid = filter_var($ipInStringFormat, FILTER_VALIDATE_IP);

        if ($valid === false) {
            throw new LogicException("Unrecognized IP V4 address: '$ipInStringFormat'");
        }


        $parts = explode('.', $valid);

        if (count($parts) !== 4) {
            throw new LogicException("Expected to find four octets");
        }

        return new self (
            (int)$parts[0],
            (int)$parts[1],
            (int)$parts[2],
            (int)$parts[3],
        );
    }

    public function equalsTo(IpV4 $anotherIpV4): bool {
        return
            ($this->firstOctet === $anotherIpV4->firstOctet) &&
            ($this->secondOctet === $anotherIpV4->secondOctet) &&
            ($this->thirdOctect === $anotherIpV4->thirdOctect) &&
            ($this->fourthOctet === $anotherIpV4->fourthOctet);
    }

    public function __toString(): string {
        return $this->firstOctet . '.' . $this->secondOctet . '.' . $this->thirdOctect . '.' . $this->fourthOctet;
    }
}
