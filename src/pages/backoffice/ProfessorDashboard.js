import React, { useEffect, useState } from 'react';
import axios from 'axios';
import { LineChart, Line, XAxis, YAxis, Tooltip, Legend } from 'recharts';

const ProfessorDashboard = () => {
  const [exams, setExams] = useState([]);

  useEffect(() => {
    const fetchExams = async () => {
      const token = localStorage.getItem('token');
      const res = await axios.get('http://localhost:5000/api/stats/professor', {
        headers: { Authorization: `Bearer ${token}` },
      });
      setExams(res.data);
    };
    fetchExams();
  }, []);

  const data = exams.map((exam) => ({
    name: exam.title,
    submissions: exam.submissions.length,
  }));

  return (
    <div className="container mx-auto p-4">
      <h1 className="text-2xl mb-4">Tableau de bord professeur</h1>
      <LineChart width={600} height={300} data={data}>
        <XAxis dataKey="name" />
        <YAxis />
        <Tooltip />
        <Legend />
        <Line type="monotone" dataKey="submissions" stroke="#8884d8" />
      </LineChart>
    </div>
  );
};

export default ProfessorDashboard;