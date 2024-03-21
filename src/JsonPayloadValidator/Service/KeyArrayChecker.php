<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Service;

use Utils\JsonPayloadValidator\Exception\IncorrectParametrizationException;
use Utils\JsonPayloadValidator\Exception\OptionalPropertyNotAnArrayException;
use Utils\JsonPayloadValidator\Exception\ValueArrayNotExactLengthException;
use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryForbiddenException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\Exception\RequiredArrayIsEmptyException;
use Utils\JsonPayloadValidator\Exception\ValueNotAnArrayException;
use Utils\JsonPayloadValidator\Exception\ValueTooBigException;
use Utils\JsonPayloadValidator\Exception\ValueTooSmallException;
use Utils\JsonPayloadValidator\UseCase\CheckKeyArray;
use Utils\JsonPayloadValidator\UseCase\CheckKeyPresence;
use Utils\JsonPayloadValidator\UseCase\CheckValueArray;

class KeyArrayChecker extends AbstractJsonChecker implements CheckKeyArray
{
    private CheckKeyPresence $checkPropertyPresence;
    private CheckValueArray $checkValueArray;

    public function __construct(CheckKeyPresence $checkPropertyPresence, CheckValueArray $checkValueArray)
    {
        $this->checkPropertyPresence = $checkPropertyPresence;
        $this->checkValueArray = $checkValueArray;
    }

    /**
     * @inheritDoc
     */
    public function requiredKey(string $key, array $payload): self
    {
        $this->checkPropertyPresence->required($key, $payload);

        $value = $payload[$key];

        if (!is_array($value)) {
            throw ValueNotAnArrayException::constructForStandardMessage($key);
        }

        $count = count($value);

        if ($count === 0) {
            throw RequiredArrayIsEmptyException::constructForStandardMessage();
        }

        $this->checkAllKeysAreNumericAndNoGaps($value);

        return $this;
    }

    /**
     * @throws OptionalPropertyNotAnArrayException
     * @throws ValueNotAnArrayException
     */
    public function optionalKey(string $key, array $payload): CheckKeyArray
    {
        try {
            $this->checkPropertyPresence->forbidden($key, $payload);
            return $this;
        } catch (EntryForbiddenException $e) {
        }

        $value = $payload[$key];

        if (!is_array($value)) {
            throw OptionalPropertyNotAnArrayException::constructForKey($key);
        }



        if (count($value) === 0) {
            return $this;
        }

        try {
            $this->requiredKey($key, $payload);
        } catch (EntryEmptyException | EntryMissingException $e) {
            return $this;
        } catch (RequiredArrayIsEmptyException $e) {
            throw OptionalPropertyNotAnArrayException::constructForKey($key);
        }


        return $this;
    }

    /**
     * @inheritDoc
     */
    public function keyArrayOfJsonObjects(string $key, array $payload, bool $required = true): self
    {
        if ($required === false) {
            try {
                $this->checkPropertyPresence->forbidden($key, $payload);
                return $this;
            } catch (EntryForbiddenException $e) {
            }
        }


        $this->requiredKey($key, $payload);

        $arrayElements = $payload[$key];

        $this->checkValueArray->arrayOfJsonObjects($arrayElements);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function keyArrayOfExactLength(string $key, array $payload, int $length, bool $required = true): self
    {
        if ($length <= 0) {
            throw new IncorrectParametrizationException('Min required length is 1');
        }

        if (!$required) {
            try {
                $this->checkPropertyPresence->forbidden($key, $payload);
                return $this;
            } catch (EntryForbiddenException $e) {
            }
        }

        $this->requiredKey($key, $payload);

        $value = $payload[$key];

        $count = count($value);

        if ($count !== $length) {
            throw ValueArrayNotExactLengthException::constructForKeyArray($key, $length, $count);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function keyArrayOfLengthRange(
        string $key,
        array $payload,
        ?int $minLength,
        ?int $maxLength,
        bool $required = true
    ): self {
        $this->checkRanges($minLength, $maxLength);

        if ($required === false) {
            try {
                $this->checkPropertyPresence->forbidden($key, $payload);
                return $this;
            } catch (EntryForbiddenException $e) {
            }
        }

        $this->requiredKey($key, $payload);

        $count = count($payload[$key]);

        if (($minLength !== null) && ($count < $minLength)) {
            throw ValueTooSmallException::constructForKeyArray($key, $minLength, $count);
        }

        if (($maxLength !== null) && ($count > $maxLength)) {
            throw ValueTooBigException::constructForKeyArrayLength($key, $maxLength, $count);
        }

        return $this;
    }
}
