<?php

namespace Devr\Utils;

final class Text
{
    /**
     * @param string $value
     * @return string
     */
    public static function removeWhitespace(string $value): string
    {
        return str_replace(' ', '', $value);
    }

    /**
     * @param string $value
     * @return string
     */
    public static function formatTelAttr(string $value): string
    {
        return preg_replace('/[\s()-]/', '', $value);
    }
}