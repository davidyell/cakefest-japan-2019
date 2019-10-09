<template>
  <div :class="['task', { complete: task.is_complete }]">
    <p>
      <a
        href="#toggle"
        title="Toggle completion"
        @click.prevent="toggleComplete"
      >
        <i
          v-if="task.is_complete"
          class="fas fa-check-circle"
        />
        <i
          v-else
          class="fas fa-times-circle"
        />
      </a>
      &nbsp;
      {{ task.name }}
      <span class="right">{{ task.created_nice }}</span>
    </p>
  </div>
</template>

<script>
export default {
  name: 'Task',
  props: {
    task: {
      type: Object,
      required: true
    }
  },
  methods: {
    toggleComplete () {
      this.$emit('toggleComplete', { id: this.task.id });
    }
  }
};
</script>

<style scoped lang="scss">
  div.task {
    padding: 10px;
    margin: 8px 0;
    background-color: #efefef;
    border: 1px solid darken(#efefef, 15%);
    &.complete {
      background-color: #afe0b5;
      border: 1px solid darken(#afe0b5, 15%);
    }
    p {
      margin-bottom: 0;
    }
  }
</style>
