import React, { useState } from "react";
import axios from "axios";
import { useDropzone } from "react-dropzone";
import { useParams } from "react-router-dom";

const Submit = () => {
  const { examId } = useParams();
  const [file, setFile] = useState(null);
  const [error, setError] = useState("");
  const [success, setSuccess] = useState("");
  const [loading, setLoading] = useState(false);

  const onDrop = (acceptedFiles) => {
    setFile(acceptedFiles[0]);
    setError("");
    setSuccess("");
  };

  const { getRootProps, getInputProps } = useDropzone({
    onDrop,
    accept: "application/pdf",
    maxSize: 5 * 1024 * 1024, // 5MB max
  });

  const handleSubmit = async () => {
    if (!file) {
      setError("Veuillez sélectionner un fichier.");
      return;
    }

    const formData = new FormData();
    formData.append("file", file);

    try {
      setLoading(true);
      const token = localStorage.getItem("token");
      await axios.post(
        `http://localhost:5000/api/files/upload`,
        formData,
        {
          headers: {
            "Content-Type": "multipart/form-data",
            Authorization: `Bearer ${token}`,
          },
        }
      );
      setSuccess("Fichier uploadé avec succès !");
      setFile(null);
    } catch (err) {
      setError(err.response?.data?.error || "Erreur lors de l'upload.");
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="flex flex-col items-center justify-center min-h-screen bg-gray-100 p-4">
      <div
        {...getRootProps()}
        className="w-full max-w-lg p-6 bg-white border-2 border-dashed border-gray-300 rounded-lg shadow-md text-center cursor-pointer hover:border-blue-500"
      >
        <input {...getInputProps()} />
        <p className="text-gray-500">
          📂 Glissez-déposez un fichier PDF ici ou cliquez pour en sélectionner un
        </p>
      </div>

      {file && (
        <div className="mt-4 p-4 bg-white shadow rounded-lg text-center w-full max-w-lg">
          <p className="font-semibold text-gray-700">📄 {file.name}</p>
          <button
            onClick={handleSubmit}
            className="mt-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md"
            disabled={loading}
          >
            {loading ? "⏳ Upload en cours..." : "📤 Uploader"}
          </button>
        </div>
      )}

      {error && <p className="text-red-500 mt-4">{error}</p>}
      {success && <p className="text-green-500 mt-4">{success}</p>}
    </div>
  );
};

export default Submit;
