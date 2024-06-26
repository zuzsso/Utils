<?php

declare(strict_types=1);

namespace Utils\DateAndTime\Service;

use Utils\DateAndTime\Exception\NoStopwatchesInCollectionException;
use Utils\DateAndTime\Exception\StopwatchAlreadyStoppedException;
use Utils\DateAndTime\Exception\StopwatchIdAlreadyExistsException;
use Utils\DateAndTime\Exception\StopwatchIdNotFoundException;
use Utils\DateAndTime\Exception\StopwatchNeverStartedException;
use Utils\DateAndTime\Exception\StopwatchNeverStoppedException;
use Utils\DateAndTime\Type\Stopwatch;

/**
 * @deprecated
 * Migrated to its own repo
 */
class Cronos
{
    /**
     * @var Stopwatch[]
     */
    private static array $stopwatches = [];

    /**
     * @deprecated
     * Migrated to its own repo
     * @throws StopwatchIdAlreadyExistsException
     */
    public static function startTraceId(string $id, bool $start = true): void
    {
        $stopWatch = new Stopwatch($id, $start);

        self::addStopwatch($stopWatch);
    }

    /**
     * @deprecated
     * Migrated to its own repo
     * @throws StopwatchAlreadyStoppedException
     * @throws NoStopwatchesInCollectionException
     * @throws StopwatchIdNotFoundException
     */
    public static function stopTraceId(string $id): void
    {
        if (count(self::$stopwatches) === 0) {
            throw new NoStopwatchesInCollectionException("Can't stop stopwatch. Empty stopwatch collection");
        }

        foreach (self::$stopwatches as $stopwatch) {
            $thisId = $stopwatch->getId();
            if ($thisId === $id) {
                $stopwatch->stop();
                return;
            }
        }

        throw new StopwatchIdNotFoundException("Stopwatch ID not found: $id");
    }

    /**
     * @deprecated
     * Migrated to its own repo
     * @throws StopwatchIdNotFoundException
     */
    public static function getStopwatchById(string $id): Stopwatch
    {

        foreach(self::$stopwatches as $stopwatch) {
            if ($stopwatch->getId() === $id) {
                return $stopwatch;
            }
        }

        throw new StopwatchIdNotFoundException("Stopwatch ID not found: $id");
    }

    /**
     * @deprecated
     * Migrated to its own repo
     * @throws StopwatchIdAlreadyExistsException
     */
    private static function addStopwatch(Stopwatch $s): void
    {
        $stopwatchId = $s->getId();

        foreach (self::$stopwatches as $stopwatch) {
            if ($stopwatch->getId() === $stopwatchId) {
                throw new StopwatchIdAlreadyExistsException("Stopwatch already exists: ID: " . $stopwatchId);
            }
        }

        self::$stopwatches[] = $s;
    }

    /**
     * @deprecated
     * Migrated to its own repo
     * @throws StopwatchNeverStartedException
     * @throws StopwatchNeverStoppedException
     * @throws NoStopwatchesInCollectionException
     */
    public static function dumpReportInSeconds(): string
    {
        if (count(self::$stopwatches) === 0) {
            throw new NoStopwatchesInCollectionException("Empty stopwatch collection. Nothing to report");
        }

        $report = '';

        foreach (self::$stopwatches as $stopwatch) {
            $timelapse = $stopwatch->getTimeLapseInSeconds();
            $id = $stopwatch->getId();

            $report .= ("$id -> $timelapse (s)" . PHP_EOL);
        }

        return $report;
    }

    /**
     * @deprecated
     * Migrated to its own repo
     * @throws StopwatchNeverStartedException
     * @throws StopwatchNeverStoppedException
     * @throws NoStopwatchesInCollectionException
     */
    public static function dumpReportInMilliSeconds(): string
    {
        if (count(self::$stopwatches) === 0) {
            throw new NoStopwatchesInCollectionException("Empty stopwatch collection. Nothing to report");
        }

        $report = '';

        foreach (self::$stopwatches as $stopwatch) {
            $timelapse = $stopwatch->getTimeLapseInMilliseconds();
            $id = $stopwatch->getId();

            $report .= ("$id -> $timelapse (ms)" . PHP_EOL);
        }

        return $report;
    }

    /**
     * @deprecated
     * Migrated to its own repo
     * @throws StopwatchAlreadyStoppedException
     */
    public static function cancelAllRunningTraces(): void
    {
        foreach (self::$stopwatches as $sw) {
            if ($sw->isRunning()) {
                $sw->stop();
            }
        }
    }
}
