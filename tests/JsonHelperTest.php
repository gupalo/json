<?php

namespace Gupalo\Tests;

use Gupalo\Json\Json;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class JsonHelperTest extends TestCase
{
    public function testToArray(): void
    {
        $data = ['key' => 'value', ['subkey' => 'subvalue', 'k2' => 'v2']];
        $s = '{"key":"value","0":{"subkey":"subvalue","k2":"v2"}}';

        self::assertSame($data, Json::toArray($s));
        self::assertSame($data, Json::decode($s));
    }

    public function testToArray_JsonSerializable(): void
    {
        $data = ['uid' => '123'];
        $obj = new JsonSerializableStub('123');

        self::assertSame($data, Json::toArray($obj));
        self::assertSame($data, Json::decode($obj));
    }

    public function testToArray_Empty(): void
    {
        self::assertSame([], Json::toArray());
        self::assertSame([], Json::decode());

        self::assertSame([], Json::toArray(null));
        self::assertSame([], Json::decode(null));

        self::assertSame([], Json::toArray(''));
        self::assertSame([], Json::decode(''));
    }

    public function testToArray_InvalidJson(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Syntax error');

        Json::toArray('invalid_json');
    }

    public function testToString(): void
    {
        $data = ['key' => 'value', ['subkey' => 'subvalue', 'k2' => 'v2']];
        $s = '{"key":"value","0":{"subkey":"subvalue","k2":"v2"}}';

        self::assertSame($s, Json::toString($data));
        self::assertSame($s, Json::encode($data));
    }
}
