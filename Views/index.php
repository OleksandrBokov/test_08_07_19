<h1>Список CD</h1>
<?php
//echo "<pre>";
//print_r($_GET);
//echo "</pre>";die;
?>
<table>
    <form method="get">
    <tr>
        <?php
        array_walk($attributeLabels, function ($item, $key) {
            $order = $key;
            if (isset($_GET['order']) && $_GET['order'] === $key) {
                $order .= ' DESC';
            }
            echo '<td>';
//            echo '<a href="http://' . $_SERVER['HTTP_HOST'] . (isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : '') . '?order=' . $order . '">
//                ' . $item . '
//            </a>';
            echo '<a href="?'.http_build_query(array_merge($_GET, array("order"=>$order))).'">
                ' . $item . '
            </a>';
            if($key !== 'img')
                echo '<input value="'.(isset($_GET['Filter'][$key]) ? $_GET['Filter'][$key] : '').'" name="Filter['.$key.']"  type="text"></br>';
            echo '</td>';
        });
        ?>
    </tr>
    <tr><input value="Отфильтровать" type="submit"></tr>
    </form>
    <?php
    array_walk($tasks, function ($item) {
        echo '<tr>';
            echo '<td>';
            echo '<a href="http://' . $_SERVER['HTTP_HOST'] . '/images/' . $item['img'] . '">
                           <img width="75" src="http://' . $_SERVER['HTTP_HOST'] . '/images/' . $item['img'] . '">
                        </a>';
            echo '</td>';
            echo '<td>';
                echo $item['name'];
            echo '</td>';
            echo '<td>';
                echo $item['artist_name'];
            echo '</td>';
            echo '<td>';
                echo $item['year'];
            echo '</td>';
            echo '<td>';
                echo $item['duration'];
            echo '</td>';
            echo '<td>';
                echo $item['price'];
            echo '</td>';
            echo '<td>';
                echo $item['purchase_date'];
            echo '</td>';
            echo '<td>';
                if (!empty($item['storage_code'])) {
                    $location = explode(':', $item['storage_code']);
                    echo 'Номер комнаты: ' . $location[0] . '</br> Номер стойки: ' . $location[1] . '</br> Номер полки: ' . $location[2];

                } else {
                    echo '-';
                }
             echo '</td>';
            echo '<td>';
                echo '<a href="http://' . $_SERVER['HTTP_HOST'] . '/index/edit/?id=' . $item['id'] . '">
                                           Редактировать
                                        </a></br>';
                echo '<a href="http://' . $_SERVER['HTTP_HOST'] . '/index/delete/?id=' . $item['id'] . '">
                                   Удалить
                                </a>';
            echo '</td>';
        echo '</tr>';
    });
    ?>

</table>
</br>
<div class="pagination" style="margin-left:20%;"><?php echo $pagination->get(); ?></div>

