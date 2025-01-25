let randomAngle;
const localStorageKey = 'anglesTrouves';

function generateRandomAngle() {
    return Math.floor(Math.random() * 361);
}

function drawAngle(angle) {
    const canvas = document.getElementById('angleCanvas');
    const ctx = canvas.getContext('2d');
    const centerX = canvas.width / 2;
    const centerY = canvas.height / 2;
    const radius = 100;

    ctx.clearRect(0, 0, canvas.width, canvas.height);

    ctx.beginPath();
    ctx.moveTo(centerX, centerY);
    ctx.arc(centerX, centerY, radius, 0, -(angle * Math.PI) / 180, true);
    ctx.closePath();
    ctx.fillStyle = 'rgba(255, 0, 0, 0.2)';
    ctx.fill();

    ctx.beginPath();
    ctx.arc(centerX, centerY, radius, 0, 2 * Math.PI);
    ctx.strokeStyle = '#000';
    ctx.stroke();

    const endX1 = centerX + radius;
    const endY1 = centerY;

    ctx.beginPath();
    ctx.moveTo(centerX, centerY);
    ctx.lineTo(endX1, endY1);
    ctx.strokeStyle = 'blue';
    ctx.lineWidth = 2;
    ctx.stroke();

    const endX2 = centerX + radius * Math.cos((angle * Math.PI) / 180);
    const endY2 = centerY - radius * Math.sin((angle * Math.PI) / 180);

    ctx.beginPath();
    ctx.moveTo(centerX, centerY);
    ctx.lineTo(endX2, endY2);
    ctx.strokeStyle = 'red';
    ctx.lineWidth = 2;
    ctx.stroke();
}

function updateScore() {
    const currentScore = parseInt(localStorage.getItem(localStorageKey)) || 0;
    localStorage.setItem(localStorageKey, currentScore + 1);
    console.log('Angles trouvés :', currentScore + 1);
}

function init() {
    randomAngle = generateRandomAngle();
    drawAngle(randomAngle);
    console.log('Angle aléatoire (debug) :', randomAngle);
}

document.getElementById('submitGuess').addEventListener('click', () => {
    const userGuess = parseInt(document.getElementById('guessInput').value, 10);
    const messageElement = document.getElementById('resultMessage');

    if (isNaN(userGuess)) {
        messageElement.textContent = 'Veuillez entrer un nombre valide !';
        messageElement.style.color = 'red';
        return;
    }

    if (userGuess === randomAngle) {
        messageElement.textContent = 'Bravo ! Vous avez deviné le bon angle !';
        messageElement.style.color = 'green';
        updateScore();
        init();
        document.getElementById('guessInput').value = '';
    } else if (userGuess < randomAngle) {
        messageElement.textContent = 'Trop petit ! Essayez encore.';
        messageElement.style.color = 'orange';
    } else {
        messageElement.textContent = 'Trop grand ! Essayez encore.';
        messageElement.style.color = 'orange';
    }
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Enter') {
        document.getElementById('submitGuess').click();
    }
});

init();