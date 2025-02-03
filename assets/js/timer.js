const startButton = document.getElementById('start');
const stopButton = document.getElementById('stop');
const timerDisplay = document.getElementById('timer');
const resultDisplay = document.getElementById('result');
const difficultySelect = document.getElementById('difficulty');

let startTime, timerInterval, visibleTime;

startButton.addEventListener('click', () => {
    resultDisplay.textContent = '';
    timerDisplay.textContent = '0.0';
    visibleTime = parseFloat(difficultySelect.value);

    startTime = Date.now();
    startButton.style.display = 'none';
    stopButton.style.display = 'inline-block';

    let elapsedTime = 0;

    timerInterval = setInterval(() => {
        elapsedTime = (Date.now() - startTime) / 1000;
        if (elapsedTime <= visibleTime) {
            timerDisplay.textContent = elapsedTime.toFixed(1);
        } else {
            timerDisplay.textContent = '';
        }
    }, 100);
});

stopButton.addEventListener('click', () => {
    clearInterval(timerInterval);
    stopButton.style.display = 'none';
    startButton.style.display = 'inline-block';

    const endTime = Date.now();
    const totalElapsed = (endTime - startTime) / 1000;

    const difference = Math.abs(10 - totalElapsed);
    let feedback = '';

    if (difference <= 0.5) {
        feedback = 'Incroyable !';
    } else if (difference <= 1) {
        feedback = 'Bien joué !';
    } else {
        feedback = 'Looseur !';
    }

    resultDisplay.innerHTML = `
                Vous avez compté ${totalElapsed.toFixed(2)} secondes.<br>
                Écart de ${difference.toFixed(2)} secondes.<br>
                ${feedback}
            `;
    saveScore(difference, "timer","ms");

});