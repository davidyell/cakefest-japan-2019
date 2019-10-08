<?php
/**
 * TasksController
 *
 * Copyright (c) 2019 UK Web Media Ltd.
 *
 * @package App\Controller
 * @author David Yell <dyell@ukwebmedia.com>
 */
declare(strict_types=1);

namespace App\Controller;

/**
 * @property \App\Model\Table\TasksTable Tasks
 */
class TasksController extends AppController
{
    /**
     * Initialize the controller
     *
     * @throws \Exception If a component cannot be loaded
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Paginator');
    }

    /**
     * List the tasks
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $tasks = $this->Tasks->find();

        $this->set('tasks', $this->Paginator->paginate($tasks));
    }

    /**
     * An empty method to start the Vue.js application
     *
     * @return void
     */
    public function vue()
    {
    }
}
