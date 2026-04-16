import './bootstrap';
import { initParticles } from './particles';
import { initNeuralNetwork } from './neural-network';
import { initAnimations } from './animations';
import { initGravity } from './gravity';
import { initFlowers } from './flowers';

document.addEventListener('DOMContentLoaded', () => {
    // Only init portfolio effects on the public site (not admin)
    if (document.getElementById('particle-canvas')) {
        initParticles();
        initAnimations();

        // Delay gravity to let layout settle
        setTimeout(() => {
            initGravity();
        }, 500);
    }

    if (document.getElementById('neural-canvas')) {
        initNeuralNetwork();
    }

    if (document.getElementById('flower-canvas')) {
        initFlowers();
    }
});
