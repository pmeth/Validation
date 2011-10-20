<?php

namespace Respect\Validation\Rules;

class Cnpj extends AbstractRule 
{
    public function validate($input) 
    {
        // Ported from JSFromHell
        $c = preg_replace('([^0-9])', '', $input);
        $b = array(6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2);
        if (strlen($c) != 14) return false;
        for ($i = 0, $n = 0; $i < 12; $n += $c[$i] * $b[++$i]);
        if ($c[12] != ((($n %= 11) < 2) ? 0 : 11 - $n)) return false;
        for ($i = 0, $n = 0; $i <= 12; $n += $c[$i] * $b[$i++]);
        if ($c[13] != ((($n %= 11) < 2) ? 0 : 11 - $n)) return false;
        return true;
    }
}