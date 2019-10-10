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
              <option value="completed">
                Completed
              </option>
              <option value="created">
                Created
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

    <div class="row">
      <div class="columns medium-12">
        <new-task @addTask="addTask"></new-task>
      </div>
    </div>
  </div>
</template>

<script>
import Axios from 'axios';
import Task from './Task.vue';
import NewTask from './NewTask.vue';

export default {
  name: 'App',
  components: {
    Task,
    NewTask
  },
  data () {
    return {
      filter: {
        completed: null
      },
      sort: 'completed'
    };
  },
  computed: {
    filteredTasks () {
      if (this.filter.completed === true) {
        return this.$store.state.tasks.filter(task => task.is_complete === true);
      } else if (this.filter.completed === false) {
        return this.$store.state.filter(task => task.is_complete === false);
      }

      return this.$store.state.tasks;
    }
  },
  created () {
    this.$store.dispatch('fetchTasks');
  },
  methods: {
    toggleComplete (payload) {
      this.$store.commit('setComplete', payload);
    },
    sortTasks () {
      this.$store.commit('sortTasks', this.sort);
    },
    addTask (payload) {
      const component = this;

      Axios.post(
        '/api/tasks/add',
        {
          name: payload.task,
          created: payload.created.format('YYYY-MM-DD HH:mm:ss'),
          modified: payload.created.format('YYYY-MM-DD HH:mm:ss')
        },
        {
          headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' }
        })
        .then(function (response) {
          if (response.data.success) {
            component.tasks.push(response.data.task);
          }
        })
        .catch(function (error) {
          alert(error.message);
        });
    }
  }
};
</script>

<style scoped lang="scss">
  #task-list {
    margin: 0 15px;
  }
  #new-task {
    margin-top: 20px;
  }
</style>
