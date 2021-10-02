# roblox-name-colors-php
Computes Roblox name colors (in PHP!)

## Usage
### Installation
```bash
composer require orcfoss/roblox-name-colors
```

### Documentation
```php
use \ORCFoss\RobloxNameColors;

RobloxNameColors::compute("reesemcblox"); // "[ 'red' => 1, 'green' => 162, 'blue' => 255, 'describer' => 'blue' ]"
RobloxNameColors::compute("reesemcblox", true, false); // "[ 'red' => 13, 'green' => 105, 'blue' => 172, 'describer' => 'blue' ]"
RobloxNameColors::compute("reesemcblox", false, false); // "0d69ac"

RobloxNameColors::describedBy("old red"); // "[ 'red' => 196, 'green' => 40, 'blue' => 28, 'describer' => 'red']"
```

More detailed documentation is available on the [repository's GitHub wiki.](https://github.com/orcfoss/roblox-name-colors-php/wiki)

## roblox-name-colors in Other Languages
- [JavaScript (node.js)](https://github.com/orcfoss/roblox-name-colors)

## License
roblox-name-colors-php is licensed under the MIT license. A copy of the license [has been included](https://github.com/orcfoss/roblox-name-colors-php/blob/trunk/LICENSE) with roblox-name-colors-php.