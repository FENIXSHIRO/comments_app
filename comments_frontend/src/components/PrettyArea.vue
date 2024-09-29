<template>
  <textarea
    class="comment-box"
    name="body"
    :placeholder="placeholder"
    required
  ></textarea>
</template>

<script>
export default {
  props: {
    placeholder: String,
  },
};
</script>

<style lang="scss" scoped>
.comment-box {
  background-color: #f7fafc;
  border-radius: 0.375rem;
  border: 1px solid #cbd5e0;
  width: 100%;
  height: 8rem;
  padding: 0.5rem 0.75rem;
  font-family: inherit;
  font-size: 1rem;
  line-height: 1.5;
  resize: none;
}
</style>
