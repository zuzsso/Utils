<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Service;

use DateTimeImmutable;
use Utils\JsonValidator\Exception\EntryEmptyException;
use Utils\JsonValidator\Exception\EntryForbiddenException;
use Utils\JsonValidator\Exception\EntryMissingException;
use Utils\JsonValidator\Exception\IncorrectParametrizationException;
use Utils\JsonValidator\Exception\InvalidDateValueException;
use Utils\JsonValidator\Exception\OptionalPropertyNotAStringException;
use Utils\JsonValidator\Exception\StringIsNotAnUrlException;
use Utils\JsonValidator\Exception\ValueNotAStringException;
use Utils\JsonValidator\Exception\ValueStringNotExactLengthException;
use Utils\JsonValidator\Exception\ValueTooBigException;
use Utils\JsonValidator\Exception\ValueTooSmallException;
use Utils\JsonValidator\Types\Range\StringByteLengthRange;
use Utils\JsonValidator\UseCase\CheckKeyPresence;
use Utils\JsonValidator\UseCase\CheckKeyString;

class KeyStringChecker extends AbstractJsonChecker implements CheckKeyString
{
    private CheckKeyPresence $checkPropertyPresence;

    public function __construct(CheckKeyPresence $checkPropertyPresence)
    {
        $this->checkPropertyPresence = $checkPropertyPresence;
    }

    /**
     * @inheritDoc
     */
    public function required(string $key, array $payload): self
    {
        $this->checkPropertyPresence->required($key, $payload);

        $value = $payload[$key];

        if (!is_string($value)) {
            throw ValueNotAStringException::constructForStandardMessage($key);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function optional(string $key, array $payload): self
    {
        try {
            $this->checkPropertyPresence->forbidden($key, $payload);
            return $this;
        } catch (EntryForbiddenException $e) {
            // Property present, so make sure it is a string
            try {
                $this->required($key, $payload);
                return $this;
            } catch (EntryEmptyException | EntryMissingException | ValueNotAStringException $e) {
                throw OptionalPropertyNotAStringException::constructForStandardMessage($key);
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function byteLengthRange(
        string $key,
        array $payload,
        StringByteLengthRange $byteLengthRange,
        bool $required = true
    ): CheckKeyString {
        if (!$required) {
            try {
                $this->checkPropertyPresence->forbidden($key, $payload);
                return $this;
            } catch (EntryForbiddenException $e) {
                // The property exists, so validate it as if it was required
            }
        }

        $this->required($key, $payload);

        $trim = trim($payload[$key]);

        $length = strlen($trim);

        $maximumLength = $byteLengthRange->getMax();
        $minimumLength = $byteLengthRange->getMin();

        if (($minimumLength !== null) && ($length < $minimumLength)) {
            throw ValueTooSmallException::constructForStringLength($key, $minimumLength, $length);
        }

        if ($maximumLength !== null && ($length > $maximumLength)) {
            throw ValueTooBigException::constructForStringLength($key, $maximumLength, $length);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function urlFormat(string $key, array $payload, bool $required = true): self
    {
        if (!$required) {
            try {
                $this->checkPropertyPresence->forbidden($key, $payload);
                return $this;
            } catch (EntryForbiddenException $e) {
                // Continue validation as if it was required
            }
        }

        $this->required($key, $payload);

        $val = $payload[$key];
        if (!filter_var($val, FILTER_VALIDATE_URL)) {
            throw StringIsNotAnUrlException::constructForStandardMessage($val);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function exactByteLength(string $key, array $payload, int $exactLength, bool $required = true): self
    {
        if ($exactLength < 0) {
            throw new IncorrectParametrizationException(
                "Negative lengths not allowed, but you specified an exact length of '$exactLength'"
            );
        }

        if ($exactLength === 0) {
            throw new IncorrectParametrizationException(
                "Zero lengths would require the 'optional' validator. Please correct the length"
            );
        }

        if (!$required) {
            try {
                $this->checkPropertyPresence->forbidden($key, $payload);
                return $this;
            } catch (EntryForbiddenException $e) {
                // Property exists, validate it as if it was required
            }
        }

        $this->required($key, $payload);

        $len = strlen(trim($payload[$key]));
        if ($len !== $exactLength) {
            throw ValueStringNotExactLengthException::constructForStandardMessage($key, $exactLength, $len);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function dateTimeFormat(string $key, array $payload, string $dateFormat, bool $required = true): self
    {
        if (!$required) {
            try {
                $this->checkPropertyPresence->forbidden($key, $payload);
                return $this;
            } catch (EntryForbiddenException $e) {
            }
        }

        $this->required($key, $payload);

        $value = trim((string)$payload[$key]);

        $parsed = DateTimeImmutable::createFromFormat($dateFormat, $value);

        if ($parsed === false) {
            throw InvalidDateValueException::constructForStandardMessage($key, $dateFormat, $value);
        }

        return $this;
    }
}
