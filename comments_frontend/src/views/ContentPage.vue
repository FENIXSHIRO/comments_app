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
        <input
          v-model="newComment.username"
          class="comments-block__form__input"
          type="text"
          placeholder="Имя"
        />
        <textarea
          v-model="newComment.content"
          class="comments-block__form__textArea"
          placeholder="Текст комментария"
        />
        <VueHcaptcha
          sitekey="76ecbad6-4abe-4098-bcd2-f16c4e2ab424"
          @verify="alert('verifyed')"
        ></VueHcaptcha>
        <DefaultButton @click="addComment">
          Добавить комментарий
        </DefaultButton>
      </div>
      <div class="comments-block__list">
        <CommentComponent
          class="comments-block__comment"
          v-for="comment in comments"
          v-bind:key="comment.Comment_Id"
          :username="comment.Comment_username"
          :commentDatetime="comment.Comment_datetime"
          @delete-comment="removeComment(comment.Comment_Id)"
          >{{ comment.Comment_content }}</CommentComponent
        >
      </div>
    </div>
  </div>
</template>

<script>
import DefaultButton from "@/components/DefaultButton.vue";
import CommentComponent from "@/components/CommentComponent.vue";
import VueHcaptcha from "@hcaptcha/vue3-hcaptcha";

import { reactive, computed, onMounted } from "vue";
import { useStore } from "vuex";

export default {
  components: {
    DefaultButton,
    CommentComponent,
    VueHcaptcha,
  },
  setup() {
    const store = useStore();
    const newComment = reactive({
      username: null,
      content: null,
    });

    const comments = computed(() => store.getters.allComments);
    const isLoading = computed(() => store.getters.isLoading);
    const errorMessage = computed(() => store.getters.errorMessage);

    const fetchComments = () => store.dispatch("fetchComments");
    const removeComment = (id) => {
      store.dispatch("deleteComment", id);
    };
    const addComment = () => {
      if (newComment.username && newComment.content) {
        store.dispatch("addComment", {
          Comment_username: newComment.username,
          Comment_content: newComment.content,
        });
        newComment.username = null;
        newComment.content = null;
      } else {
        alert(newComment.username);
      }
    };

    onMounted(() => {
      fetchComments();
      console.log();
    });

    return {
      comments,
      isLoading,
      errorMessage,
      newComment,
      removeComment,
      addComment,
    };
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
    &__input {
      background-color: #f7fafc;
      border-radius: 0.375rem;
      border: 1px solid #cbd5e0;
      height: 2rem;
      padding: 0.5rem 0.75rem;
      font-family: inherit;
      font-size: 1rem;
    }
    &__textArea {
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
  }

  &__list {
    margin-top: 15px;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 4px 4px 30px 0px rgba(67, 67, 67, 0.2);
  }

  &__comment {
    margin-bottom: 10px;
  }
}
</style>
