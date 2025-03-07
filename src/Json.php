<?php

namespace Gupalo\Json;

use JsonSerializable;
use RuntimeException;
use Throwable;

class Json
{
    public static function decode(array|string|JsonSerializable|null $data = null): array
    {
        return self::toArray($data);
    }

    public static function toArray(array|string|JsonSerializable|null $data = null): array
    {
        if ($data === null || $data === '') {
            $data = [];
        }

        if (is_string($data)) {
            try {
                $data = json_decode($data, true, 512, JSON_THROW_ON_ERROR + JSON_INVALID_UTF8_SUBSTITUTE);
            } catch (Throwable $e) {
                throw new RuntimeException($e->getMessage());
            }
        } elseif ($data instanceof JsonSerializable) {
            $data = $data->jsonSerialize();
        }

        return $data;
    }

    public static function encode(mixed $data = null, $defaultData = []): string
    {
        return self::toString($data, $defaultData);
    }

    public static function toString(mixed $data = null, $defaultData = []): string
    {
        try {
            $s = json_encode($data, JSON_THROW_ON_ERROR + JSON_INVALID_UTF8_SUBSTITUTE);
        } catch (Throwable) {
            try {
                $s = json_encode($defaultData, JSON_THROW_ON_ERROR + JSON_INVALID_UTF8_SUBSTITUTE);
            } catch (Throwable) {
                $s = '{}';
            }
        }

        return $s;
    }
}
