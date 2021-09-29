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

Now that everything is set up to test, run the test with:
```bash
./vendor/bin/phpunit
```

If you want to generate coverage, first install and enable either [Xdebug](https://xdebug.org/docs/install) or [pcov](https://github.com/krakjoe/pcov/blob/release/INSTALL.md)

Then run:
```bash
./vendor/bin/phpunit --coverage-text
```
or
```bash
./vendor/bin/phpunit --coverage-html ./coverage/
```
and look in the coverage folder for what's covered
