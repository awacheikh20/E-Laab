import React, { useEffect, useState } from 'react';
import axios from 'axios';

const ManageCorrections = () => {
  const [submissions, setSubmissions] = useState([]);

  useEffect(() => {
    const fetchSubmissions = async () => {
      const token = localStorage.getItem('token');
      const res = await axios.get('http://localhost:5000/api/submissions', {
        headers: { Authorization: `Bearer ${token}` },
      });
      setSubmissions(res.data);
    };
    fetchSubmissions();
  }, []);

  return (
    <div className="container mx-auto p-4">
      <h1 className="text-2xl mb-4">Gestion des corrections</h1>
      <ul>
        {submissions.map((sub) => (
          <li key={sub._id} className="mb-2">
            <p>{sub.examId.title} - {sub.studentId.name}</p>
            <p>Note : {sub.grade}</p>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default ManageCorrections;