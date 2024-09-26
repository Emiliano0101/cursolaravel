import './App.css';
import { useState } from 'react';
import confetti from 'canvas-confetti';
import { Square } from './components/Square.jsx';
import { TURNS } from './constants.js';
import { checkWinnerFrom, checkEndGame } from './logic/board.js';
import { WinnerModal } from './components/WinnerModal.jsx';
import { saveGameToStorage, resetGameStorage } from './logic/storage/index.js';

function App() {
  const [board, setBoard] = useState(() => {
    const boardFromStorage = window.localStorage.getItem('board');
    if (boardFromStorage) return JSON.parse(boardFromStorage);
    return Array(9).fill(null);
  });

  const [turn, setTurn] = useState(() => {
    const turnFromStorage = window.localStorage.getItem('turn');
    return turnFromStorage ?? TURNS.X;
  });

  const [winner, setWinner] = useState(null);

  const resetGame = () => {
    setBoard(Array(9).fill(null));
    setTurn(TURNS.X);
    setWinner(null);
    resetGameStorage();
  };

  const updateBoard = (index) => {
    if (board[index] || winner) return;
    const newBoard = [...board];
    newBoard[index] = turn;
    setBoard(newBoard);
    const newTurn = turn === TURNS.X ? TURNS.O : TURNS.X;
    setTurn(newTurn);
    saveGameToStorage({
      board: newBoard,
      turn: newTurn,
    });
    const newWinner = checkWinnerFrom(newBoard);
    if (newWinner) {
      confetti();
      setWinner(newWinner);
    } else if (checkEndGame(newBoard)) {
      setWinner(false);
    }
  };

  const getPlayerName = (turn) => {
    return turn === TURNS.X ? document.getElementById('playerX').value : document.getElementById('playerO').value;
  };

  return (
    <main className="board">
      <h1>Gato 3D Proyecto </h1>
      <div>
        <input id="playerX" type="text" placeholder="Nombre del Jugador X" />
        <input id="playerO" type="text" placeholder="Nombre del Jugador O" />
      </div>
      <button onClick={resetGame}>Reiniciar juego</button>
      <section className="game">
        {board.map((square, index) => (
          <Square key={index} index={index} updateBoard={updateBoard}>
            {square}
          </Square>
        ))}
      </section>

      <section className="turn">
        <Square isSelected={turn === TURNS.X}>{TURNS.X}</Square>
        <Square isSelected={turn === TURNS.O}>{TURNS.O}</Square>
      </section>

      <WinnerModal resetGame={resetGame} winner={winner} getPlayerName={getPlayerName} />
    </main>
  );
}

export default App;
