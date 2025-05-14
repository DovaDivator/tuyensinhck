import React, {JSX, useContext, Suspense } from 'react';
import '@fortawesome/fontawesome-free/css/all.min.css';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import { Navigate } from 'react-router-dom';
import { HelmetProvider } from 'react-helmet-async';

import { ContextProvider } from './context/ContextProvider'; // Import ContextProvider
import { AppContext } from './context/AppContext'; // Import AppContext

import LoadingScreen from './views/ui/components/LoadingScreen';
import SmallScreen from './pages/other/SmallScreen';

const LoginPage = React.lazy(() => import('./pages/auth/LoginPage'));
const RegisterPage = React.lazy(() => import('./pages/auth/RegisterPage'));
const HomePage = React.lazy(() => import('./pages/main/HomePage'));
const IntroducePage = React.lazy(() => import('./pages/main/IntroducePage'));
const NewsPage = React.lazy(() => import('./pages/main/NewsPage'));
const IntroduceUniSection = React.lazy(() => import('./pages/main/IntroduceUniPage'));

const AppContent = (): JSX.Element => {
  const { isTooSmall, isLoading } = useContext(AppContext);

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
            <Route path="/login" element={<LoginPage />} />
            <Route path="/register" element={<RegisterPage />} />

            <Route path="/introduce" element={<IntroducePage />}/>
            <Route path="/introduce/uni/:type" element={<IntroduceUniSection />} />

            <Route path="/news" element={<NewsPage/>} />
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