/**
 * Particle Background — Data Flow Simulation
 * Canvas-based interconnected particle system
 * Colors: Gold (#D4AF37) accent particles with subtle maroon streaks
 */

let canvas, ctx, particles = [], animId;
const PARTICLE_COUNT = 80;
const CONNECTION_DISTANCE = 150;
const SPEED = 0.5;

class Particle {
    constructor(w, h) {
        this.x = Math.random() * w;
        this.y = Math.random() * h;
        this.vx = (Math.random() - 0.5) * SPEED;
        this.vy = (Math.random() - 0.5) * SPEED;
        this.radius = Math.random() * 2 + 0.5;
        this.opacity = Math.random() * 0.5 + 0.1;
        this.pulseSpeed = Math.random() * 0.02 + 0.01;
        this.pulsePhase = Math.random() * Math.PI * 2;
        // Mix of gold and warm white particles
        this.isGold = Math.random() > 0.5;
    }

    update(w, h) {
        this.x += this.vx;
        this.y += this.vy;

        if (this.x < 0 || this.x > w) this.vx *= -1;
        if (this.y < 0 || this.y > h) this.vy *= -1;

        this.pulsePhase += this.pulseSpeed;
        this.currentOpacity = this.opacity + Math.sin(this.pulsePhase) * 0.15;
    }

    draw(ctx) {
        const color = this.isGold ? '212, 175, 55' : '245, 230, 211';

        ctx.beginPath();
        ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(${color}, ${this.currentOpacity})`;
        ctx.fill();

        // Glow
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.radius * 3, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(${color}, ${this.currentOpacity * 0.08})`;
        ctx.fill();
    }
}

function drawConnections(ctx) {
    for (let i = 0; i < particles.length; i++) {
        for (let j = i + 1; j < particles.length; j++) {
            const dx = particles[i].x - particles[j].x;
            const dy = particles[i].y - particles[j].y;
            const dist = Math.sqrt(dx * dx + dy * dy);

            if (dist < CONNECTION_DISTANCE) {
                const opacity = (1 - dist / CONNECTION_DISTANCE) * 0.12;
                ctx.beginPath();
                ctx.moveTo(particles[i].x, particles[i].y);
                ctx.lineTo(particles[j].x, particles[j].y);
                ctx.strokeStyle = `rgba(212, 175, 55, ${opacity})`;
                ctx.lineWidth = 0.5;
                ctx.stroke();
            }
        }
    }
}

function animate() {
    if (!canvas || !ctx) return;
    const w = canvas.width;
    const h = canvas.height;

    ctx.clearRect(0, 0, w, h);

    // Draw data flow lines (vertical streaks) — maroon
    const time = Date.now() * 0.001;
    for (let i = 0; i < 5; i++) {
        const x = (w * (i + 1)) / 6;
        const yOffset = (time * 50 + i * 200) % h;
        const gradient = ctx.createLinearGradient(x, yOffset - 100, x, yOffset + 100);
        gradient.addColorStop(0, 'rgba(122, 28, 28, 0)');
        gradient.addColorStop(0.5, 'rgba(122, 28, 28, 0.04)');
        gradient.addColorStop(1, 'rgba(122, 28, 28, 0)');
        ctx.beginPath();
        ctx.moveTo(x, yOffset - 100);
        ctx.lineTo(x, yOffset + 100);
        ctx.strokeStyle = gradient;
        ctx.lineWidth = 1;
        ctx.stroke();
    }

    particles.forEach(p => {
        p.update(w, h);
        p.draw(ctx);
    });

    drawConnections(ctx);
    animId = requestAnimationFrame(animate);
}

export function initParticles() {
    canvas = document.getElementById('particle-canvas');
    if (!canvas) return;

    ctx = canvas.getContext('2d');

    function resize() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }
    resize();
    window.addEventListener('resize', resize);

    // Create particles
    particles = [];
    for (let i = 0; i < PARTICLE_COUNT; i++) {
        particles.push(new Particle(canvas.width, canvas.height));
    }

    animate();
}

export function destroyParticles() {
    if (animId) cancelAnimationFrame(animId);
}
