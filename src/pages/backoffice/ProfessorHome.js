import React, { useState } from 'react';
import axios from 'axios';
import { useDropzone } from 'react-dropzone';

const ProfessorHome = () => {
  const [file, setFile] = useState(null);
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');

  const onDrop = (acceptedFiles) => {
    setFile(acceptedFiles[0]);
  };

  const { getRootProps, getInputProps } = useDropzone({ onDrop, accept: 'application/pdf' });

  const handleSubmit = async () => {
    if (!file) {
      setError('Veuillez sélectionner un fichier');
      return;
    }

    const formData = new FormData();
    formData.append('file', file);

    try {
      const token = localStorage.getItem('token');
      await axios.post('http://localhost:5000/api/files/upload', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
          Authorization: `Bearer ${token}`,
        },
      });
      setSuccess('Fichier uploadé avec succès');
      setError('');
    } catch (err) {
      setError(err.response?.data?.error || 'Erreur lors de l\'upload');
      setSuccess('');
    }
  };

  return (
    <div className="p-4">
      <div {...getRootProps()} className="border-2 border-dashed p-4 text-center cursor-pointer">
        <input {...getInputProps()} />
        <p>Glissez-déposez un fichier PDF ici, ou cliquez pour sélectionner un fichier</p>
      </div>
      {file && (
        <div className="mt-4">
          <p>Fichier sélectionné : {file.name}</p>
          <button onClick={handleSubmit} className="mt-2 bg-blue-500 text-white p-2 rounded">
            Uploader
          </button>
        </div>
      )}
      {error && <p className="text-red-500 mt-4">{error}</p>}
      {success && <p className="text-green-500 mt-4">{success}</p>}
    </div>
  );
};

export default ProfessorHome;