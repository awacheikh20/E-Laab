import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

const Home = () => {
  const [exams, setExams] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  useEffect(() => {
    const fetchExams = async () => {
      try {
        const token = localStorage.getItem('token');
        const res = await axios.get('http://localhost:5000/api/exams', {
          headers: { Authorization: `Bearer ${token}` },
        });
        setExams(res.data);
      } catch (err) {
        setError('Erreur lors du chargement des sujets.');
      } finally {
        setLoading(false);
      }
    };
    fetchExams();
  }, []);

  return (
    <div className="max-w-4xl mx-auto p-6">
      <h1 className="text-2xl font-bold mb-4">📚 Sujets disponibles</h1>
      
      <Link to="/student-dashboard" className="bg-blue-500 text-white px-4 py-2 rounded-md mb-4 inline-block">
        🎓 Accéder à mon tableau de bord
      </Link>

      {loading ? (
        <p className="text-gray-600">Chargement...</p>
      ) : error ? (
        <p className="text-red-500">{error}</p>
      ) : exams.length === 0 ? (
        <p className="text-gray-600">Aucun sujet disponible.</p>
      ) : (
        <ul className="mt-4 space-y-2">
          {exams.map((exam) => (
            <li key={exam._id} className="border p-4 rounded-md shadow-md">
              <h3 className="text-lg font-bold">{exam.title}</h3>
              <Link
                to={`/submit/${exam._id}`}
                className="mt-2 block bg-green-500 text-white px-4 py-2 rounded-md"
              >
                📤 Soumettre ma réponse
              </Link>
            </li>
          ))}
        </ul>
      )}
    </div>
  );
};

export default Home;
