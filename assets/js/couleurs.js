const colorCodeElement = document.getElementById('color-code');
const colorButtonsContainer = document.getElementById('color-buttons');
const difficultySelect = document.getElementById('difficulty');
const scoreElement = document.getElementById('score');

let correctColor;
let score = localStorage.getItem('colorGuessingGameScore') || 0;

function updateScore(points) {
    score = parseInt(score, 10) + points;
    localStorage.setItem('colorGuessingGameScore', score);
    scoreElement.textContent = `Score: ${score}`;
}

function getRandomColor() {
    const r = Math.floor(Math.random() * 256);
    const g = Math.floor(Math.random() * 256);
    const b = Math.floor(Math.random() * 256);
    return `rgb(${r}, ${g}, ${b})`;
}

function colorToHex(color) {
    const rgb = color.match(/\d+/g).map(Number);
    return `#${rgb.map(x => x.toString(16).padStart(2, '0')).join('')}`.toUpperCase();
}

function generateColors(baseColor, difficulty) {
    const baseRgb = baseColor.match(/\d+/g).map(Number);
    const colors = [baseColor];

    while (colors.length < 4) {
        const variation = baseRgb.map(c => {
            let variation = c + (Math.random() * difficulty * 2 - difficulty);
            return Math.max(0, Math.min(255, Math.round(variation)));
        });
        const newColor = `rgb(${variation.join(', ')})`;
        if (!colors.includes(newColor)) {
            colors.push(newColor);
        }
    }
    return colors.sort(() => Math.random() - 0.5);
}

function startGame() {
    const difficulty = parseInt(difficultySelect.value, 10);
    const points = difficulty === 50 ? 1 : difficulty === 30 ? 3 : 10;
    correctColor = getRandomColor();
    const colors = generateColors(correctColor, difficulty);
    const correctHex = colorToHex(correctColor);

    colorCodeElement.textContent = correctHex;
    colorButtonsContainer.innerHTML = '';

    colors.forEach(color => {
        const button = document.createElement('button');
        button.style.backgroundColor = color;
        button.onclick = () => {
            if (color === correctColor) {
                alert('Bravo ! Bonne réponse !');
                updateScore(points);
            } else {
                alert('Incorrect, essayez encore !');
            }
            startGame();
        };
        colorButtonsContainer.appendChild(button);
    });
}

scoreElement.textContent = `Score: ${score}`;
startGame();