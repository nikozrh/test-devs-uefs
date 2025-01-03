import React from 'react';
import './Modal.css';
import '../index.css';

const Modal = ({ show, onClose, onSave, title, children }) => {
  if (!show) return null;

  return (
    <div className="modal-overlay">
      <div className="modal-content">
      <h2>{title}</h2>
      <button onClick={onClose} className="close-button-top">X</button>
        {children}
      </div>
    </div>
  );
};

export default Modal;
