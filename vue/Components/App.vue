<template>
    <div id="task-list">
      <h1>Task list</h1>
      <task :task="task" v-for="task in tasks" :key="task.id" @toggleComplete="toggleComplete"></task>
    </div>
</template>

<script>
  import Axios from 'axios';
  import Task from './Task.vue';

  export default {
    name: "App",
    components: {
      Task
    },
    data () {
      return {
        tasks: null
      }
    },
    mounted() {
      const component = this;

      Axios.get(
        '/api/tasks/list',
        {
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
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
  }
</script>

<style scoped lang="scss">
  #task-list {
    margin: 0 15px;
  }
</style>
