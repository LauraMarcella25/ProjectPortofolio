/**
 * Neural Network Visualization — Skills Section
 * Animated graph of interconnected nodes
 * Colors: Gold, Maroon, Cream
 */

let neuralCanvas, neuralCtx, nodes = [], edges = [], neuralAnimId;

class NeuralNode {
    constructor(x, y, label, layer) {
        this.x = x;
        this.y = y;
        this.label = label;
        this.layer = layer;
        this.radius = 6;
        this.pulsePhase = Math.random() * Math.PI * 2;
        this.pulseSpeed = 0.03 + Math.random() * 0.02;
        this.baseOpacity = 0.6 + Math.random() * 0.4;
        // Gold → Maroon → Cream → Gold layers
        this.color = layer === 0 ? '212, 175, 55' :
                     layer === 1 ? '122, 28, 28' :
                     layer === 2 ? '245, 230, 211' : '212, 175, 55';
    }

    update() {
        this.pulsePhase += this.pulseSpeed;
        this.currentRadius = this.radius + Math.sin(this.pulsePhase) * 2;
        this.currentOpacity = this.baseOpacity + Math.sin(this.pulsePhase) * 0.2;
    }

    draw(ctx) {
        // Outer glow
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.currentRadius * 4, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(${this.color}, ${this.currentOpacity * 0.08})`;
        ctx.fill();

        // Node
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.currentRadius, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(${this.color}, ${this.currentOpacity})`;
        ctx.fill();

        // Inner highlight
        ctx.beginPath();
        ctx.arc(this.x - 1, this.y - 1, this.currentRadius * 0.4, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(255, 255, 255, ${this.currentOpacity * 0.5})`;
        ctx.fill();
    }
}

class DataFlow {
    constructor(edge) {
        this.edge = edge;
        this.progress = Math.random();
        this.speed = 0.003 + Math.random() * 0.005;
        this.opacity = 0.5 + Math.random() * 0.5;
    }

    update() {
        this.progress += this.speed;
        if (this.progress > 1) this.progress = 0;
    }

    draw(ctx) {
        const { from, to } = this.edge;
        const x = from.x + (to.x - from.x) * this.progress;
        const y = from.y + (to.y - from.y) * this.progress;

        ctx.beginPath();
        ctx.arc(x, y, 2, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(212, 175, 55, ${this.opacity})`;
        ctx.fill();

        // Trail
        const trailProgress = this.progress - 0.03;
        if (trailProgress > 0) {
            const tx = from.x + (to.x - from.x) * trailProgress;
            const ty = from.y + (to.y - from.y) * trailProgress;
            ctx.beginPath();
            ctx.arc(tx, ty, 1, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(212, 175, 55, ${this.opacity * 0.3})`;
            ctx.fill();
        }
    }
}

let dataFlows = [];

function createNeuralNetwork(w, h) {
    nodes = [];
    edges = [];
    dataFlows = [];

    const layers = [
        ['Input', 'Data', 'Features', 'Raw'],
        ['Conv', 'Dense', 'LSTM', 'Attention', 'Pool'],
        ['ReLU', 'Softmax', 'Batch', 'Drop'],
        ['Output', 'Predict', 'Class'],
    ];

    const layerGap = w / (layers.length + 1);

    layers.forEach((layer, li) => {
        const nodeGap = h / (layer.length + 1);
        layer.forEach((label, ni) => {
            const x = layerGap * (li + 1);
            const y = nodeGap * (ni + 1);
            nodes.push(new NeuralNode(x, y, label, li));
        });
    });

    // Connect adjacent layers
    let offset = 0;
    for (let li = 0; li < layers.length - 1; li++) {
        const currentLayerSize = layers[li].length;
        const nextLayerSize = layers[li + 1].length;
        const nextOffset = offset + currentLayerSize;

        for (let i = 0; i < currentLayerSize; i++) {
            for (let j = 0; j < nextLayerSize; j++) {
                const from = nodes[offset + i];
                const to = nodes[nextOffset + j];
                edges.push({ from, to });
            }
        }
        offset += currentLayerSize;
    }

    // Create data flows
    edges.forEach(edge => {
        if (Math.random() > 0.6) {
            dataFlows.push(new DataFlow(edge));
        }
    });
}

function animateNeural() {
    if (!neuralCanvas || !neuralCtx) return;
    const w = neuralCanvas.width;
    const h = neuralCanvas.height;

    neuralCtx.clearRect(0, 0, w, h);

    // Draw edges
    edges.forEach(({ from, to }) => {
        neuralCtx.beginPath();
        neuralCtx.moveTo(from.x, from.y);
        neuralCtx.lineTo(to.x, to.y);
        neuralCtx.strokeStyle = 'rgba(212, 175, 55, 0.06)';
        neuralCtx.lineWidth = 0.5;
        neuralCtx.stroke();
    });

    // Draw data flows
    dataFlows.forEach(flow => {
        flow.update();
        flow.draw(neuralCtx);
    });

    // Draw nodes
    nodes.forEach(node => {
        node.update();
        node.draw(neuralCtx);
    });

    neuralAnimId = requestAnimationFrame(animateNeural);
}

export function initNeuralNetwork() {
    neuralCanvas = document.getElementById('neural-canvas');
    if (!neuralCanvas) return;

    neuralCtx = neuralCanvas.getContext('2d');

    function resize() {
        const rect = neuralCanvas.parentElement.getBoundingClientRect();
        neuralCanvas.width = rect.width;
        neuralCanvas.height = neuralCanvas.offsetHeight;
        createNeuralNetwork(neuralCanvas.width, neuralCanvas.height);
    }

    resize();
    window.addEventListener('resize', resize);
    animateNeural();
}

export function destroyNeuralNetwork() {
    if (neuralAnimId) cancelAnimationFrame(neuralAnimId);
}
