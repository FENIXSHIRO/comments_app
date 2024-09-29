<template>
  <button class="button-component">
    <slot />
  </button>
</template>

<script></script>

<style lang="scss" scoped>
.button-component {
  padding: 12px 20px;
  font-size: 16px;
  background-color: #4258b9;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.5s ease;

  &:hover {
    background-color: #3842a1;
  }
}
</style>
