<template>
  <div class="comment">
    <div class="comment__header">
      <p class="comment__name">Name</p>
      <p class="comment__datetime">00:00 00.00.0000</p>
    </div>
    <div class="comment__content">
      <p class="comment__text">
        ContentContentContentContentConte ntContentContentC
        ontentContentContentCon tentContentContentContentContentCo
        ntentContentContentContentContentContentContentContentContentContentContentContentContentContentContentContentContentContentContentContentContentContentContentContentContentContentContentContentContent
      </p>
      <button class="comment__delete">Удалить</button>
    </div>
  </div>
</template>

<script setup></script>

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
      color: #a11212;
    }
  }
}
</style>
