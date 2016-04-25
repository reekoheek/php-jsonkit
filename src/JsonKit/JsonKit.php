<?php

namespace JsonKit;

class JsonKit
{
    protected static $stack;

    public static function replaceObject($data, array $options = [])
    {
        if ($data instanceof JsonSerializer) {
            if (in_array($data, self::$stack)) {
                return '*** circular ***';
            }
            array_push(self::$stack, $data);
            $data = $data->jsonSerialize($options);
            array_pop(self::$stack);
            if (is_object($data)) {
                $data = (array) $data;
            }
        }

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::replaceObject($value, $options);
            }
        }

        return $data;
    }

    public static function encode($data, array $options = [])
    {
        self::$stack = array();

        $jsonData = self::replaceObject($data, $options);
        return json_encode($jsonData, JSON_NUMERIC_CHECK);
    }
}
