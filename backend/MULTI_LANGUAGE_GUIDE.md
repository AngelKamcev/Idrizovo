# Multi-Language Support Implementation Guide

This guide covers the complete implementation of multi-language support (Macedonian, English, Albanian) in your Laravel 12 project.

## Installation Complete ✓

All required packages have been installed:
- `mcamara/laravel-localization` (v2.4.0) - URL-based localization
- `spatie/laravel-translatable` (v6.11.4) - Database translatable attributes
- `stichoza/google-translate-php` (v5.3.1) - Auto-translation service

## Configuration Files

### 1. Language Configuration
**File:** `config/laravellocalization.php`
- Defines supported locales: mk, en, sq
- Sets Macedonian (mk) as default locale
- Configures URL parameter for locale detection
- Maps locales to their display names

### 2. Static Translation Files
Created JSON translation files for UI text:
- `lang/mk.json` - Macedonian translations
- `lang/en.json` - English translations
- `lang/sq.json` - Albanian translations

**Usage in Blade:**
```blade
{{ __('activities') }}  // Get translated string
{{ __('save') }}        // Auto-selects based on current locale
```

## Routes with Language Prefix

All public routes now include language prefix:
- `/mk/` - Macedonian URLs
- `/en/` - English URLs
- `/sq/` - Albanian URLs

**Example URLs:**
- `/mk/activities` - Activities in Macedonian
- `/en/contact` - Contact form in English
- `/sq/gallery` - Gallery in Albanian

Routes are wrapped with localization middleware in `routes/web.php`.

## Database Models with Translation Support

### Models Created

#### 1. Activity Model (`app/Models/Activity.php`)
```php
class Activity extends Model {
    use HasTranslations;
    public array $translatable = ['title', 'description'];
}
```

#### 2. Announcement Model (`app/Models/Announcement.php`)
```php
class Announcement extends Model {
    use HasTranslations;
    public array $translatable = ['title', 'content'];
}
```

#### 3. GalleryImage Model (`app/Models/GalleryImage.php`)
```php
class GalleryImage extends Model {
    use HasTranslations;
    public array $translatable = ['title'];
}
```

**Migration:** `database/migrations/2026_05_08_000010_create_translatable_content_tables.php`

### Using Translatable Models

```php
// Create with translations
$activity = Activity::create([
    'title' => [
        'mk' => 'Насловот на македонски',
        'en' => 'Title in English',
        'sq' => 'Titulli në Shqip'
    ],
    'description' => [
        'mk' => '...',
        'en' => '...',
        'sq' => '...'
    ]
]);

// Get translation for current locale
echo $activity->getTranslation('title', app()->getLocale());

// Check if translation exists
if ($activity->hasTranslation('title', 'en')) {
    // ...
}
```

## Auto-Translation Service

### Service File
**Location:** `app/Services/AutoTranslateService.php`

### Key Methods

```php
// Translate single text
$translated = $service->translate('Hello', 'en', 'mk');

// Translate multiple fields
$translations = $service->translateFields([
    'title' => 'My Activity',
    'description' => 'This is a description'
], 'en', ['mk', 'sq']);

// Create complete translatable data structure
$data = $service->createTranslatableData([
    'title' => 'Activities',
    'description' => 'Institutional activities'
], 'en', ['mk', 'sq']);
```

## Admin Controller Example

**File:** `app/Http/Controllers/Admin/ActivityController.php`

### Store Method with Auto-Translation

```php
public function store(Request $request)
{
    $validated = $request->validate([
        'title_mk' => 'required|string|max:255',
        'description_mk' => 'required|string|max:1000',
        'auto_translate' => 'boolean',
    ]);

    $sourceData = [
        'title' => $validated['title_mk'],
        'description' => $validated['description_mk'],
    ];

    // Auto-translate to EN and SQ
    if ($validated['auto_translate'] ?? true) {
        $translations = $this->translateService->createTranslatableData(
            $sourceData,
            'mk',
            ['en', 'sq']
        );
    }

    $activity = Activity::create([
        'title' => $translations['title'],
        'description' => $translations['description'],
    ]);

    return redirect()->with('success', 'Activity created with auto-translations!');
}
```

## Language Switcher Component

**File:** `resources/views/components/language-switcher.blade.php`

### Features
- Dropdown menu with all supported locales
- Flag emojis for each language (🇲🇰 🇬🇧 🇦🇱)
- Shows current locale with checkmark
- Links to localized versions of current page
- Responsive hover state

### Usage in Blade

```blade
<!-- Add to header/navbar -->
@component('components.language-switcher') @endcomponent

<!-- Or include in any template -->
<x-language-switcher />
```

### Customize Colors
Edit the Tailwind classes in the component file:
- `bg-gray-100` - Default button background
- `bg-blue-50` - Hover/selected background
- `text-blue-600` - Active language color

## Public Activities View Example

**File:** `resources/views/public/activities.blade.php`

Features:
- Displays activities with translations
- Shows available languages for each activity
- Responsive grid layout
- Language switcher at top
- Pagination support

## Middleware

### Localization Middleware
**File:** `app/Http/Middleware/SetLocale.php`

Automatically sets application locale based on:
1. URL parameter (primary)
2. Session storage (fallback)
3. Default locale (final fallback)

### Middleware Registration
Added to `bootstrap/app.php`:
```php
$middleware->alias([
    'localeSessionRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
    'localizationRedirect' => \Mcamara\LaravelLocalization\Middleware\LocalizationRedirect::class,
    'localeViewPath' => \Mcamara\LaravelLocalization\Middleware\LocaleViewPath::class,
]);
```

## How to Use

### 1. Creating Content (Admin)

```blade
<form action="{{ route('admin.activities.store') }}" method="POST">
    @csrf
    
    <!-- Macedonian input (required) -->
    <div class="form-group">
        <label>{{ __('title') }} (Македонски)</label>
        <input type="text" name="title_mk" required>
    </div>
    
    <!-- Auto-translate checkbox -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="auto_translate" value="1" checked>
            {{ __('Auto-translate to EN and SQ') }}
        </label>
    </div>
    
    <button type="submit">{{ __('save') }}</button>
</form>
```

### 2. Displaying Content (Public)

```blade
<!-- Get current locale version -->
{{ $activity->getTranslation('title', app()->getLocale()) }}

<!-- List all available languages -->
@foreach(['mk', 'en', 'sq'] as $lang)
    @if($activity->hasTranslation('title', $lang))
        <span>{{ strtoupper($lang) }}</span>
    @endif
@endforeach
```

### 3. Switching Languages

```blade
<!-- Generate URL for different locale -->
<a href="{{ LaravelLocalization::getLocalizedURL('en') }}">English</a>
<a href="{{ LaravelLocalization::getLocalizedURL('sq') }}">Shqip</a>
<a href="{{ LaravelLocalization::getLocalizedURL('mk') }}">Македонски</a>
```

## Next Steps

### 1. Run Migrations
```bash
php artisan migrate
```

### 2. Create Admin Routes
Add routes to `routes/web.php`:
```php
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resource('activities', ActivityController::class);
});
```

### 3. Test Multi-Language
- Visit `/mk/activities` (Macedonian)
- Visit `/en/activities` (English)
- Visit `/sq/activities` (Albanian)
- Language switcher should work seamlessly

### 4. Update Existing Templates
Add language switcher to your main layout:
```blade
<!-- In header/navbar -->
@component('components.language-switcher') @endcomponent
```

## Extending to Other Models

To make any model translatable:

```php
use Spatie\Translatable\HasTranslations;

class YourModel extends Model {
    use HasTranslations;
    
    public array $translatable = ['field1', 'field2'];
}
```

## Troubleshooting

### Translation not working?
1. Verify `app()->getLocale()` returns correct locale
2. Check if `lang/[locale].json` file exists
3. Clear cache: `php artisan cache:clear`

### Auto-translation failing?
1. Check network connection (uses Google Translate API)
2. Review `storage/logs/laravel.log` for errors
3. Fallback: translations will use source text

### Routes not showing language prefix?
1. Verify routes are wrapped with localization group
2. Clear route cache: `php artisan route:cache`
3. Check `config/laravellocalization.php` configuration

## Performance Tips

1. **Cache translations** - Add caching layer for translations
2. **Lazy load translations** - Use eager loading for related translations
3. **CDN for static assets** - Serve images/CSS from CDN
4. **Queue auto-translation** - For large text, use queue jobs

## Security

- Always validate language input
- Sanitize translated content
- Use HTTPS for external translation API calls
- Rate limit translation API calls

## Support

For issues with specific packages:
- mcamara/laravel-localization: https://github.com/mcamara/laravel-localization
- spatie/laravel-translatable: https://github.com/spatie/laravel-translatable
- stichoza/google-translate-php: https://github.com/Stichoza/google-translate-php

---
**Implementation Date:** May 8, 2026
**Locales:** Macedonian (mk), English (en), Albanian (sq)
