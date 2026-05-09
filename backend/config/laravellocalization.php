<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Locales
    |--------------------------------------------------------------------------
    |
    | This is the array that should be used if the locales are not given
    | in the global request. It should follow the following structure
    | and cannot have a numeric index:
    |
    */
    'supportedLocales' => [
        'mk' => ['name' => 'Македонски', 'script' => 'Latn', 'native' => 'Македонски'],
        'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English'],
        'sq' => ['name' => 'Shqip', 'script' => 'Latn', 'native' => 'Shqip'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Locales
    |--------------------------------------------------------------------------
    |
    | Locales supported by the application
    |
    */
    'localesMapping' => [
        'mk' => 'mk_MK',
        'en' => 'en_US',
        'sq' => 'sq_AL',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default locale
    |--------------------------------------------------------------------------
    |
    | This is the default locale to use in the application. This value
    | will be used when Locale middleware detects no url parameter.
    |
    */
    'defaultLocale' => 'mk',

    /*
    |--------------------------------------------------------------------------
    | Fallback Locale
    |--------------------------------------------------------------------------
    |
    | This is the locale to fall back to when the current locale
    | is not available. This value will be used when a translation
    | file does not contain a specific key.
    |
    */
    'fallbackLocale' => 'mk',

    /*
    |--------------------------------------------------------------------------
    | URL parameter
    |--------------------------------------------------------------------------
    |
    | Define the parameter that should be used to detect the locale
    | in the url. By default the following URLs are accepted:
    |
    | http://example.com/en/about-us
    | http://example.com/en-US/about-us
    |
    */
    'localeParam' => 'locale',

    /*
    |--------------------------------------------------------------------------
    | Url Hide Default
    |--------------------------------------------------------------------------
    |
    | Define whether the default locale should be hidden in the url. When true,
    | URLs like /en/contact will be rendered as /contact if English is the
    | default locale. When false, all URLs will include the locale prefix.
    |
    */
    'hideDefaultLocaleInURL' => false,

    /*
    |--------------------------------------------------------------------------
    | Translation File Namespace
    |--------------------------------------------------------------------------
    |
    | Define the namespace that the translation helper will use for getting
    | translations. This is useful if you want to organize your language
    | files in a specific way.
    |
    */
    'translationFilePath' => 'lang',

    /*
    |--------------------------------------------------------------------------
    | Locale Detection Strategy
    |--------------------------------------------------------------------------
    |
    | Define the way to detect the locale. Options: url, cookie, header, session
    | url: tries to find the locale in the url parameter
    | cookie: tries to find the locale in a cookie named 'locale'
    | header: tries to find the locale in the Accept-Language HTTP header
    | session: tries to find the locale in the session
    |
    */
    'localeDetection' => [
        'strategy' => 'url',
        'cookie' => 'locale',
        'session' => 'locale',
    ],

    /*
    |--------------------------------------------------------------------------
    | Non translatable URIs
    |--------------------------------------------------------------------------
    |
    | Define a list of URIs that should not be translated. This is useful
    | for routes like /api/*, /admin/*, etc.
    |
    */
    'nonTranslatableRoutes' => ['api', 'admin'],
];
