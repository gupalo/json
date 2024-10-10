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
                $data = json_decode($data, true);

                $err = json_last_error_msg();
                if ($err !== 'No error') {
                    throw new RuntimeException($err);
                }
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
            $s = json_encode($data);
        } catch (Throwable $e) {
            try {
                $s = json_encode($defaultData);
            } catch (Throwable $e) {
                $s = '{}';
            }
        }

        return $s;
    }
}
