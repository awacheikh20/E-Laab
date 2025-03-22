import React, { useState, useEffect } from 'react'; // Added useEffect import
import axios from 'axios';

const Correction = ({ submissionId }) => {
  const [correction, setCorrection] = useState('');
  const [error, setError] = useState('');

  useEffect(() => {
    const fetchCorrection = async () => {
      try {
        const token = localStorage.getItem('token');
        const res = await axios.get(`http://localhost:5000/api/ai/correct/${submissionId}`, {
          headers: { Authorization: `Bearer ${token}` },
        });
        setCorrection(res.data.correction);
      } catch (err) {
        setError(err.response?.data?.error || 'Erreur lors de la récupération de la correction');
      }
    };
    fetchCorrection();
  }, [submissionId]);

  return (
    <div className="p-4">
      <h2 className="text-xl mb-4">Correction automatique</h2>
      {error && <p className="text-red-500">{error}</p>}
      <div className="bg-gray-100 p-4 rounded">
        <pre>{correction}</pre>
      </div>
    </div>
  );
};

export default Correction;