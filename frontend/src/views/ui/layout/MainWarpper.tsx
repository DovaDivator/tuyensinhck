import React, {ReactNode, JSX} from "react";
import "./MainWarpper.scss";

interface MainWarpperProps{
  children: ReactNode;
}

/**
 * Phần <main> trong bố cục của trang web
 */
const MainWarpper = ({ children}: MainWarpperProps): JSX.Element => {
  return (
    <main className={`main-wrapper`}>
      {children}
    </main>
  );
} 

export default MainWarpper;