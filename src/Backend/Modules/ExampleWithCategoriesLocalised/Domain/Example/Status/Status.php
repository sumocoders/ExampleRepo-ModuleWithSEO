<?php

namespace Backend\Modules\Example\Domain\Example\Status;

class Status
{
    const PENDING = 'pending';
    const CANCELLED = 'cancelled';
    const FINISHED = 'finished';

    const ALL = [
        self::PENDING,
        self::CANCELLED,
        self::FINISHED,
    ];

    private $status;

    public function __construct(string $status)
    {
        $this->status = $status;

        if (!in_array($status, self::ALL)) {
            throw new \InvalidArgumentException("$status is not a valid Status");
        }
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function __toString(): string
    {
        return $this->getStatus();
    }
}
