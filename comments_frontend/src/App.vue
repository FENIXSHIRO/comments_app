<template>
  <ContentPage />
</template>

<script>
import ContentPage from "@/views/ContentPage.vue";

export default {
  name: "App",
  components: {
    ContentPage,
  },
};
</script>

<style lang="scss">
html {
  box-sizing: border-box;
}

body {
  max-width: 100%;

  color: #444;
  font-size: 16pt;
  font-family: Arial, Helvetica, sans-serif;
}

*,
*::before,
*::after {
  box-sizing: inherit;
}
</style>
