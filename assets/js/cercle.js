const canvas = document.getElementById('drawingCanvas');
const ctx = canvas.getContext('2d');
let isDrawing = false;
let points = [];

canvas.addEventListener('mousedown', (e) => {
    isDrawing = true;
    points = [];
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.beginPath();
    ctx.moveTo(e.offsetX, e.offsetY);
    points.push({x: e.offsetX, y: e.offsetY});
});

canvas.addEventListener('mousemove', (e) => {
    if (isDrawing) {
        ctx.lineTo(e.offsetX, e.offsetY);
        ctx.stroke();
        points.push({x: e.offsetX, y: e.offsetY});
    }
});

canvas.addEventListener('mouseup', () => {
    isDrawing = false;
    ctx.closePath();
    calculateScore();
});

function calculateScore() {
    if (points.length < 2) return;

    let sumX = 0, sumY = 0;
    points.forEach(point => {
        sumX += point.x;
        sumY += point.y;
    });
    const centerX = sumX / points.length;
    const centerY = sumY / points.length;

    let radiusSum = 0;
    points.forEach(point => {
        const dx = point.x - centerX;
        const dy = point.y - centerY;
        radiusSum += Math.sqrt(dx * dx + dy * dy);
    });
    const avgRadius = radiusSum / points.length;

    let varianceSum = 0;
    points.forEach(point => {
        const dx = point.x - centerX;
        const dy = point.y - centerY;
        const radius = Math.sqrt(dx * dx + dy * dy);
        varianceSum += Math.pow(radius - avgRadius, 2);
    });
    const variance = varianceSum / points.length;

    const score = Math.max(0, 100 - Math.sqrt(variance));

    document.getElementById('score').textContent = `Your score: ${score.toFixed(2)}`;
}

function resetCanvas() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    document.getElementById('score').textContent = 'Your score: N/A';
}