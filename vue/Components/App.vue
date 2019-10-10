<template>
  <div id="task-list">
    <h1>Task list</h1>

    <div id="filter">
      <form>
        <div class="row">
          <div class="columns medium-3">
            <label
              for="filter-complete"
            >Filter</label>
            <select
              id="filter-complete"
              v-model="filter.completed"
            >
              <option :value="null">
                All tasks
              </option>
              <option :value="false">
                Pending
              </option>
              <option :value="true">
                Completed
              </option>
            </select>
          </div>
          <div class="columns medium-3">
            <label for="sorting">Sort</label>
            <select
              id="sorting"
              v-model="sort"
              @change="sortTasks"
            >
              <option value="created">
                Created
              </option>
              <option value="completed">
                Completed
              </option>
            </select>
          </div>
          <div class="columns medium-6">
          </div>
        </div>
      </form>
    </div>

    <div class="row">
      <div class="columns medium-12">
        <task
          v-for="task in filteredTasks"
          :key="task.id"
          :task="task"
          @toggleComplete="toggleComplete"
        />
      </div>
    </div>
  </div>
</template>

<script>
import Axios from 'axios';
import Task from './Task.vue';

export default {
  name: 'App',
  components: {
    Task
  },
  data () {
    return {
      tasks: null,
      filter: {
        completed: null
      },
      sort: 'created'
    };
  },
  computed: {
    filteredTasks () {
      if (this.filter.completed === true) {
        return this.tasks.filter(task => task.is_complete === true);
      } else if (this.filter.completed === false) {
        return this.tasks.filter(task => task.is_complete === false);
      }

      return this.tasks;
    }
  },
  mounted () {
    const component = this;

    Axios.get(
      '/api/tasks/list',
      {
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          Accept: 'application/json'
        }
      })
      .then(function (response) {
        if (response.status === 200) {
          component.tasks = response.data.tasks;
        } else {
          alert(response.statusText);
        }
      })
      .catch(function (error) {
        alert(error.message);
      });
  },
  methods: {
    toggleComplete (payload) {
      const component = this;
      const taskIndex = component.tasks.findIndex(task => task.id === payload.id);
      const task = this.tasks[taskIndex];

      Axios.post(
        '/api/tasks/set-complete',
        {
          id: payload.id,
          complete: !task.is_complete
        },
        {
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            Accept: 'application/json'
          }
        })
        .then(function (response) {
          if (response.data.success) {
            const updatedTask = response.data.task;

            component.tasks[taskIndex].is_complete = updatedTask.is_complete;
            component.tasks[taskIndex].completed = updatedTask.completed;
            component.tasks[taskIndex].completed_ago_in_words = updatedTask.completed_ago_in_words;
          }
        })
        .catch(function (error) {
          alert(error.message);
        });
    },
    sortTasks () {
      const sortByCreated = function (a, b) {
        return new Date(a.created) - new Date(b.created);
      };

      const sortByCompleted = function (a, b) {
        return new Date(a.completed) - new Date(b.completed);
      };

      if (this.sort === 'created') {
        return this.tasks.sort(sortByCreated);
      } else if (this.sort === 'completed') {
        return this.tasks.sort(sortByCompleted);
      }

      return this.tasks;
    }
  }
};
</script>

<style scoped lang="scss">
  #task-list {
    margin: 0 15px;
  }
</style>
