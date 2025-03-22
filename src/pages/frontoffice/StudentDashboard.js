import React, { useEffect, useState } from "react";
import axios from "axios";
import { BarChart, Bar, XAxis, YAxis, Tooltip, Legend } from "recharts";
import { useNavigate } from "react-router-dom";
import LogoutButton from "../components/LogoutButton";

const StudentDashboard = () => {
  const [submissions, setSubmissions] = useState([]);
  const [stats, setStats] = useState({
    pendingExercises: 0,
    latestGrade: null,
    progress: 0,
  });
  const navigate = useNavigate();

  useEffect(() => {
    const fetchData = async () => {
      const token = localStorage.getItem("token");
      try {
        // Récupérer les soumissions
        const submissionsRes = await axios.get(
          "http://localhost:5000/api/stats/student",
          {
            headers: { Authorization: `Bearer ${token}` },
          }
        );
        setSubmissions(submissionsRes.data);

        // Récupérer les statistiques (exemple)
        const statsRes = await axios.get(
          "http://localhost:5000/api/stats/student-summary",
          {
            headers: { Authorization: `Bearer ${token}` },
          }
        );
        setStats(statsRes.data);
      } catch (error) {
        console.error("Erreur lors de la récupération des données:", error);
      }
    };
    fetchData();
  }, []);

  const chartData = submissions.map((sub) => ({
    name: sub.examId.title,
    grade: sub.grade,
  }));

  return (
    <div className="bg-gray-100 min-h-screen">
      {/* En-tête */}
      <header className="bg-blue-600 text-white p-4">
        <div className="flex items-center">
          <img
            src="https://fad.esp.sn/pluginfile.php/1/theme_moove/logo/1709829106/senegal-ucad.png"
            alt="Logo ESP"
            className="h-12 mr-4"
          />
          <h1 className="text-xl font-bold">Plateforme Bases de Données</h1>
        </div>
        <nav className="mt-2">
          <a href="#" className="text-white hover:underline mr-4">
            Accueil
          </a>
          <a
            href="#"
            onClick={() => navigate("/submit-exercise")}
            className="text-white hover:underline mr-4"
          >
            Déposer un exercice
          </a>
          <a
            href="#"
            onClick={() => navigate("/stats")}
            className="text-white hover:underline mr-4"
          >
            Statistiques
          </a>
          <a href="#" className="text-white hover:underline">
            Corrections
          </a>
          <LogoutButton className="text-white hover:underline float-right" />
        </nav>
      </header>

      {/* Contenu principal */}
      <main className="p-6">
        <h2 className="text-2xl font-semibold mb-4">Bienvenue, Fatou Diop</h2>

        {/* Cartes de résumé */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          <div className="bg-white p-4 rounded-lg shadow">
            <h3 className="text-lg font-bold">Exercices en attente</h3>
            <p className="text-gray-600">{stats.pendingExercises} exercices</p>
          </div>
          <div className="bg-white p-4 rounded-lg shadow">
            <h3 className="text-lg font-bold">Dernière note</h3>
            <p className="text-gray-600">
              {stats.latestGrade ? `${stats.latestGrade}/20` : "Aucune note"}
            </p>
          </div>
          <div className="bg-white p-4 rounded-lg shadow">
            <h3 className="text-lg font-bold">Progression</h3>
            <p className="text-gray-600">+{stats.progress}% ce mois-ci</p>
          </div>
        </div>

        {/* Graphique */}
        <div className="bg-white p-6 rounded-lg shadow">
          <h3 className="text-xl font-bold mb-4">Notes des exercices</h3>
          <BarChart width={600} height={300} data={chartData}>
            <XAxis dataKey="name" />
            <YAxis />
            <Tooltip />
            <Legend />
            <Bar dataKey="grade" fill="#8884d8" />
          </BarChart>
        </div>
      </main>
    </div>
  );
};

export default StudentDashboard;