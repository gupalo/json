<?php

namespace Gupalo\Json;

use JsonSerializable;
use RuntimeException;
use Throwable;

class Json
{
    /**
     * @param array|string|JsonSerializable|null $data
     * @return array
     */
    public static function toArray($data = null): array
    {
        if ($data === null || $data === '') {
            $data = [];
        }

        if (is_string($data)) {
            try {
                $data = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
            } catch (Throwable $e) {
                throw new RuntimeException($e->getMessage());
            }
        } elseif ($data instanceof JsonSerializable) {
            $data = $data->jsonSerialize();
        }

        return $data;
    }

    public static function toString($data = null, $defaultData = []): string
    {
        try {
            $s = json_encode($data, JSON_THROW_ON_ERROR);
        } catch (Throwable $e) {
            try {
                $s = json_encode($defaultData, JSON_THROW_ON_ERROR);
            } catch (Throwable $e) {
                $s = '{}';
            }
        }

        return $s;
    }
}
