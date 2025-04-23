import React, { createContext, useState, useEffect } from 'react';

// Tạo Context
export const AppContext = createContext();

// Tạo Provider
export const AppProvider = ({ children }) => {
  const [isLoading, setIsLoading] = useState(false);
  const [isTooSmall, setIsTooSmall] = useState(false);
  const [screenSize, setScreenSize] = useState({ width: window.innerWidth, height: window.innerHeight });

  useEffect(() => {
    const checkScreenSize = () => {
      const width = window.innerWidth;
      const height = window.innerHeight;
      setScreenSize({ width, height });

      // Check if the screen size is too small
      if (width < 250 || height < 250) {
        setIsTooSmall(true);
      } else {
        setIsTooSmall(false);
      }
    };

    checkScreenSize();
    window.addEventListener('resize', checkScreenSize);

    return () => {
      window.removeEventListener('resize', checkScreenSize);
    };
  }, []);

  return (
    <AppContext.Provider value={{ isLoading, setIsLoading, screenSize, isTooSmall }}>
      {children}
    </AppContext.Provider>
  );
};