<?php
function countSistersForBrother($n, $m) {
    // если количество братьев равно нулю, вернуть 0
    if ($m == 0) {
        return 0;
    }
    
    // любой брат Алисы видит всех ее сестер
    return $n;
}

$n = 5; // количество сестер
$m = 3; // количество братьев
echo "Количество сестер для брата Алисы: " . countSistersForBrother($n, $m);
?>