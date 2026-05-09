# Multi-Language Quick Reference

## URL Format
```
/mk/activities      → Macedonian version
/en/activities      → English version
/sq/activities      → Albanian version
```

## In Blade Templates

### Translate Static Text
```blade
{{ __('activities') }}
{{ __('home') }}
{{ __('contact') }}
```

### Display Translatable Content
```blade
<!-- Get current locale version -->
{{ $activity->getTranslation('title', app()->getLocale()) }}

<!-- Get specific locale -->
{{ $activity->getTranslation('title', 'en') }}

<!-- Check if translation exists -->
@if($activity->hasTranslation('title', 'en'))
    English version available
@endif
```

### List All Available Languages
```blade
@foreach(['mk', 'en', 'sq'] as $lang)
    @if($activity->hasTranslation('title', $lang))
        <span>{{ strtoupper($lang) }}</span>
    @endif
@endforeach
```

## In PHP/Controllers

### Create Translatable Content with Auto-Translation
```php
use App\Services\AutoTranslateService;

// In your controller
public function store(Request $request, AutoTranslateService $service)
{
    $validated = $request->validate([
        'title_mk' => 'required|string',
        'description_mk' => 'required|string',
    ]);

    // Create translations (auto-translates to EN and SQ)
    $translations = $service->createTranslatableData([
        'title' => $validated['title_mk'],
        'description' => $validated['description_mk'],
    ], 'mk', ['en', 'sq']);

    Activity::create([
        'title' => $translations['title'],
        'description' => $translations['description'],
    ]);
}
```

### Get Current Locale
```php
$locale = app()->getLocale(); // 'mk', 'en', or 'sq'
```

### Get All Supported Locales
```php
use LaravelLocalization;

$locales = LaravelLocalization::getSupportedLocales();
// Returns: ['mk' => [...], 'en' => [...], 'sq' => [...]]
```

### Generate Localized URLs
```php
use LaravelLocalization;

LaravelLocalization::getLocalizedURL('en')        // /en/current-page
LaravelLocalization::getLocalizedURL('sq')        // /sq/current-page
LaravelLocalization::getLocalizedURL('mk', null) // /mk/current-page
```

## Language Switcher Component

### Add to Header/Navbar
```blade
<!-- Simple version (dropdown) -->
@component('components.language-switcher') @endcomponent

<!-- Or use component syntax -->
<x-language-switcher />
```

Features:
- 🇲🇰 Macedonian
- 🇬🇧 English
- 🇦🇱 Albanian
- Automatic URL generation
- Current language highlighted

## Creating a New Translatable Model

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasTranslations;

    protected $fillable = ['title', 'description', 'price'];

    // Define translatable fields
    public array $translatable = ['title', 'description'];
}
```

### Create/Update with Translations
```php
Product::create([
    'title' => [
        'mk' => 'Македонски наслов',
        'en' => 'English Title',
        'sq' => 'Titulli në Shqip',
    ],
    'description' => [
        'mk' => 'Опис на македонски',
        'en' => 'English Description',
        'sq' => 'Përshkrim në Shqip',
    ],
    'price' => 99.99,
]);
```

## Translation Files

Location: `lang/{locale}.json`

```json
{
  "language": "English",
  "home": "Home",
  "activities": "Activities",
  "save": "Save",
  ...
}
```

Usage:
```blade
{{ __('home') }}        <!-- Uses current locale -->
{{ __('activities') }}  <!-- Auto-selects language -->
```

## Common Patterns

### Query Active Content in Current Locale
```php
$activities = Activity::active()->sorted()->get();

// Display with current locale translation
@foreach($activities as $activity)
    <h3>{{ $activity->getTranslation('title', app()->getLocale()) }}</h3>
    <p>{{ $activity->getTranslation('description', app()->getLocale()) }}</p>
@endforeach
```

### Create Form with Translation Support
```blade
<form action="{{ route('activities.store') }}" method="POST">
    @csrf
    
    <!-- Macedonian (required) -->
    <div class="form-group">
        <label>Title (Македонски) *</label>
        <input type="text" name="title_mk" required>
    </div>
    
    <!-- Auto-translate option -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="auto_translate" value="1" checked>
            Auto-translate to English & Albanian
        </label>
    </div>
    
    <!-- Submit -->
    <button type="submit">{{ __('save') }}</button>
</form>
```

### Middleware Usage

Routes are automatically wrapped with localization middleware:
```php
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
    // Routes here get language prefix automatically
    Route::get('/activities', 'ActivityController@index');
});
```

## Translation Services

### Auto-Translate Service
```php
use App\Services\AutoTranslateService;

$service = app(AutoTranslateService::class);

// Translate single text
$en = $service->translate('Здраво', 'mk', 'en'); // "Hello"

// Translate multiple fields
$translations = $service->translateFields([
    'title' => 'Активност',
    'description' => 'Опис на активност'
], 'mk', ['en', 'sq']);

// Create complete translation structure
$data = $service->createTranslatableData([
    'title' => 'My Activity'
], 'en', ['mk', 'sq']);
```

## Troubleshooting

### Language not switching?
```php
// Check current locale
dd(app()->getLocale());

// Check if URL has locale prefix
// Should be /en/page not /page

// Clear cache
php artisan cache:clear
php artisan route:cache
```

### Translations not showing?
```php
// Verify translation exists
dump($activity->getTranslation('title', 'en'));

// Check model has trait
// Model should: use HasTranslations;

// Check translatable array
// Model should have: public array $translatable = ['title'];
```

### Auto-translation not working?
```php
// Check logs
tail -f storage/logs/laravel.log

// Verify internet connection (uses Google Translate API)
// Check if original text is empty

// Fallback: Use manual translation
Activity::create([
    'title' => [
        'mk' => 'Македонски',
        'en' => 'English',
        'sq' => 'Shqip'
    ]
]);
```

## Performance Tips

1. **Cache translations** - Use query caching
2. **Eager load** - Load translations with models
3. **Limit auto-translation** - Queue large translations
4. **Use route cache** - `php artisan route:cache`
5. **Store results** - Cache translated content

## Examples in Your Project

✅ **Activity Model** - `app/Models/Activity.php`
✅ **ActivityController** - `app/Http/Controllers/Admin/ActivityController.php`
✅ **Language Switcher** - `resources/views/components/language-switcher.blade.php`
✅ **Activities View** - `resources/views/public/activities.blade.php`
✅ **Translation Files** - `lang/{mk,en,sq}.json`

---
For complete documentation, see: `MULTI_LANGUAGE_GUIDE.md`
