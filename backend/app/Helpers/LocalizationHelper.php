<?php

if (!function_exists('localized_url')) {
    /**
     * Generate a localized URL for a given path and locale
     *
     * @param string $locale The locale code (mk, en, sq)
     * @param string|null $path The path to localize (current path if null)
     * @return string The localized URL
     */
    function localized_url($locale = null, $path = null)
    {
        $locale = $locale ?? app()->getLocale();
        
        if (!$path) {
            $path = request()->path();
        }

        // Remove existing locale prefix from path if present
        $segments = explode('/', $path);
        if (in_array($segments[0] ?? null, ['mk', 'en', 'sq'])) {
            array_shift($segments);
        }

        // Build the new URL with locale prefix
        $newPath = trim($locale . '/' . implode('/', array_filter($segments)), '/');
        
        return url($newPath);
    }
}

if (!function_exists('is_locale_active')) {
    /**
     * Check if a locale is currently active
     *
     * @param string $locale The locale code to check
     * @return bool
     */
    function is_locale_active($locale)
    {
        return app()->getLocale() === $locale;
    }
}

if (!function_exists('get_locale_name')) {
    /**
     * Get the display name for a locale
     *
     * @param string $locale The locale code (mk, en, sq)
     * @return string
     */
    function get_locale_name($locale)
    {
        $names = [
            'mk' => 'Македонски',
            'en' => 'English',
            'sq' => 'Shqip',
        ];

        return $names[$locale] ?? $locale;
    }
}

if (!function_exists('get_locale_emoji')) {
    /**
     * Get the flag emoji for a locale
     *
     * @param string $locale The locale code (mk, en, sq)
     * @return string
     */
    function get_locale_emoji($locale)
    {
        $emojis = [
            'mk' => '🇲🇰',
            'en' => '🇬🇧',
            'sq' => '🇦🇱',
        ];

        return $emojis[$locale] ?? '🌐';
    }
}
