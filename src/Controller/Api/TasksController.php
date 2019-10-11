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
use Cake\Http\Exception\NotFoundException;
use Cake\I18n\FrozenTime;

/**
 * @property \App\Model\Table\TasksTable Tasks
 */
class TasksController extends AppController
{
    /**
     * List the tasks as JSON
     *
     * @return void
     */
    public function index()
    {
        $tasks = $this->Tasks->find()
            ->order([
                'completed' => 'asc'
            ]);

        $this->set('tasks', $tasks);
        $this->set('_serialize', ['tasks']);
    }

    /**
     * Toggle the completed state of a task
     *
     * @return void
     */
    public function setComplete()
    {
        $this->getRequest()->allowMethod('patch');

        $complete = $this->getRequest()->getData('complete');
        $id = (int)$this->getRequest()->getData('id');
        if ($id === false) {
            throw new \BadMethodCallException('Missing required id field');
        }

        $task = $this->Tasks->get($id);

        if (!$task) {
            throw new NotFoundException('Task cannot be found');
        }

        if ($complete) {
            $task->set('is_complete', true);
            $task->set('completed', new FrozenTime());
        } else {
            $task->set('is_complete', false);
            $task->set('completed', null);
        }

        $success = false;
        if ($this->Tasks->save($task)) {
            $success = true;
        }

        $this->set('success', $success);
        $this->set('task', $task);
        $this->set('_serialize', ['success', 'task']);
    }

    /**
     * Add a new task
     *
     * @return void
     */
    public function add()
    {
        $this->getRequest()->allowMethod('post');

        $task = $this->Tasks->patchEntity($this->Tasks->newEntity(), $this->getRequest()->getData());
        $task->set('is_complete', false);

        $success = false;
        if ($this->Tasks->save($task)) {
            $success = true;
        }

        $this->set('success', $success);
        $this->set('task', $task);
        $this->set('_serialize', ['success', 'task']);
    }
}
