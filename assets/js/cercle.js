const canvas = document.getElementById('drawingCanvas');
const ctx = canvas.getContext('2d');
let isDrawing = false;
let points = [];
const MINIMUM_RADIUS = 50;
const MINIMUM_DIVERSITY = 0.2;

function getEventCoords(e) {
    if (e.touches && e.touches[0]) {
        const rect = canvas.getBoundingClientRect();
        return {
            x: e.touches[0].clientX - rect.left,
            y: e.touches[0].clientY - rect.top
        };
    } else {
        return {
            x: e.offsetX,
            y: e.offsetY
        };
    }
}

function startDrawing(e) {
    const { x, y } = getEventCoords(e);
    isDrawing = true;
    points = [];
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.beginPath();
    ctx.moveTo(x, y);
    points.push({ x, y });
}

function draw(e) {
    if (isDrawing) {
        const { x, y } = getEventCoords(e);
        ctx.lineTo(x, y);
        ctx.stroke();
        points.push({ x, y });
    }
}

function stopDrawing() {
    if (isDrawing) {
        isDrawing = false;
        ctx.closePath();

        if (isCircleBigEnough() && isShapeDiverse()) {
            calculateScore();
        } else if (!isCircleBigEnough()) {
            document.getElementById('score').textContent = `Votre cercle est trop petit. Essayez encore !`;
        } else {
            document.getElementById('score').textContent = `Tu joues a quoi fais un cercle on a dit !`;
        }
    }
}

function isCircleBigEnough() {
    if (points.length < 2) return false;

    let minX = points[0].x;
    let maxX = points[0].x;
    let minY = points[0].y;
    let maxY = points[0].y;

    points.forEach(point => {
        if (point.x < minX) minX = point.x;
        if (point.x > maxX) maxX = point.x;
        if (point.y < minY) minY = point.y;
        if (point.y > maxY) maxY = point.y;
    });

    const width = maxX - minX;
    const height = maxY - minY;
    const diameter = Math.max(width, height);

    return diameter >= MINIMUM_RADIUS;
}

function isShapeDiverse() {
    if (points.length < 3) return false;

    let totalAngleChange = 0;

    for (let i = 1; i < points.length - 1; i++) {
        const dx1 = points[i].x - points[i - 1].x;
        const dy1 = points[i].y - points[i - 1].y;
        const dx2 = points[i + 1].x - points[i].x;
        const dy2 = points[i + 1].y - points[i].y;

        const angle1 = Math.atan2(dy1, dx1);
        const angle2 = Math.atan2(dy2, dx2);

        const angleChange = Math.abs(angle2 - angle1);
        totalAngleChange += angleChange;
    }

    const averageAngleChange = totalAngleChange / (points.length - 2);

    return averageAngleChange >= MINIMUM_DIVERSITY;
}

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

    document.getElementById('score').textContent = `Votre score : ${score.toFixed(2)}`;
}

function resetCanvas() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    document.getElementById('score').textContent = 'Votre score : N/A';
}

canvas.addEventListener('mousedown', startDrawing);
canvas.addEventListener('mousemove', draw);
canvas.addEventListener('mouseup', stopDrawing);

canvas.addEventListener('touchstart', (e) => {
    e.preventDefault();
    startDrawing(e);
});
canvas.addEventListener('touchmove', (e) => {
    e.preventDefault();
    draw(e);
});
canvas.addEventListener('touchend', (e) => {
    e.preventDefault();
    stopDrawing(e);
});
