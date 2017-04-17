<?php

// Да простит меня мой учитель, за подобный говнокод,
// но мы изучаем DBA, и задача была найти способ заполнить базу
// БЫСТРО и ЛЕГКО минимум 1000 записей. Первое, что пришло в голову
// написать "скрипт". И этот код с этой задачей справляется.
// Конечно же, я могу написать хороший код, но на это
// требуется время.

$driver = 'mysql'; //pgsql
$user = 'root'; //postgres
$password = ''; //postgres

$dbh = new PDO($driver . ':host=localhost;dbname=dba', $user, $password);

// article, title, price, old_price, path_to_img, start_date, quantity

$sql = 'INSERT INTO goods 
        (article, title, price, old_price, path_to_img, start_date, quantity) 
        VALUES 
        (:article, :title, :price, :old_price, :path_to_img, :start_date, :quantity)';

$i = 1;
while ($i <= 10000) {

    $title = 'Товар № ' . $i;
    $article = str_pad($i, 10, '0', STR_PAD_LEFT);
    if (2 == mt_rand(1, 3)) {
        $old_price = null;
        $article = 'TEST' . substr($article, 4);
    } else {
        $old_price = mt_rand(1000000, 10000000);
    }
    $price = (null == $old_price) ? mt_rand(1000000, 10000000) : round($old_price - mt_rand(3, 10) * $old_price / 100);
    $path_to_img = 'http://here-is-a-picture.ru/images/img' . $i;
    $start_date = mt_rand(2010, 2016) . '-' . str_pad(mt_rand(1, 12), 2, '0', STR_PAD_LEFT) . '-' . str_pad(mt_rand(1, 28), 2, '0', STR_PAD_LEFT);
    $quantity = mt_rand(1, 50);

    $sth = $dbh->prepare($sql);
    $sth->execute([':article' => $article,
            ':title' => $title,
            ':price' => $price,
            ':old_price' => $old_price,
            ':path_to_img' => $path_to_img,
            ':start_date' => $start_date,
            ':quantity' => $quantity,
    ]);

    $i++;
}
