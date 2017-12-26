<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 26/12/2017
 */

namespace App\Component\Foundation\MessageBus;


abstract class SerializableMessage
{
    /** @var array */
    protected $payload = [];

    /**
     * BaseCommand constructor.
     *
     * @param array $payload
     */
    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        return $this->payload;
    }
}