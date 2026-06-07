<?php

namespace App\Helpers;

class LocalizedContent
{
    public static function locales(): array
    {
        return ['mk', 'en', 'sq'];
    }

    /**
     * @return array{mk: string, en: string, sq: string}
     */
    public static function normalize(mixed $value, string $defaultMk = ''): array
    {
        if (is_array($value) && array_key_exists('mk', $value)) {
            return [
                'mk' => (string) ($value['mk'] ?? ''),
                'en' => (string) ($value['en'] ?? ''),
                'sq' => (string) ($value['sq'] ?? ''),
            ];
        }

        $mk = is_string($value) ? $value : $defaultMk;

        return ['mk' => $mk, 'en' => '', 'sq' => ''];
    }

    public static function pick(mixed $value, ?string $locale = null, string $defaultMk = ''): string
    {
        $normalized = self::normalize($value, $defaultMk);
        $locale = $locale ?? app()->getLocale();

        foreach ([$locale, 'mk', 'en', 'sq'] as $candidate) {
            if (($normalized[$candidate] ?? '') !== '') {
                return $normalized[$candidate];
            }
        }

        return '';
    }

    /**
     * @param  array{mk?: string, en?: string, sq?: string}|null  $existing
     * @return array{mk: string, en: string, sq: string}
     */
    public static function fromRequest(?string $mk, ?string $en, ?string $sq, ?array $existing = null): array
    {
        $mk = trim((string) $mk);
        $en = trim((string) ($en ?? ''));
        $sq = trim((string) ($sq ?? ''));

        if ($en === '') {
            $en = trim((string) ($existing['en'] ?? ''));
        }

        if ($sq === '') {
            $sq = trim((string) ($existing['sq'] ?? ''));
        }

        if ($en === '' && $mk !== '') {
            $en = $mk;
        }

        if ($sq === '' && $mk !== '') {
            $sq = $mk;
        }

        return ['mk' => $mk, 'en' => $en, 'sq' => $sq];
    }

    /**
     * @return array{mk: array<int, string>, en: array<int, string>, sq: array<int, string>}
     */
    public static function normalizeLines(mixed $value): array
    {
        if (is_array($value) && array_key_exists('mk', $value)) {
            return [
                'mk' => self::sanitizeLines($value['mk'] ?? []),
                'en' => self::sanitizeLines($value['en'] ?? []),
                'sq' => self::sanitizeLines($value['sq'] ?? []),
            ];
        }

        $lines = self::sanitizeLines(is_array($value) ? $value : self::splitLines((string) $value));

        return ['mk' => $lines, 'en' => [], 'sq' => []];
    }

    /**
     * @return array<int, string>
     */
    public static function pickLines(mixed $value, ?string $locale = null): array
    {
        $normalized = self::normalizeLines($value);
        $locale = $locale ?? app()->getLocale();

        foreach ([$locale, 'mk', 'en', 'sq'] as $candidate) {
            if (($normalized[$candidate] ?? []) !== []) {
                return $normalized[$candidate];
            }
        }

        return [];
    }

    /**
     * @param  array<int, string>  $mkLines
     * @param  array<int, string>  $enLines
     * @param  array<int, string>  $sqLines
     * @param  array{mk?: array<int, string>, en?: array<int, string>, sq?: array<int, string>}|null  $existing
     * @return array{mk: array<int, string>, en: array<int, string>, sq: array<int, string>}
     */
    public static function linesFromRequest(array $mkLines, array $enLines, array $sqLines, ?array $existing = null): array
    {
        $mkLines = self::sanitizeLines($mkLines);
        $enLines = self::sanitizeLines($enLines);
        $sqLines = self::sanitizeLines($sqLines);

        if ($enLines === [] && $existing !== null) {
            $enLines = self::sanitizeLines($existing['en'] ?? []);
        }

        if ($sqLines === [] && $existing !== null) {
            $sqLines = self::sanitizeLines($existing['sq'] ?? []);
        }

        if ($enLines === [] && $mkLines !== []) {
            $enLines = $mkLines;
        }

        if ($sqLines === [] && $mkLines !== []) {
            $sqLines = $mkLines;
        }

        return [
            'mk' => $mkLines,
            'en' => $enLines,
            'sq' => $sqLines,
        ];
    }

  /**
     * @return array<int, string>
     */
    public static function splitLines(?string $text): array
    {
        $lines = preg_split('/\r\n|\r|\n/', (string) $text);
        $out = [];

        if (! is_array($lines)) {
            return $out;
        }

        foreach ($lines as $line) {
            $line = trim((string) $line);

            if ($line !== '') {
                $out[] = $line;
            }
        }

        return $out;
    }

    public static function linesToText(array $lines): string
    {
        return implode("\n", self::sanitizeLines($lines));
    }

    /**
     * @param  mixed  $lines
     * @return array<int, string>
     */
    private static function sanitizeLines(mixed $lines): array
    {
        if (! is_array($lines)) {
            return self::splitLines((string) $lines);
        }

        $out = [];

        foreach ($lines as $line) {
            $line = trim((string) $line);

            if ($line !== '') {
                $out[] = $line;
            }
        }

        return array_values($out);
    }
}
