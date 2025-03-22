import React, { useState } from "react";
import axios from "axios";
import "../../index.css";
import { useNavigate } from "react-router-dom";

const Login = () => {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");
  const navigate = useNavigate();

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const res = await axios.post("http://localhost:5000/api/auth/login", {
        email,
        password,
      });
      localStorage.setItem("token", res.data.token);
      console.log(res.data);

      navigate("/student-dashboard");
    } catch (err) {
      setError(err.response?.data?.error || "Erreur de connexion");
    }
  };

  return (
    <div className="bg-gray-100 flex items-center justify-center min-h-screen">
      <div className="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <div className="flex justify-center mb-6">
          <img
            src="https://fad.esp.sn/pluginfile.php/1/theme_moove/logo/1709829106/senegal-ucad.png"
            alt="Logo ESP"
            className="h-16"
          />
        </div>
        <h1 className="text-2xl font-bold text-center mb-6">Connexion</h1>
        {error && <p className="text-red-500 text-center mb-4">{error}</p>}
        <form onSubmit={handleSubmit}>
          <div className="mb-4">
            <label htmlFor="email" className="block text-gray-700">
              Email
            </label>
            <input
              type="email"
              id="email"
              className="w-full p-2 border rounded mt-1"
              placeholder="votre@email.com"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              required
            />
          </div>
          <div className="mb-6">
            <label htmlFor="password" className="block text-gray-700">
              Mot de passe
            </label>
            <input
              type="password"
              id="password"
              className="w-full p-2 border rounded mt-1"
              placeholder="********"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              required
            />
          </div>
          <button
            type="submit"
            className="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700"
          >
            Se connecter
          </button>
        </form>
        <p className="text-center mt-4 text-gray-600">
          Ou connectez-vous avec :
        </p>
        <div className="flex justify-center gap-4 mt-4">
          <button className="bg-red-500 text-white p-2 rounded hover:bg-red-600">
            Google
          </button>
          <button className="bg-blue-800 text-white p-2 rounded hover:bg-blue-900">
            Facebook
          </button>
          <button className="bg-gray-800 text-white p-2 rounded hover:bg-gray-900">
            Microsoft
          </button>
          <button className="bg-gray-700 text-white p-2 rounded hover:bg-gray-800">
            GitHub
          </button>
        </div>
        <p className="text-center mt-4 text-sm">
          Pas de compte ?{" "}
          <a href="#" className="text-blue-600">
            Inscrivez-vous
          </a>
        </p>
      </div>
    </div>
  );
};

export default Login;