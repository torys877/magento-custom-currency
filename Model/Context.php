<?php
/*
 * Copyright © Ihor Oleksiienko (https://github.com/torys877)
 * See LICENSE for license details.
 */

namespace Crypto\Currency\Model;

class Context
{
    public static $stack = [false];
    public static $current = false;

    public static function push($status)
    {
        if ($status !== null) {
            self::$current = $status;
        }
        $curr = self::$current;
        self::$stack[] = $curr;

        //echo "Push [$status] to stack. Current = [$curr]<br/>";
        //var_dump(self::$stack);
    }

    public static function pop()
    {
        //var_dump(self::$stack);
        $result = array_pop(self::$stack);
        $current = end(self::$stack);
        self::$current = $current;
        return $result;
    }

    public static function current()
    {
        return self::$current;
    }

    public static function level()
    {
        return count(self::$stack) - 1;
    }
}
