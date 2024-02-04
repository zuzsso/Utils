<?php

namespace Utils\DateAndTime\UseCase;

use DateTimeImmutable;

interface ProvideDateTime
{
    public function getSystemDateTime(): DateTimeImmutable;
}
