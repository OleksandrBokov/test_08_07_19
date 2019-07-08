<?php

namespace Controllers;

use App;
use \Models\TaskModel;

class Index extends \App\Controller
{
    public function index()
    {
        $order = 'id';
        $page = 1;
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        }

        if (isset($_GET['order']) && !empty($_GET['order'])) {
            $order = $_GET['order'];
        }

        if (isset($_GET['Filter']) && !empty($_GET['Filter'])) {
            $filter_str = '';
            foreach ($_GET['Filter'] as $k => $v){
                if (!empty($v))
                    $filter_str .= $k.'="'.$v.'" and ';
            }
            if (strlen($filter_str) > 4) {
                $filter_str = substr($filter_str, 0, -4);
            }

            if (!empty($filter_str))
                $filter_str = ' WHERE '.$filter_str ?: '';
        }

        $tasksModel = new TaskModel();

        $tasks = $tasksModel->getTaskModelLimit($page, $order, $filter_str);

        $total = $tasksModel->getCountTasks($filter_str);
        $pagination = new \Models\Pagination($total, $page, TaskModel::SHOW_BY_DEFAULT, '');

        return $this->render('index',
            ['attributeLabels' => TaskModel::attributeLabels(), 'tasks' => $tasks, 'pagination' => $pagination]);
    }

    public function create()
    {
        if (!empty($_POST)) {

            if (!empty($_FILES) && $_FILES['img']['error'] === 0) {

                $img = $this->moveFile($_FILES);
            }

            $tasksModel = new TaskModel();
            $tasksModel->write($_POST, $img);
            header('Location: /index');
        }
        return $this->render('create', ['attributeLabels' => TaskModel::attributeLabels()]);
    }

    private function moveFile($files)
    {
        $img = 'images.png';
        $new_img = ROOTPATH . '/images/' . $files['img']['name'];
        copy($files['img']['tmp_name'], $new_img);
        if (is_file($new_img)) {
             $img = $_FILES['img']['name'];
        }

        return $img;
    }

    public function edit()
    {
        if (!empty($_GET['id'])) {

            $model = new TaskModel();
            $card = $model->getTaskModelById($_GET['id'])[0];
           
            if (!empty($_POST)) {
                foreach ($card as $k => $v) {
                    if (isset($_POST[$k])) {
                        $card[$k] = $_POST[$k];
                    }
                }

                if (!empty($_FILES) && $_FILES['img']['error'] === 0) {
                    $card['img'] = $this->moveFile($_FILES);
                }
                
                $model->update($card);
            }
            
            return $this->render('edit', ['card' => $card, 'attributeLabels' => TaskModel::attributeLabels()]);
        } else {
            header('Location: /index');
        }

    }

    public function delete()
    {
        if (isset($_GET['id'])) {
            $model = new TaskModel();
            if ($model->delete($_GET['id'])) {
                header("Location: /index");
            }
        }
    }

}