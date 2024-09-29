<template>
  <div class="comment">
    <div class="comment__header">
      <p class="comment__name">{{ username }}</p>
      <p class="comment__datetime">{{ commentDatetime }}</p>
    </div>
    <div class="comment__content">
      <p class="comment__text">
        <slot />
      </p>
      <el-button
        class="comment__delete"
        type="danger"
        @click="deleteComment"
        link
        >Удалить</el-button
      >
    </div>
  </div>
</template>

<script>
export default {
  props: {
    username: String,
    commentDatetime: String,
  },
  setup(_, { emit }) {
    const deleteComment = () => {
      emit("delete-comment");
    };

    return {
      deleteComment,
    };
  },
};
</script>

<style lang="scss" scoped>
.comment {
  margin: 0 auto;
  border: 1px solid #bbb;
  border-radius: 15px;
  padding: 15px;

  p {
    margin: 0;
  }

  &__header {
    display: inline;
    p {
      display: inline-block;
    }
  }

  &__datetime {
    font-size: 11pt;
    padding-left: 15px;
  }
  &__text {
    font-size: 14pt;
    padding: 10px 10px;
    border-left: 1px solid #777;
    text-wrap: pretty;
    text-overflow: ellipsis;
    overflow-wrap: break-word;
  }

  &__delete {
    border: none;
    background: none;
    padding: 0;
    cursor: pointer;
    color: #777;

    &:hover {
      color: #d60e0e;
    }
  }
}
</style>
