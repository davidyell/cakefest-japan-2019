<template>
  <div id="new-task">
    <h3>Add a new task</h3>
    <form>
      <label for="task">What is your task?</label>
      <input
        id="task"
        v-model="task"
        type="text"
        name="task"
        required="required"
      >
      <small
        v-if="task === null"
        class="error"
      >A name for your task is required</small>

      <button
        type="submit"
        class="button"
        @click.prevent="addTask"
      >
        <i class="fas fa-save" /> Save task
      </button>
    </form>
  </div>
</template>

<script>
export default {
  name: 'NewTask',
  data () {
    return {
      task: null
    };
  },
  methods: {
    addTask () {
      this.$store.commit('addTask', this.task);
      this.task = null;
    }
  }
};
</script>

<style scoped lang="scss">

</style>
