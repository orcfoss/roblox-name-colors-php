<?php
declare(strict_types=1);
namespace ORCFoss\RobloxNameColors;

/**
 * Class RobloxNameColors
 * @package ORCFoss\RobloxNameColors
 */
class robloxnamecolors
{
    /** The base name color palette. */
    const BASE_PALETTE = [
        [ "red" => 107, "green" => 50,  "blue" => 124, "describer" => "purple" ],
        [ "red" => 218, "green" => 133, "blue" => 65,  "describer" => "orange" ],
        [ "red" => 245, "green" => 205, "blue" => 48,  "describer" => "yellow" ],
        [ "red" => 232, "green" => 186, "blue" => 200, "describer" => "purple" ],
        [ "red" => 215, "green" => 197, "blue" => 154, "describer" => "tan"    ]
    ];

    /** The modern name color palette (2014+). */
    const MODERN_PALETTE = [
        [ "red" => 253, "green" => 41,  "blue" => 67,  "describer" => "red"   ],
        [ "red" => 1,   "green" => 162, "blue" => 255, "describer" => "blue"  ],
        [ "red" => 2,   "green" => 184, "blue" => 87,  "describer" => "green" ]
    ];

    /** The older name color palette (2006-2014). */
    const OLD_PALETTE = [
        [ "red" => 196, "green" => 40,  "blue" => 28,  "describer" => "red"   ],
        [ "red" => 13,  "green" => 105, "blue" => 172, "describer" => "blue"  ],
        [ "red" => 39,  "green" => 70,  "blue" => 45,  "describer" => "green" ]
    ];

    /**
     * A modulus function, in accordance with Lua spec.
     * 
     * @param int $a
     * @param int $b
     * 
     * @return int|float Modulo of a and b.
     */
    private static function mod($a, $b): int|float
    {
        return ($a - floor($a / $b) * $b);
    }

    /**
     * Converts a name color to a hexadecimal value.
     * 
     * @param array $color Computed name color array with "red", "green", and "blue" keys.
     * 
     * @return string Computed name color hex code.
     */
    private static function hex($color): string
    {
        return substr(base_convert((1 << 24) + ($color["red"] << 16) + ($color["green"] << 8) + $color["blue"], 10, 16), 1);
    }

    /**
     * Computes a name color.
     * 
     * @param string $text Text to compute a name color out of.
     * @param bool $rgb Whether to return the color represented as an array with "red", "green", and "blue" keys, or to return it as a hexadecimal color code. (default: true)
     * @param bool $useModernPalette Whether to use the modern color palette. (default: true)
     * 
     * @return array|string Computed name color array with "red", "green", and "blue" keys representing red, green, and blue color values respectively.
     */
    public static function compute($text, $rgb = true, $useModernPalette = true): array|string
    {
        $palette = array_merge($useModernPalette ? self::MODERN_PALETTE : self::OLD_PALETTE, self::BASE_PALETTE);

        $val = 0;
        for ($i = 0; $i < strlen($text); $i++)
        {
            $cv = ord($text[$i]);
            $ri = strlen($text) - $i;

            if (self::mod(strlen($text), 2) == 1)
            {
                $ri--;
            }

            if (self::mod($ri, 4) >= 2)
            {
                $cv = -$cv;
            }

            $val += $cv;
        }
        
        $color = $palette[self::mod($val, count($palette))];
        return $rgb ? $color : self::hex($color);
    }

    /**
     * Finds a color in the name color palette by a short description (i.e. "modern bright red".)
     * 
     * @param string $describer Short description of the color.
     * @param bool $rgb Whether to return the color in an array with "red", "green", and "blue" keys. If this is false, it will return the color represented as a hexadecimal color code. (default: true)
     * @param null|boolean $useModernPalette Whether to use the modern color palette. If implicitly specified, this will override the describer when it comes to determening which palette to use. (default: true)
     * 
     * @return array|string|bool Returns the color, if found, in a RGB array or a hex color code (depending on rgb.) If a color couldn't be found, returns false.
     */
    public static function describedBy($describer, $rgb = true, $useModernPalette = null) : array|string|bool
    {
        $describer = strtolower($describer);

        $palette;
        if ($useModernPalette === null)
        {
            // Auto-determine
            $palette = str_contains($describer, "old") ? self::OLD_PALETTE : self::MODERN_PALETTE;
        }
        elseif ($useModernPalette === false)
        {
            // Old palette
            $palette = self::OLD_PALETTE;
        }
        else
        {
            // New palette
            $palette = self::MODERN_PALETTE;
        }

        $palette = array_merge($palette, self::BASE_PALETTE);
        $found = false;
        for ($i = 0; $i < count($palette); $i++)
        {
            if ($found) break;

            $split = explode(" ", $describer);
            for ($j = 0; $j < count($split); $j++)
            {
                if (str_contains($palette[$i]["describer"], $split[$j]))
                {
                    $found = $palette[$i];
                    break;
                }
            }
        }

        return $found ? ($rgb ? $found : self::hex($found)) : false;
    }
}