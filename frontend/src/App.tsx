import React, {JSX, useContext, Suspense } from 'react';
import '@fortawesome/fontawesome-free/css/all.min.css';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import { Navigate } from 'react-router-dom';
import { HelmetProvider } from 'react-helmet-async';

import { ContextProvider } from './context/ContextProvider'; // Import ContextProvider
import { useAppContext } from './context/AppContext'; // Import AppContext

import LoadingScreen from './views/ui/components/LoadingScreen';
import SmallScreen from './pages/other/SmallScreen';

const LoginPage = React.lazy(() => import('./pages/auth/LoginPage'));
const RegisterPage = React.lazy(() => import('./pages/auth/RegisterPage'));
const HomePage = React.lazy(() => import('./pages/main/HomePage'));
const IntroducePage = React.lazy(() => import('./pages/main/IntroducePage'));
const NewsPage = React.lazy(() => import('./pages/main/NewsPage'));
const DiscoverUniPage = React.lazy(() => import('./pages/main/DiscoverUniPage'));

const AppContent = (): JSX.Element => {
  const { isTooSmall, isLoading } = useAppContext();

  if (isTooSmall) {
    return <SmallScreen />;
  }

  return (
    <Suspense fallback={<LoadingScreen />}>
      {isTooSmall ? (
        <SmallScreen />
      ) : (
        <Router>
          {isLoading && <LoadingScreen />}
          <Routes>
            <Route path="/" element={<HomePage />} />
            <Route path="/dang-nhap" element={<LoginPage />} />
            <Route path="/dang-ky" element={<RegisterPage />} />

            <Route path="/gioi-thieu" element={<IntroducePage />}/>
            <Route path="/kham-pha/he/:type" element={<DiscoverUniPage />} />

            <Route path="/tin-tuc" element={<NewsPage/>} />
            <Route path="*" element={<Navigate to="/" replace />} />
          </Routes>
        </Router>
      )}
    </Suspense>
  );
};

const App = (): JSX.Element => {
  return (
    <HelmetProvider>
      <ContextProvider>
        <AppContent />
      </ContextProvider>
    </HelmetProvider>
  );
};

export default App;