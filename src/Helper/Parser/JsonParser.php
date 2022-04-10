<?php


namespace App\Helper\Parser;

use App\Exception\Json\JsonValidateException;
use App\Interfaces\Exception\ExceptionMessageInterface;

class JsonParser
{
    /**
     * @param string $json
     * @return array
     * @throws JsonValidateException
     */
    public static function parse(string $json): array
    {
        $formData = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new JsonValidateException(
                ExceptionMessageInterface::JSON_VALIDATE_EXCEPTION
            );
        }

        return $formData;
    }
}
