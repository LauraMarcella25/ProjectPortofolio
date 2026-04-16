/**
 * Animated Botanical Flowers — Canvas-based
 * Procedural wildflowers, dandelions, stems, and floating seeds
 * Colors: Gold (#D4AF37), Maroon (#7A1C1C), Cream (#F5E6D3)
 */

let flowerCanvas, flowerCtx, flowerAnimId;
let stems = [];
let floatingSeeds = [];
let time = 0;

// Color palette
const COLORS = {
    gold: '#D4AF37',
    goldLight: '#E4C55A',
    maroon: '#7A1C1C',
    maroonLight: '#9B2C2C',
    cream: '#F5E6D3',
    creamDark: '#E8D5BF',
    warmWhite: '#FAF0E6',
    brownLight: '#C4A265',
    brownDark: '#8B6914',
    greenDark: '#3D5C2E',
    greenMuted: '#5A6B4A',
};

function hexToRgba(hex, alpha) {
    const r = parseInt(hex.slice(1, 3), 16);
    const g = parseInt(hex.slice(3, 5), 16);
    const b = parseInt(hex.slice(5, 7), 16);
    return `rgba(${r}, ${g}, ${b}, ${alpha})`;
}

// ========== STEM CLASS ==========
class Stem {
    constructor(canvas) {
        this.x = Math.random() * canvas.width;
        this.baseY = canvas.height;
        this.height = 80 + Math.random() * 200;
        this.thickness = 1 + Math.random() * 1.5;
        this.swayAmount = 0.3 + Math.random() * 0.7;
        this.swaySpeed = 0.5 + Math.random() * 0.5;
        this.swayOffset = Math.random() * Math.PI * 2;
        this.color = this.pickStemColor();
        this.opacity = 0.5 + Math.random() * 0.4;

        // Determine flower type
        const rand = Math.random();
        if (rand < 0.15) {
            this.flowerType = 'dandelion';
        } else if (rand < 0.30) {
            this.flowerType = 'wildflower';
        } else if (rand < 0.45) {
            this.flowerType = 'wheat';
        } else if (rand < 0.6) {
            this.flowerType = 'daisy';
        } else if (rand < 0.75) {
            this.flowerType = 'bud';
        } else {
            this.flowerType = 'grass';
        }

        this.flowerSize = 3 + Math.random() * 8;
        this.flowerColor = this.pickFlowerColor();
        this.petalCount = 5 + Math.floor(Math.random() * 4);
        this.leafCount = Math.floor(Math.random() * 3);
        this.leafPositions = [];
        for (let i = 0; i < this.leafCount; i++) {
            this.leafPositions.push({
                t: 0.3 + Math.random() * 0.5,
                side: Math.random() > 0.5 ? 1 : -1,
                size: 6 + Math.random() * 10,
            });
        }
    }

    pickStemColor() {
        const colors = [COLORS.greenDark, COLORS.greenMuted, COLORS.brownDark, '#5C6B3A', '#4A5C3A'];
        return colors[Math.floor(Math.random() * colors.length)];
    }

    pickFlowerColor() {
        const colors = [COLORS.gold, COLORS.goldLight, COLORS.cream, COLORS.warmWhite, COLORS.maroon, COLORS.maroonLight, COLORS.creamDark, COLORS.brownLight];
        return colors[Math.floor(Math.random() * colors.length)];
    }

    getSway(t) {
        return Math.sin(t * this.swaySpeed + this.swayOffset) * this.swayAmount * 15;
    }

    getPoint(fraction, t) {
        const sway = this.getSway(t) * fraction * fraction;
        const x = this.x + sway;
        const y = this.baseY - this.height * fraction;
        return { x, y };
    }

    draw(ctx, t) {
        ctx.save();
        ctx.globalAlpha = this.opacity;

        // Draw stem as a curved line
        ctx.beginPath();
        ctx.moveTo(this.x, this.baseY);

        const segments = 12;
        for (let i = 1; i <= segments; i++) {
            const frac = i / segments;
            const pt = this.getPoint(frac, t);
            ctx.lineTo(pt.x, pt.y);
        }

        ctx.strokeStyle = hexToRgba(this.color, 0.7);
        ctx.lineWidth = this.thickness;
        ctx.stroke();

        // Draw leaves
        this.leafPositions.forEach(leaf => {
            const pt = this.getPoint(leaf.t, t);
            const nextPt = this.getPoint(leaf.t + 0.05, t);
            const angle = Math.atan2(nextPt.y - pt.y, nextPt.x - pt.x);

            ctx.save();
            ctx.translate(pt.x, pt.y);
            ctx.rotate(angle + (leaf.side > 0 ? -0.5 : 0.5) + Math.sin(t * 0.8 + this.swayOffset) * 0.1);

            ctx.beginPath();
            ctx.moveTo(0, 0);
            ctx.quadraticCurveTo(leaf.size * 0.5 * leaf.side, -leaf.size * 0.3, leaf.size * leaf.side, 0);
            ctx.quadraticCurveTo(leaf.size * 0.5 * leaf.side, leaf.size * 0.2, 0, 0);
            ctx.fillStyle = hexToRgba(this.color, 0.5);
            ctx.fill();
            ctx.restore();
        });

        // Draw flower at top
        const tip = this.getPoint(1, t);
        const preTip = this.getPoint(0.95, t);
        const tipAngle = Math.atan2(tip.y - preTip.y, tip.x - preTip.x);

        ctx.save();
        ctx.translate(tip.x, tip.y);

        switch (this.flowerType) {
            case 'dandelion':
                this.drawDandelion(ctx, t);
                break;
            case 'wildflower':
                this.drawWildflower(ctx, t);
                break;
            case 'wheat':
                this.drawWheat(ctx, tipAngle, t);
                break;
            case 'daisy':
                this.drawDaisy(ctx, t);
                break;
            case 'bud':
                this.drawBud(ctx, tipAngle, t);
                break;
            case 'grass':
                // Just the stem, no flower head
                break;
        }

        ctx.restore();
        ctx.restore();
    }

    drawDandelion(ctx, t) {
        const size = this.flowerSize * 1.5;
        const seedCount = 12 + Math.floor(Math.random() * 6);

        // Draw seed head
        for (let i = 0; i < seedCount; i++) {
            const angle = (i / seedCount) * Math.PI * 2 + Math.sin(t * 0.3 + i) * 0.05;
            const len = size * (0.8 + Math.sin(t * 0.5 + i * 0.5) * 0.15);

            ctx.beginPath();
            ctx.moveTo(0, 0);
            const endX = Math.cos(angle) * len;
            const endY = Math.sin(angle) * len;
            ctx.lineTo(endX, endY);
            ctx.strokeStyle = hexToRgba(COLORS.warmWhite, 0.4);
            ctx.lineWidth = 0.5;
            ctx.stroke();

            // Tiny fluff at the end
            ctx.beginPath();
            ctx.arc(endX, endY, 1.5, 0, Math.PI * 2);
            ctx.fillStyle = hexToRgba(COLORS.warmWhite, 0.6);
            ctx.fill();
        }

        // Center dot
        ctx.beginPath();
        ctx.arc(0, 0, 2, 0, Math.PI * 2);
        ctx.fillStyle = hexToRgba(COLORS.creamDark, 0.6);
        ctx.fill();
    }

    drawWildflower(ctx, t) {
        const size = this.flowerSize;
        const petals = this.petalCount;

        for (let i = 0; i < petals; i++) {
            const angle = (i / petals) * Math.PI * 2 + Math.sin(t * 0.4) * 0.08;
            ctx.save();
            ctx.rotate(angle);
            ctx.beginPath();
            ctx.ellipse(0, -size * 0.6, size * 0.3, size * 0.6, 0, 0, Math.PI * 2);
            ctx.fillStyle = hexToRgba(this.flowerColor, 0.6);
            ctx.fill();
            ctx.restore();
        }

        // Center
        ctx.beginPath();
        ctx.arc(0, 0, size * 0.2, 0, Math.PI * 2);
        ctx.fillStyle = hexToRgba(COLORS.gold, 0.7);
        ctx.fill();
    }

    drawDaisy(ctx, t) {
        const size = this.flowerSize * 0.8;
        const petals = 8;

        for (let i = 0; i < petals; i++) {
            const angle = (i / petals) * Math.PI * 2 + Math.sin(t * 0.3 + this.swayOffset) * 0.06;
            ctx.save();
            ctx.rotate(angle);
            ctx.beginPath();
            ctx.ellipse(0, -size * 0.5, size * 0.18, size * 0.45, 0, 0, Math.PI * 2);
            ctx.fillStyle = hexToRgba(COLORS.warmWhite, 0.55);
            ctx.fill();
            ctx.restore();
        }

        ctx.beginPath();
        ctx.arc(0, 0, size * 0.22, 0, Math.PI * 2);
        ctx.fillStyle = hexToRgba(COLORS.goldLight, 0.7);
        ctx.fill();
    }

    drawWheat(ctx, stemAngle, t) {
        const size = this.flowerSize;
        const grains = 5 + Math.floor(Math.random() * 4);

        for (let i = 0; i < grains; i++) {
            const offset = i * 4;
            const side = i % 2 === 0 ? -1 : 1;
            const sway = Math.sin(t * 0.6 + i * 0.3) * 2;

            ctx.save();
            ctx.translate(sway * 0.2, -offset);
            ctx.rotate(side * 0.4 + Math.sin(t * 0.5 + i) * 0.1);

            ctx.beginPath();
            ctx.ellipse(side * 3, 0, size * 0.25, size * 0.1, side * 0.3, 0, Math.PI * 2);
            ctx.fillStyle = hexToRgba(COLORS.goldLight, 0.5);
            ctx.fill();

            ctx.restore();
        }
    }

    drawBud(ctx, stemAngle, t) {
        const size = this.flowerSize * 0.6;
        const sway = Math.sin(t * 0.5 + this.swayOffset) * 0.1;

        ctx.save();
        ctx.rotate(sway);

        // Bud petals (closed)
        ctx.beginPath();
        ctx.ellipse(0, -size * 0.3, size * 0.25, size * 0.5, 0, 0, Math.PI * 2);
        ctx.fillStyle = hexToRgba(this.flowerColor, 0.5);
        ctx.fill();

        // Sepals
        ctx.beginPath();
        ctx.moveTo(-size * 0.15, size * 0.1);
        ctx.quadraticCurveTo(-size * 0.3, -size * 0.2, 0, -size * 0.5);
        ctx.quadraticCurveTo(size * 0.3, -size * 0.2, size * 0.15, size * 0.1);
        ctx.fillStyle = hexToRgba(this.color, 0.4);
        ctx.fill();
        ctx.restore();
    }
}

// ========== FLOATING SEED CLASS ==========
class FloatingSeed {
    constructor(canvas) {
        this.reset(canvas);
    }

    reset(canvas) {
        this.x = Math.random() * canvas.width;
        this.y = canvas.height * (0.5 + Math.random() * 0.5);
        this.size = 1 + Math.random() * 2;
        this.speedX = -0.2 + Math.random() * 0.4;
        this.speedY = -0.3 - Math.random() * 0.5;
        this.opacity = 0.2 + Math.random() * 0.4;
        this.rotation = Math.random() * Math.PI * 2;
        this.rotSpeed = (Math.random() - 0.5) * 0.02;
        this.wobbleAmp = 0.5 + Math.random() * 1.5;
        this.wobbleSpeed = 1 + Math.random() * 2;
        this.wobbleOffset = Math.random() * Math.PI * 2;
        this.hasFluff = Math.random() > 0.5;
        this.life = 1;
        this.lifeSpeed = 0.001 + Math.random() * 0.002;
    }

    update(canvas, t) {
        this.x += this.speedX + Math.sin(t * this.wobbleSpeed + this.wobbleOffset) * this.wobbleAmp * 0.3;
        this.y += this.speedY;
        this.rotation += this.rotSpeed;
        this.life -= this.lifeSpeed;

        if (this.life <= 0 || this.y < -20 || this.x < -20 || this.x > canvas.width + 20) {
            this.reset(canvas);
            this.y = canvas.height + 10;
            this.life = 1;
        }
    }

    draw(ctx, t) {
        const alpha = this.opacity * Math.min(this.life, 1);
        if (alpha <= 0) return;

        ctx.save();
        ctx.translate(this.x, this.y);
        ctx.rotate(this.rotation);
        ctx.globalAlpha = alpha;

        if (this.hasFluff) {
            // Dandelion seed with fluff
            const fluffLines = 6;
            for (let i = 0; i < fluffLines; i++) {
                const angle = (i / fluffLines) * Math.PI * 2;
                const len = this.size * 3;
                ctx.beginPath();
                ctx.moveTo(0, 0);
                ctx.lineTo(Math.cos(angle) * len, Math.sin(angle) * len);
                ctx.strokeStyle = COLORS.warmWhite;
                ctx.lineWidth = 0.3;
                ctx.stroke();

                ctx.beginPath();
                ctx.arc(Math.cos(angle) * len, Math.sin(angle) * len, 0.6, 0, Math.PI * 2);
                ctx.fillStyle = COLORS.warmWhite;
                ctx.fill();
            }
            // Seed body
            ctx.beginPath();
            ctx.ellipse(0, this.size * 2, 0.5, this.size, 0, 0, Math.PI * 2);
            ctx.fillStyle = COLORS.brownLight;
            ctx.fill();
        } else {
            // Simple petal / leaf piece
            ctx.beginPath();
            ctx.ellipse(0, 0, this.size * 0.5, this.size * 1.2, 0, 0, Math.PI * 2);
            const petalColors = [COLORS.gold, COLORS.cream, COLORS.maroon, COLORS.warmWhite];
            ctx.fillStyle = petalColors[Math.floor(Math.random() * petalColors.length)];
            ctx.fill();
        }

        ctx.restore();
    }
}

// ========== INITIALIZATION ==========
function createStems(canvas) {
    stems = [];
    const count = Math.floor(canvas.width / 18); // density based on width

    for (let i = 0; i < count; i++) {
        const stem = new Stem(canvas);
        // Distribute: denser on edges, sparser in center
        const distribution = Math.random();
        if (distribution < 0.35) {
            stem.x = Math.random() * canvas.width * 0.25; // left 25%
        } else if (distribution < 0.7) {
            stem.x = canvas.width * 0.75 + Math.random() * canvas.width * 0.25; // right 25%
        } else {
            stem.x = canvas.width * 0.25 + Math.random() * canvas.width * 0.5; // middle 50% (sparser)
        }
        // Vary height: taller at edges
        const distFromCenter = Math.abs(stem.x - canvas.width / 2) / (canvas.width / 2);
        stem.height = (60 + Math.random() * 120) * (0.6 + distFromCenter * 0.6);
        stem.opacity = 0.3 + distFromCenter * 0.3;

        stems.push(stem);
    }

    // Sort by x for layering
    stems.sort((a, b) => a.height - b.height);
}

function createSeeds(canvas) {
    floatingSeeds = [];
    const count = 15 + Math.floor(canvas.width / 100);
    for (let i = 0; i < count; i++) {
        floatingSeeds.push(new FloatingSeed(canvas));
    }
}

function drawFlowerScene() {
    if (!flowerCanvas || !flowerCtx) return;

    const ctx = flowerCtx;
    const w = flowerCanvas.width;
    const h = flowerCanvas.height;

    ctx.clearRect(0, 0, w, h);

    // Top gradient fade (blend into dark background above)
    const topGrad = ctx.createLinearGradient(0, 0, 0, h * 0.5);
    topGrad.addColorStop(0, 'rgba(18, 18, 18, 1)');
    topGrad.addColorStop(0.6, 'rgba(18, 18, 18, 0.6)');
    topGrad.addColorStop(1, 'rgba(18, 18, 18, 0)');
    ctx.fillStyle = topGrad;
    ctx.fillRect(0, 0, w, h * 0.5);

    time += 0.016;

    // Draw floating seeds (behind stems)
    floatingSeeds.forEach(seed => {
        seed.update(flowerCanvas, time);
        seed.draw(ctx, time);
    });

    // Draw stems and flowers
    stems.forEach(stem => {
        stem.draw(ctx, time);
    });

    // Bottom ground gradient
    const groundGrad = ctx.createLinearGradient(0, h - 15, 0, h);
    groundGrad.addColorStop(0, 'rgba(18, 18, 18, 0)');
    groundGrad.addColorStop(1, 'rgba(18, 18, 18, 0.8)');
    ctx.fillStyle = groundGrad;
    ctx.fillRect(0, h - 15, w, 15);

    flowerAnimId = requestAnimationFrame(drawFlowerScene);
}

function resizeFlowerCanvas() {
    if (!flowerCanvas) return;
    const container = flowerCanvas.parentElement;
    if (!container) return;

    flowerCanvas.width = container.offsetWidth;
    flowerCanvas.height = container.offsetHeight;

    createStems(flowerCanvas);
    createSeeds(flowerCanvas);
}

export function initFlowers() {
    flowerCanvas = document.getElementById('flower-canvas');
    if (!flowerCanvas) return;

    flowerCtx = flowerCanvas.getContext('2d');

    resizeFlowerCanvas();

    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(resizeFlowerCanvas, 300);
    });

    drawFlowerScene();
}

export function destroyFlowers() {
    if (flowerAnimId) cancelAnimationFrame(flowerAnimId);
}
