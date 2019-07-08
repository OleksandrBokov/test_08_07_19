<?php

namespace App;

use App;

/**
 * Class Db
 * @package App
 */
class Db
{
    public $pdo;

    /**
     * Db constructor.
     */
    public function __construct()
    {
        $settings = $this->getPDOSettings();
        $this->pdo = new \PDO($settings['dsn'], $settings['user'], $settings['pass'], null);
    }

    /**
     * @return mixed
     */
    protected function getPDOSettings()
    {
        $config = include ROOTPATH.DIRECTORY_SEPARATOR.'Config'.DIRECTORY_SEPARATOR.'Db.php';
        $result['dsn'] = "{$config['type']}:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
        $result['user'] = $config['user'];
        $result['pass'] = $config['pass'];
        return $result;
    }

    /**
     * @param string $query
     * @param array|null $params
     * @return array
     */
    public function execute($query, array $params=null)
    {
        if (is_null($params)) {
            $stmt = $this->pdo->query($query);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}