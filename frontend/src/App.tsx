import React, { useContext } from 'react';
import '@fortawesome/fontawesome-free/css/all.min.css';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import { Navigate } from 'react-router-dom';
import { HelmetProvider } from 'react-helmet-async';

import { ContextProvider } from './context/ContextProvider'; // Import ContextProvider
import { AppContext } from './context/AppContext'; // Import AppContext

import LoginPage from './pages/auth/LoginPage';
import RegisterPage from './pages/auth/RegisterPage';
import HomePage from './pages/main/HomePage';

import LoadingScreen from './components/ui/layout/LoadingScreen';
import SmallScreen from './pages/other/SmallScreen';

const AppContent = () => {
  const { isTooSmall, isLoading } = useContext(AppContext);

  if (isTooSmall) {
    return <SmallScreen />;
  }

  return (
    <Router>
      {isLoading && <LoadingScreen />}
      <Routes>
        <Route path="/" element={<HomePage />} />
        <Route path="/login" element={<LoginPage />} />
        <Route path="/register" element={<RegisterPage />} />
        <Route path="/home" element={<HomePage />} />
        <Route path="*" element={<Navigate to="/" replace />} />
      </Routes>
    </Router>
  );
};

const App = () => {
  return (
    <HelmetProvider>
      <ContextProvider>
        <AppContent />
      </ContextProvider>
    </HelmetProvider>
  );
};

export default App;