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
      <el-form
        ref="ruleFormRef"
        :model="newComment"
        :rules="rules"
        label-width="auto"
        class="comments-block__form"
        status-icon
      >
        <h3>Оставить комментарий</h3>
        <el-form-item prop="username"
          ><el-input
            v-model="newComment.username"
            class="comments-block__form__input"
            placeholder="Имя"
            size="large"
        /></el-form-item>
        <el-form-item prop="content"
          ><el-input
            v-model="newComment.content"
            maxlength="2000"
            placeholder="Текст комментария"
            show-word-limit
            type="textarea"
            size="large"
            :rows="5"
        /></el-form-item>
        <VueHcaptcha
          ref="captcha"
          sitekey="76ecbad6-4abe-4098-bcd2-f16c4e2ab424"
          @verify="onCaptchaVerified"
        ></VueHcaptcha>
        <el-button type="primary" size="large" @click="addComment(ruleFormRef)"
          >Добавить комментарий</el-button
        >
      </el-form>
      <div class="comments-block__list" v-loading="isLoading">
        <CommentComponent
          class="comments-block__comment"
          v-for="comment in comments"
          v-bind:key="comment.Comment_Id"
          :username="comment.Comment_username"
          :commentDatetime="formatDate(comment.Comment_datetime)"
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
import { verifyCapthcaToken } from "@/js/verifyCapthcaToken";
import { formatDate } from "@/js/dateFormater";
import { ElNotification } from "element-plus";

import { ref, reactive, computed, onMounted } from "vue";
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

    const captcha = ref(null);
    const captchaToken = ref(null);
    const ruleFormRef = ref();
    const comments = computed(() => store.getters.allComments);
    const isLoading = computed(() => store.getters.isLoading);
    const errorMessage = computed(() => store.getters.errorMessage);

    const rules = reactive({
      username: [
        {
          required: true,
          message: "Введите имя пользователя",
          trigger: "blur",
        },
        {
          min: 3,
          max: 12,
          message: "Длина имени должна быть от 3 до 12 символов",
          trigger: "blur",
        },
      ],
      content: [
        {
          required: true,
          message: "Введите сообщение",
          trigger: "blur",
        },
      ],
    });
    const fetchComments = () => store.dispatch("fetchComments");
    const removeComment = (id) => {
      store.dispatch("deleteComment", id);
    };
    const addComment = async (formEl) => {
      if (!formEl) return;
      if (captchaToken.value == null) {
        ElNotification({
          title: "Неверные данные",
          message: "Капча не пройдена",
          type: "error",
          position: "bottom-right",
        });
        return;
      }
      await formEl.validate(async (valid) => {
        if (valid) {
          console.log("submit!");
          let verifyResponse = await verifyCapthcaToken(captchaToken.value);
          if (verifyResponse.success) {
            store.dispatch("addComment", {
              Comment_username: newComment.username,
              Comment_content: newComment.content,
            });
            formEl.resetFields();
            if (captcha.value) {
              captcha.value.reset();
            }
          }
        } else {
          ElNotification({
            title: "Неверные данные",
            message: "Введите требуемые данные",
            type: "error",
            position: "bottom-right",
          });
          return;
        }
      });
    };

    const onCaptchaVerified = (token) => {
      captchaToken.value = token;
    };

    onMounted(() => {
      fetchComments();
      console.log();
    });

    return {
      comments,
      rules,
      ruleFormRef,
      isLoading,
      errorMessage,
      newComment,
      captcha,
      removeComment,
      addComment,
      onCaptchaVerified,
      formatDate,
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
