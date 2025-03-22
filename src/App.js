import React from "react";
import { BrowserRouter as Router, Route, Routes } from "react-router-dom";
import DashboardS from "./pages/frontoffice/StudentDashboard";
import DashboardP from "./pages/backoffice/ProfessorDashboard";
import CreateExercise from "./pages/backoffice/ProfessorHome";
import ExerciseList from "./pages/frontoffice/Home";
import SubmitAnswer from "./pages/frontoffice/Submit";
import Statistiques from "./pages/frontoffice/Statistiques";
import SubmissionsList from "./pages/backoffice/ManageCorrections";
import CorrectionS from "./pages/frontoffice/Correction";
import CorrectionP from "./pages/backoffice/ManageCorrections";


import { GoogleOAuthProvider } from '@react-oauth/google';
import { AuthProvider } from 'react-oauth2-code-pkce';
import Login from './pages/auth/Login'; // Adjust path if needed

const App = () => {
  // const googleClientId = 'your-google-client-id'; // Replace with your Google Client ID

  // const microsoftAuthConfig = {
  //   clientId: 'your-microsoft-client-id', // Replace with your Microsoft Client ID
  //   authorizationEndpoint: 'https://login.microsoftonline.com/common/oauth2/v2.0/authorize',
  //   tokenEndpoint: 'https://login.microsoftonline.com/common/oauth2/v2.0/token',
  //   redirectUri: 'http://localhost:3000', // Must match Azure AD redirect URI
  //   scope: 'openid profile email', // Adjust scopes as needed
  // };

  return (
    
        <Router>
          <Routes>
              <Route path="/" element={<Login />} />
              <Route path="/login" element={<Login />} />
              <Route path="/DashboardS" element={<DashboardS />} />
              <Route path="/DashboardS" element={<DashboardP />} />
              <Route path="/creer" element={<CreateExercise />} />
              <Route path="/exercises" element={<ExerciseList />} />
              <Route path="/submit-answer" element={<SubmitAnswer />} />
              <Route path="/statistiques" element={<Statistiques />} />
              <Route path="/submissions" element={<SubmissionsList />} />
              <Route path="/etudiant/corrections" element={<CorrectionS />} />

          </Routes>
        </Router>
  );
};

export default App;