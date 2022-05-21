<?php

namespace Gupalo\Tests;

use JsonSerializable;

class JsonSerializableStub implements JsonSerializable
{
    private $uid;

    public function __construct(string $uid)
    {
        $this->uid = $uid;
    }

    public function jsonSerialize(): array
    {
        return ['uid' => $this->uid];
    }
}
