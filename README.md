# fa-search

A new search engine to replace furaffinity's search

## Running Tests

Obviously you're first going to need to [install PHP](https://www.php.net/manual/en/install.php)
on your system if you haven't done so yet.

Next, you'll need some dependencies.
[Install composer](https://getcomposer.org/doc/00-intro.md), then run:
```bash
composer install
```

Install and enable either [Xdebug](https://xdebug.org/docs/install) or [PCOV](https://github.com/krakjoe/pcov/blob/release/INSTALL.md) to get coverage data.

Now that everything is set up to test, run the test with:
```bash
./vendor/bin/phpunit
```

Look in the coverage folder for what's covered and what's not
