<template>
  <div id="task-list">
    <h1>Task list</h1>

    <div id="filter">
      <form>
        <div class="row">
          <div class="columns medium-3">
            <label
              for="filter-complete"
            >Filter tasks</label>
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
          <div class="columns medium-9">&nbsp;</div>
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
      }
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
      const taskIndex = this.tasks.findIndex(task => task.id === payload.id);
      this.tasks[taskIndex].is_complete = !this.tasks[taskIndex].is_complete;
    }
  }
};
</script>

<style scoped lang="scss">
  #task-list {
    margin: 0 15px;
  }
</style>
