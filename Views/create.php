<form enctype="multipart/form-data" method="POST"  action="/index/create">
    <p><b>Добавить запись</b></p>
    <p>
        <?php
        array_walk($attributeLabels, function ($item, $key) {

            switch ($key) {
                case 'img':
                    echo '<input type="file" name="' . $key . '" >' . $item . '</br>';
                    break;
                case 'price':
                case 'duration':
                    echo '<input type="number" min="1" name="' . $key . '" >' . $item . '</br>';
                    break;
                case 'year':
                case 'purchase_date':
                    echo '<input type="date" data-date-format="YYYY.MMMM.DD" name="' . $key . '" >' . $item . '</br>';
                    break;
                default:
                    echo '<input type="text" name="' . $key . '" >' . $item . '</br>';
            }
        });
        ?>
    </p>
    <p><input type="submit"></p>
</form>