import React from 'react';

export function Square({ children, isSelected, updateBoard, index }) {
  const className = `square ${isSelected ? 'isSelected' : ''} ${children === 'X' ? 'x' : children === 'O' ? 'o' : ''}`;

  const handleClick = () => {
    updateBoard(index);
  };

  return (
    <div className={className} onClick={handleClick}>
      {children}
    </div>
  );
}
