<?php

namespace Models;

use App;
use PDO;

class TaskModel
{
    const SHOW_BY_DEFAULT = 3;

    protected $tasks;
    protected $db;
    private $table_name = 'cards';

    public function __construct()
    {
        $this->db = new App::$db();
    }

    static public function attributeLabels()
    {
        return array(
            'img' => 'Обложка альбома',
            'name' => 'Название альбома',
            'artist_name' => 'Название артиста',
            'year' => 'Год выпуска',
            'duration' => 'Длительность альбома (минут)',
            'price' => 'Стоимость покупки',
            'purchase_date' => 'Дата покупки',
            'storage_code' => 'Код хранилища',
        );
    }

    public function getAllTaskModel()
    {
        $this->tasks = $this->db->execute('SELECT * FROM '.$this->table_name);
        return $this->tasks;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getTaskModelById($id)
    {
        return $this->db->execute('SELECT * FROM '.$this->table_name.' WHERE id = :id', [':id'=>$id]);
    }

    /**
     * @param $fields
     * @param $img
     */
    public function write($fields, $img)
    {
        $sql =  'INSERT INTO `'.$this->table_name.'`(`name`, `img`, `artist_name`, `year`, `duration`, `purchase_date`, `price`, `storage_code`) 
                    VALUES (:name, :img, :artist_name, :year, :duration, :purchase_date, :price, :storage_code)';
        $result = $this->db->pdo->prepare($sql);

        $result->bindParam(':name', $fields['name'], \PDO::PARAM_STR);
        $result->bindParam(':img', $img, \PDO::PARAM_STR);
        $result->bindParam(':artist_name', $fields['artist_name'], \PDO::PARAM_STR);
        $result->bindParam(':year', $fields['year'], \PDO::PARAM_STR);
        $result->bindParam(':duration', $fields['duration'], \PDO::PARAM_INT);
        $result->bindParam(':purchase_date', $fields['purchase_date'], \PDO::PARAM_STR);
        $result->bindParam(':price', $fields['price'], \PDO::PARAM_INT);
        $result->bindParam(':storage_code', $fields['storage_code'], \PDO::PARAM_STR);
        $result->execute();
        //return $result->lastInsertId();
    }

    /**
     * @param $card
     */
    public function update($card)
    {

        $sql =  'UPDATE `'.$this->table_name.'` SET 
                `name`= :name,
                `img`= :img, 
                `artist_name`= :artist_name, 
                `year`= :year, 
                `duration`= :duration, 
                `purchase_date`= :purchase_date, 
                `price`= :price, 
                `storage_code`= :storage_code 
                WHERE id = :id';
        $result = $this->db->pdo->prepare($sql);

        $result->bindParam(':name', $card['name'], \PDO::PARAM_STR);
        $result->bindParam(':img', $card['img'], \PDO::PARAM_STR);
        $result->bindParam(':artist_name', $card['artist_name'], \PDO::PARAM_STR);
        $result->bindParam(':year', $card['year'], \PDO::PARAM_STR);
        $result->bindParam(':duration', $card['duration'], \PDO::PARAM_INT);
        $result->bindParam(':purchase_date', $card['purchase_date'], \PDO::PARAM_STR);
        $result->bindParam(':price', $card['price'], \PDO::PARAM_INT);
        $result->bindParam(':storage_code', $card['storage_code'], \PDO::PARAM_STR);
        $result->execute();

//        echo "<pre>";
//        print_r($result->errorInfo());
//        echo "</pre>";die;
    }

    public function getTaskModelLimit($page = 1, $order = 'id', $filter_str='')
    {
        $limit = self::SHOW_BY_DEFAULT;
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;

        $sql = 'SELECT * FROM '.$this->table_name. $filter_str.' ORDER BY '.$order.' LIMIT :limit OFFSET :offset ';
        $result = $this->db->pdo->prepare($sql);
        $result->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $result->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $result->execute();

        $tasks = $result->fetchAll(PDO::FETCH_ASSOC);

        return $tasks;
    }

    public function getCountTasks($filter_str='')
    {
        $sql = 'SELECT count(id) AS cnt FROM `'.$this->table_name.'` '. $filter_str;
        $result = $this->db->pdo->prepare($sql);
        $result->execute();
        $row = $result->fetch();
        return $row['cnt'];
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM '.$this->table_name.' WHERE id =  :id';
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
        
    }
}