<form enctype="multipart/form-data" method="POST"  action="/index/edit?id=<?= $_GET['id']?>" >
    <p><b>Добавить запись</b></p>
    <p>
        <?php
        array_walk($attributeLabels, function ($item, $key) use ($card) {

            switch ($key) {
                case 'img':
                    echo '<img width="75" src="http://' . $_SERVER['HTTP_HOST'] . '/images/' . $card[$key] . '"></br><input type="file" name="' . $key . '" >' . $item . '</br>';
                    break;
                case 'price':
                    echo '<input type="number" min="1" value="'.$card[$key].'" name="' . $key . '" >' . $item . '</br>';
                    break;
                case 'duration':
                    echo '<input type="number" min="1" value="'.$card[$key].'" name="' . $key . '" >' . $item . '</br>';
                    break;
                case 'year':
                    echo '<input type="date" value="'.$card[$key].'" name="' . $key . '" >' . $item . '</br>';
                    break;
                case 'purchase_date':
                    echo '<input type="date" value="'.$card[$key].'" name="' . $key . '" >' . $item . '</br>';
                    break;
                default:
                    echo '<input type="text" value="'.$card[$key].'" name="' . $key . '" >' . $item . '</br>';
            }
        });
        ?>
    </p>
    <p><input type="submit"></p>
</form>