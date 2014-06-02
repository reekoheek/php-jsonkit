<?php

namespace JsonKit;

class JsonKit
{
    public static function replaceObject($data)
    {
        if ($data instanceof \JsonKit\JsonSerializer) {
            $data = $data->jsonSerialize();
            if (is_object($data)) {
                $data = (array) $data;
            }
        }

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::replaceObject($value);
            }
        }

        return $data;
    }

    public static function encode($data)
    {
        $jsonData = self::replaceObject($data);
        return json_encode($jsonData);
    }
}
