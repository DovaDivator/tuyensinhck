import { alertForgotPassword } from "../alert/alertForgotPassword"

export const forgotPassword = async (e) => {
    e.preventDefault();
    const getResult = await alertForgotPassword();
    console.log(getResult);
}