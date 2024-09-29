<template>
  <input type="text" class="pretty-input" :placeholder="placeholder" />
</template>

<script>
export default {
  props: {
    placeholder: String,
  },
};
</script>

<style lang="scss" scoped>
.pretty-input {
  background-color: #f7fafc;
  border-radius: 0.375rem;
  border: 1px solid #cbd5e0;
  height: 2rem;
  padding: 0.5rem 0.75rem;
  font-family: inherit;
  font-size: 1rem;
}
</style>
