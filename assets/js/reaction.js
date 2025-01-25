const gameScreen = document.getElementById('game-screen');
const message = document.getElementById('message');
const averageDisplay = document.getElementById('average');

let waiting = false;
let startTime;

function calculateAverage(times) {
    if (times.length === 0) return 0;
    const sum = times.reduce((a, b) => a + b, 0);
    return Math.round(sum / times.length);
}

let reactionTimes = JSON.parse(localStorage.getItem('reactionTimes')) || [];
averageDisplay.textContent = `Temps moyen: ${calculateAverage(reactionTimes)} ms`;

gameScreen.addEventListener('click', () => {
    if (waiting) {
        const reactionTime = Date.now() - startTime;
        reactionTimes.push(reactionTime);
        localStorage.setItem('reactionTimes', JSON.stringify(reactionTimes));

        gameScreen.style.backgroundColor = 'red';
        gameScreen.textContent = 'Cliquez pour recommencer';
        message.textContent = `Votre temps de réaction est de ${reactionTime} ms.`;

        averageDisplay.textContent = `Temps moyen: ${calculateAverage(reactionTimes)} ms`;
        waiting = false;
    } else {
        gameScreen.textContent = 'Patientez...';
        message.textContent = '';
        gameScreen.style.backgroundColor = 'red';

        const randomDelay = Math.random() * 2000 + 1000;
        setTimeout(() => {
            gameScreen.style.backgroundColor = 'green';
            gameScreen.textContent = 'Cliquez maintenant !';
            startTime = Date.now();
            waiting = true;
        }, randomDelay);
    }
});