<?php

namespace Backend\Modules\Examples\Domain\ValueObject;

class Status
{
    const PENDING = 'pending';
    const CANCELLED = 'canceled';
    const FINISHED = 'finished';

    const ALL = [
        self::PENDING,
        self::CANCELLED,
        self::FINISHED
    ];

    private $status;

    public function __construct(string $status)
    {
        if (!in_array($status, $this::ALL)) {
            throw new \Exception("$status isn't a valid status");
        }

        $this->status = $status;
    }

    public static function choices(): array
    {
        return [
            self::PENDING => new self(self::PENDING),
            self::CANCELLED => new self(self::CANCELLED),
            self::FINISHED => new self(self::FINISHED),
        ];
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
