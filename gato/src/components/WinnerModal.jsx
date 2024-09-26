import React from 'react';

export const WinnerModal = ({ resetGame, winner, getPlayerName }) => {
  if (winner === null) return null;

  const winnerText = winner === false ? 'Empate' : `Ganador: ${getPlayerName(winner)}`;

  return (
    <div className="modal">
      <div className="modal-content">
        <h2>{winnerText}</h2>
        <button onClick={resetGame}>Reset del juego</button>
      </div>
    </div>
  );
};
