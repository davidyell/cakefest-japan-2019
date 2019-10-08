<?php
/**
 * TasksController
 *
 * Copyright (c) 2019 UK Web Media Ltd.
 *
 * @package App\Controller\Api
 * @author David Yell <dyell@ukwebmedia.com>
 */
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AppController;

/**
 * @property \App\Model\Table\TasksTable Tasks
 */
class TasksController extends AppController
{
    /**
     * List the tasks as JSON
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $tasks = $this->Tasks->find();

        $this->set('tasks', $tasks);
        $this->set('_serialize', ['tasks']);
    }

    public function complete(int $id)
    {

    }
}
