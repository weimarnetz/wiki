wiki
====

addons and extensions to wireless.subsignal.org

Setup instructions
------------------

* copy content of skins and extensions directory to the mediawiki dir
* maybe check newer versions for bootstrap extension and chameleon theme
* copy wn-theme.less and wn-variables.less to mediawiki base dir, those files contain colours and designs
* add the following lines to LocalSettings.php

```php
//bootstrap extension, required for design
require_once( "$IP/extensions/Bootstrap/Bootstrap.php" );
//chameleon skin, a bootstrap based skin
require_once( "$IP/skins/chameleon/chameleon.php" );
Bootstrap::getBootstrap()->addExternalModule( __DIR__ , 'wn-variables.less' );
Bootstrap::getBootstrap()->addExternalModule( __DIR__ , 'wn-theme.less' );
```
* change default theme in LocalSettings.php
