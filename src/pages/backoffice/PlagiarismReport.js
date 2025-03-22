import React, { useState } from 'react';
import axios from 'axios';

const PlagiarismReport = ({ submissionId }) => {
  const [report, setReport] = useState(null);
  const [error, setError] = useState('');

  const fetchReport = async () => {
    try {
      const token = localStorage.getItem('token');
      const res = await axios.get(`http://localhost:5000/api/plagiarism/detect/${submissionId}`, {
        headers: { Authorization: `Bearer ${token}` },
      });
      setReport(res.data);
    } catch (err) {
      setError(err.response?.data?.error || 'Erreur lors de la récupération du rapport');
    }
  };

  useEffect(() => {
    fetchReport();
  }, [submissionId]);

  return (
    <div className="p-4">
      <h2 className="text-xl mb-4">Rapport de plagiat</h2>
      {error && <p className="text-red-500">{error}</p>}
      {report && (
        <div className="bg-gray-100 p-4 rounded">
          <p>Similarité Jaccard : {report.jaccard}</p>
          <p>Similarité TF-IDF : {report.tfidf}</p>
        </div>
      )}
    </div>
  );
};

export default PlagiarismReport;