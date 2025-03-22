import React, { useEffect, useState, useRef } from "react";
import axios from "axios";
import { Chart, LineController, LineElement, PointElement, LinearScale, CategoryScale, BarController, BarElement } from "chart.js";
import { useNavigate } from "react-router-dom";
import LogoutButton from "../components/LogoutButton";

// Enregistrer les composants nécessaires de Chart.js
Chart.register(LineController, LineElement, PointElement, LinearScale, CategoryScale, BarController, BarElement);

const Statistiques = () => {
  const [studentStats, setStudentStats] = useState([]);
  const [professorStats, setProfessorStats] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState("");
  const navigate = useNavigate();

  const progressChartRef = useRef(null);
  const scoreChartRef = useRef(null);

  // Récupérer les données depuis le serveur
  useEffect(() => {
    const fetchData = async () => {
      try {
        const token = localStorage.getItem("token");

        // Récupérer les statistiques pour les étudiants
        const studentRes = await axios.get("http://localhost:5000/api/stats/student", {
          headers: { Authorization: `Bearer ${token}` },
        });
        setStudentStats(studentRes.data);

        // Récupérer les statistiques pour les professeurs (si nécessaire)
        const professorRes = await axios.get("http://localhost:5000/api/stats/professor", {
          headers: { Authorization: `Bearer ${token}` },
        });
        setProfessorStats(professorRes.data);

        setLoading(false);
      } catch (err) {
        setError("Erreur lors de la récupération des données");
        setLoading(false);
      }
    };
    fetchData();
  }, []);

  // Créer les graphiques une fois les données chargées
  useEffect(() => {
    if (studentStats.length > 0) {
      const progressCtx = progressChartRef.current.getContext("2d");
      new Chart(progressCtx, {
        type: "line",
        data: {
          labels: studentStats.map((sub) => sub.examId.title), // Titres des examens
          datasets: [
            {
              label: "Notes",
              data: studentStats.map((sub) => sub.grade), // Notes des soumissions
              borderColor: "#2563eb",
              fill: false,
            },
          ],
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: "top",
            },
          },
        },
      });

      const scoreCtx = scoreChartRef.current.getContext("2d");
      new Chart(scoreCtx, {
        type: "bar",
        data: {
          labels: studentStats.map((sub) => sub.examId.title), // Titres des examens
          datasets: [
            {
              label: "Notes",
              data: studentStats.map((sub) => sub.grade), // Notes des soumissions
              backgroundColor: "#2563eb",
            },
          ],
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: "top",
            },
          },
        },
      });
    }
  }, [studentStats]);

  if (loading) return <p>Chargement en cours...</p>;
  if (error) return <p className="text-red-500">{error}</p>;

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
          <a
            href="#"
            onClick={() => navigate("/student-dashboard")}
            className="text-white hover:underline mr-4"
          >
            Accueil
          </a>
          <a
            href="#"
            onClick={() => navigate("/submit-exercise")}
            className="text-white hover:underline mr-4"
          >
            Déposer un exercice
          </a>
          <a href="#" className="text-white hover:underline">
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
        <h2 className="text-2xl font-semibold mb-4">Statistiques</h2>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          {/* Graphique de progression des notes */}
          <div className="bg-white p-4 rounded-lg shadow">
            <h3 className="text-lg font-bold mb-2">Progression des notes</h3>
            <canvas ref={progressChartRef}></canvas>
          </div>

          {/* Graphique de répartition des scores */}
          <div className="bg-white p-4 rounded-lg shadow">
            <h3 className="text-lg font-bold mb-2">Répartition des scores</h3>
            <canvas ref={scoreChartRef}></canvas>
          </div>
        </div>
      </main>
    </div>
  );
};

export default Statistiques;