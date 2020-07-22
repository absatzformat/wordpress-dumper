# Dumper

Dump PHP vars to JS console

Usage:

[shorthand]
```
_dump($var1, $var2, ...);
```

[elaborated]
```
Absatzformat\Wordpress\Dumper\Dumper::dump($var);
```
or
```
$dumper = Absatzformat\Wordpress\Dumper\Dumper::getInstance();
$dumper->backtraceLevel = 1;
$dumper->dump($var);
```