<?php
$data = [
    ['Иванов', 'Математика', 5],
    ['Иванов', 'Математика', 4],
    ['Иванов', 'Математика', 5],
    ['Петров', 'Математика', 5],
    ['Сидоров', 'Физика', 4],
    ['Иванов', 'Физика', 4],
    ['Петров', 'ОБЖ', 4],
];

// массив для хранения результатов
$results = [];

// суммирование баллов
foreach ($data as [$name, $subject, $score]) {
    $results[$name][$subject] = ($results[$name][$subject] ?? 0) + $score;
}

// список всех предметов
$subjects = [];
foreach ($data as [, $subject]) {
    $subjects[$subject] = true;
}
$subjects = array_keys($subjects);
sort($subjects); // сортировка

// сортировка школьников по именам
ksort($results);

// вывод таблицы
echo '<table border="1">';
echo '<tr><th></th>';
foreach ($subjects as $subject) {
    echo "<th>$subject</th>";
}
echo '</tr>';

foreach ($results as $name => $scores) {
    echo '<tr>';
    echo "<td>$name</td>";
    foreach ($subjects as $subject) {
        echo '<td>' . ($scores[$subject] ?? '') . '</td>';
    }
    echo '</tr>';
}
echo '</table>';
?>