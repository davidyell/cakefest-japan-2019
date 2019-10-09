<template>
  <div :class="['task', { complete: task.is_complete }]">
    <p>
      <i v-if="task.is_complete" class="fas fa-check-circle"></i>
      <i v-else class="fas fa-times-circle"></i>
      &nbsp;
      {{ task.name }}
      <span class="right">{{ task.created_nice}}</span>
    </p>
  </div>
</template>

<script>
  export default {
    name: "Task",
    props: {
      task: {
        type: Object,
        required: true
      }
    }
  }
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
