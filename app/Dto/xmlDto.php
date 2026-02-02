<?php

namespace App\Dto;

class xmlDto
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $reference,
        public string $date,
        public float $amount,
        public string $currency,
        public string $senderAccount,
        public string $receiverAccount,
        public array $notes = [],
        public ?int $paymentType = null,
        public ?string $chargeDetails = null,
    )
    {}
}
