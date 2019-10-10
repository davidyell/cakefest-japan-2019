import Vue from 'vue';
import Vuex from 'vuex';
import Axios from 'axios';
import moment from 'moment';

Vue.use(Vuex);

export const store = new Vuex.Store({
  state: {
    tasks: []
  },
  mutations: {
    setComplete (state, payload) {
      const taskIndex = state.tasks.findIndex(task => task.id === payload.id);
      const task = state.tasks[taskIndex];

      Axios.patch(
        '/api/tasks/set-complete/' + task.id,
        {
          id: payload.id,
          complete: !task.is_complete
        },
        {
          headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' }
        })
        .then(function (response) {
          if (response.data.success) {
            const updatedTask = response.data.task;

            state.tasks[taskIndex].is_complete = updatedTask.is_complete;
            state.tasks[taskIndex].completed = updatedTask.completed;
            state.tasks[taskIndex].completed_ago_in_words = updatedTask.completed_ago_in_words;
          }
        })
        .catch(function (error) {
          alert(error.message);
        });
    },
    sortTasks (state, sort) {
      const sortByCreated = function (a, b) {
        return new Date(a.created) - new Date(b.created);
      };

      const sortByCompleted = function (a, b) {
        return new Date(a.completed) - new Date(b.completed);
      };

      if (sort === 'created') {
        return state.tasks.sort(sortByCreated);
      } else if (sort === 'completed') {
        return state.tasks.sort(sortByCompleted);
      }

      return state.tasks;
    },
    addTask (state, payload) {
      Axios.post(
        '/api/tasks/add',
        {
          name: payload,
          created: moment().format('YYYY-MM-DD HH:mm:ss'),
          modified: moment().format('YYYY-MM-DD HH:mm:ss')
        },
        {
          headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' }
        })
        .then(function (response) {
          if (response.data.success) {
            state.tasks.push(response.data.task);
          }
        })
        .catch(function (error) {
          alert(error.message);
        });
    }
  },
  actions: {
    fetchTasks (context) {
      Axios.get(
        '/api/tasks/list',
        {
          headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' }
        })
        .then(function (response) {
          if (response.status === 200) {
            context.state.tasks = response.data.tasks;
          } else {
            alert(response.statusText);
          }
        })
        .catch(function (error) {
          alert(error.message);
        });
    }
  }
});
