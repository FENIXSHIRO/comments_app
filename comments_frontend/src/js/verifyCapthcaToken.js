import axios from "axios";

export const verifyCapthcaToken = async (token) => {
  try {
    const response = await axios.post("/captcha/verify", {
      captcha: token,
    });
    return response.data;
  } catch (error) {
    console.error("Error during form submission:", error);
    throw error;
  }
};
