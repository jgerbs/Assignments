<?php

class Validator
{
    /**
     * Validate if a given string is a valid URL.
     *
     * @param string $url
     * @return bool
     */
    public static function isValidUrl(string $url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Validate if a given string is a valid title.
     *
     * @param string $title
     * @return bool
     */
    public static function isValidTitle(string $title): bool
    {
        return !empty($title);
    }
}

