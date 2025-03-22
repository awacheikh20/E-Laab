// frontend/src/components/LogoutButton.js
import React from 'react';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';

const LogoutButton = () => {
  const navigate = useNavigate();

  const handleLogout = async () => {
    try {
      // Appeler la route de déconnexion du backend
      await axios.post('http://localhost:5000/api/auth/logout', {}, {
        headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
      });
    } catch (err) {
      console.error('Erreur lors de la déconnexion :', err);
    } finally {
      // Supprimer le token JWT du localStorage
      localStorage.removeItem('token');
      // Rediriger vers la page de connexion
      navigate('/login');
    }
  };

  return (
    <button
      onClick={handleLogout}
      className="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
    >
      Déconnexion
    </button>
  );
};

export default LogoutButton;