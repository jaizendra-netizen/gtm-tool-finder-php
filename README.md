# gtm-tool-finder (PHP)

Search the [OneGTMLab](https://www.onegtmlab.dev) GTM tool directory from PHP or your terminal:

- API reviews for 66 sales and marketing tools: pricing, rate limits, keys and MCP support
- 99 head-to-head tool comparisons, such as Apollo vs Clay
- 110 plain-English definitions of GTM terms

```bash
composer require onegtmlab/gtm-tool-finder
vendor/bin/gtm-tool-finder apollo
vendor/bin/gtm-tool-finder --kind comparison clay
```

```php
use OneGTMLab\GtmToolFinder\Finder;

foreach (Finder::search('enrichment', 'Tool') as $r) {
    echo $r['name'], ' ', $r['url'], PHP_EOL;
}
```

Every result links to the full page on [onegtmlab.dev/tool-directory](https://www.onegtmlab.dev/tool-directory). The list ships inside the package, so it works offline and sends no data anywhere.

Also available as a [Python package](https://pypi.org/project/gtm-tool-finder/), a [Ruby gem](https://rubygems.org/gems/gtm-tool-finder) and a [Go module](https://pkg.go.dev/github.com/jaizendra-netizen/gtm-tool-finder-go). Built by [OneGTMLab](https://www.onegtmlab.dev), a GTM engineering agency. MIT licensed.
