# WordPress Dumper

Dump PHP variables to JavaScript console in WordPress.

## Usage

### Shorthand

```php
_dump($var1, $var2, ...);
```

### Elaborated

```php
Absatzformat\Wordpress\Dumper\Dumper::dump($var);
```
or
```php
$dumper = Absatzformat\Wordpress\Dumper\Dumper::getInstance();
$dumper->backtraceLevel = 1;
$dumper->dump($var);
```