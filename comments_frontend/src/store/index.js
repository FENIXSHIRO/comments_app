import axios from "axios";
import { createStore } from "vuex";

axios.defaults.baseURL = "http://localhost:8888";

const store = createStore({
  state: {
    comments: [],
    loading: false,
    error: null,
  },
  mutations: {
    SET_COMMENTS(state, comments) {
      state.comments = comments;
      comments.sort(
        (a, b) => new Date(b.Comment_datetime) - new Date(a.Comment_datetime)
      );
    },
    ADD_COMMENT(state, comment) {
      state.comments.unshift(comment);
    },
    REMOVE_COMMENT(state, commentId) {
      state.comments = state.comments.filter(
        (comment) => comment.Comment_Id !== commentId
      );
    },
    SET_LOADING(state, loading) {
      state.loading = loading;
    },
    SET_ERROR(state, error) {
      state.error = error;
    },
  },
  actions: {
    async fetchComments({ commit }) {
      commit("SET_LOADING", true);
      commit("SET_ERROR", null);
      try {
        const response = await axios.get("/comments/all");
        commit("SET_COMMENTS", response.data);
      } catch (error) {
        commit("SET_ERROR", error.message);
      } finally {
        commit("SET_LOADING", false);
      }
    },
    async addComment({ commit }, comment) {
      commit("SET_LOADING", true);
      commit("SET_ERROR", null);
      try {
        const response = await axios.post("/comments/add", comment);
        commit("ADD_COMMENT", response.data.comment);
      } catch (error) {
        commit("SET_ERROR", error.message);
      } finally {
        commit("SET_LOADING", false);
      }
    },
    async deleteComment({ commit }, commentId) {
      commit("SET_LOADING", true);
      commit("SET_ERROR", null);
      try {
        await axios.delete(`/comments/delete/${commentId}`);
        commit("REMOVE_COMMENT", commentId);
      } catch (error) {
        commit("SET_ERROR", error.message);
      } finally {
        commit("SET_LOADING", false);
      }
    },
  },
  getters: {
    allComments: (state) => state.comments,
    isLoading: (state) => state.loading,
    errorMessage: (state) => state.error,
  },
});

export default store;
