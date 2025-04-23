// src/context/index.js
import { AppProvider } from "./AppContext";

export const ContextProvider = ({ children }) => {
  return (
    <AppProvider>
      {children}
    </AppProvider>
  );
};
