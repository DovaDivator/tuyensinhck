import React from "react";
import "./MainWarpper.scss";

const MainWarpper = ({ children}) => {
  return (
    <main className={`main-wrapper`}>
      {children}
    </main>
  );
} 

export default MainWarpper;