# Pollus - Improved Session
An session wrapper object that extends the default PHP Session and improves its methods by handling cookies and provides a better session constructor.

This class is an implementation of **SessionInterface** from [SessionWrapper package](https://github.com/renancavalieri/pollus-session-wrapper).

**Usage:**

```composer require pollus/improved-session```

```php
require_once (__DIR__."/../vendor/autoload.php");

use Pollus\ImprovedSession\ImprovedSession;

// Default options, can be omitted
$options = [

    // How much should the session last in minutes without user activity? (in minutes)
    'lifetime'     => 60 * 24,

    // path, domain, secure, httponly: Options for the session cookie.
    'path'         => '/',
    'domain'       => null,
    'secure'       => false,
    'httponly'     => true,

    // name: Name for the session cookie. Defaults to PHPSESSID.
    'name'         => "PHPSESSION",

    // autorefresh: true if you want session to be refresh when user activity is made.
    'autorefresh'  => true,

    // ini_settings: Associative array of custom session configuration.
    'ini_settings' => [],
];

$session = new ImprovedSession($options);
$session->start();
$session->set("str_test", "Hello World");
```

# MIT License

Copyright (c) 2019 Renan Cavalieri

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.