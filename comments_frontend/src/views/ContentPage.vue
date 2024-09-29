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
        <el-input
          v-model="newComment.username"
          class="comments-block__form__input"
          placeholder="Имя"
          size="large"
        />
        <el-input
          v-model="newComment.content"
          maxlength="2000"
          placeholder="Текст комментария"
          show-word-limit
          type="textarea"
          size="large"
          :rows="5"
        />
        <VueHcaptcha
          sitekey="76ecbad6-4abe-4098-bcd2-f16c4e2ab424"
          @verify="alert('verifyed')"
        ></VueHcaptcha>
        <el-button type="primary" @click="addComment"
          >Добавить комментарий</el-button
        >
      </div>
      <div class="comments-block__list" v-loading="isLoading">
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
import CommentComponent from "@/components/CommentComponent.vue";
import VueHcaptcha from "@hcaptcha/vue3-hcaptcha";

import { reactive, computed, onMounted } from "vue";
import { useStore } from "vuex";

export default {
  components: {
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
      width: 25%;
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
