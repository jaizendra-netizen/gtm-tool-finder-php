<?php

declare(strict_types=1);

namespace OneGTMLab\GtmToolFinder;

/**
 * Search the OneGTMLab GTM tool directory (https://www.onegtmlab.dev/tool-directory).
 * The list ships inside the package, so it works offline and sends no data anywhere.
 */
final class Finder
{
    public const KINDS = ['Tool', 'Category', 'Comparison', 'Glossary'];

    /** @var array<int, array{name:string,kind:string,url:string,description:string}>|null */
    private static ?array $entries = null;

    /** Every entry as an array with name, kind, url and description. */
    public static function all(): array
    {
        if (self::$entries === null) {
            $raw = json_decode((string) file_get_contents(__DIR__ . '/data.json'), true, 512, JSON_THROW_ON_ERROR);
            self::$entries = array_map(static fn (array $r): array => [
                'name' => $r['n'], 'kind' => $r['k'], 'url' => $r['u'], 'description' => $r['d'],
            ], $raw);
        }
        return self::$entries;
    }

    /** Entries whose name or description contains every word of the query. */
    public static function search(string $query = '', ?string $kind = null, int $limit = 20): array
    {
        $words = preg_split('/\s+/', strtolower(trim($query)), -1, PREG_SPLIT_NO_EMPTY);
        $hits = [];
        foreach (self::all() as $i => $e) {
            if ($kind !== null && strcasecmp($e['kind'], $kind) !== 0) {
                continue;
            }
            $text = strtolower($e['name'] . ' ' . $e['description']);
            foreach ($words as $w) {
                if (strpos($text, $w) === false) {
                    continue 2;
                }
            }
            $first = ($words && strpos(strtolower($e['name']), $words[0]) === 0) ? 0 : 1;
            $k = array_search($e['kind'], self::KINDS, true);
            $hits[] = [$first, $k === false ? 9 : $k, $i, $e];
        }
        usort($hits, static fn (array $a, array $b): int => [$a[0], $a[1], $a[2]] <=> [$b[0], $b[1], $b[2]]);
        return array_map(static fn (array $h): array => $h[3], array_slice($hits, 0, $limit));
    }
}
