import { alertForgotPassword } from "../alert/alertForgotPassword";

export const forgotPassword = async (e: React.FormEvent<HTMLFormElement>): Promise<void> => {
  e.preventDefault();
  const getResult = await alertForgotPassword();
  console.log(getResult);
};
