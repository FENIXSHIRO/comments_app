<template>
  <div class="container">
    <div class="content">
      <div class="content__header"><h1>Лисичка делает -_-</h1></div>
      <div class="content__img">
        <img src="@/assets/fox.png" />
      </div>
    </div>

    <div class="comments-block">
      <div class="comments-block__header"><h2>Комментарии</h2></div>
      <div class="comments-block__form">
        <h3>Оставить комментарий</h3>
        <PrettyInput placeholder="Имя" />
        <PrettyArea placeholder="Текст комментария" />
        <VueHcaptcha
          sitekey="76ecbad6-4abe-4098-bcd2-f16c4e2ab424"
          @verify="alert('verifyed')"
        ></VueHcaptcha>
        <DefaultButton onclick="alert('test')">
          Добавить комментарий
        </DefaultButton>
      </div>
      <div class="comments-block__list">
        <CommentComponent></CommentComponent>
      </div>
    </div>
  </div>
</template>

<script>
import DefaultButton from "@/components/DefaultButton.vue";
import PrettyArea from "@/components/PrettyArea.vue";
import PrettyInput from "@/components/PrettyInput.vue";
import CommentComponent from "@/components/CommentComponent.vue";
import VueHcaptcha from "@hcaptcha/vue3-hcaptcha";

export default {
  components: {
    DefaultButton,
    PrettyArea,
    PrettyInput,
    CommentComponent,
    VueHcaptcha,
  },
};
</script>

<style lang="scss" scoped>
.container {
  width: 75%;
  margin: 0 auto;
  justify-content: center;
  display: flex;
  flex-direction: column;
}

.content {
  margin: 0 auto;
  width: 80%;
  box-shadow: 4px 4px 30px 0px rgba(67, 67, 67, 0.2);
  border-radius: 30px;

  &__header {
    margin: 0 auto;
    width: 80%;
    padding: 0px 10px;
    padding-bottom: 5px;
    border-bottom: 1px solid #444;

    h1 {
      margin: 10px 0px;
    }
  }

  &__img {
    width: 80%;
    margin: 30px auto;
    border-radius: 15px;
    img {
      width: 100%;
      border-radius: 5px;
    }
  }
}

.comments-block {
  width: 80%;
  margin: 0 auto;

  &__header {
    padding-left: 15px;
  }

  &__form {
    padding: 30px 45px;
    border-radius: 15px;
    box-shadow: 4px 4px 30px 0px rgba(67, 67, 67, 0.2);

    & > * {
      margin-bottom: 15px;
    }

    h3 {
      margin: 0;
      margin-bottom: 15px;
    }
  }

  &__list {
    height: 1000px;
    margin-top: 15px;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 4px 4px 30px 0px rgba(67, 67, 67, 0.2);
  }
}
</style>
