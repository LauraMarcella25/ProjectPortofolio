/**
 * Gravity Physics Engine — Matter.js Integration
 * Creates physics bodies from portfolio elements, drag & drop, collision
 */

const { Engine, Render, Runner, Bodies, Composite, Mouse, MouseConstraint, Events, Body } = Matter;

let engine, render, runner, mouseConstraint;
let gravityEnabled = true;
let physicsBodies = [];
let originalPositions = new Map();

export function initGravity() {
    const container = document.getElementById('hero-physics-container');
    if (!container) return;

    const width = window.innerWidth;
    const height = window.innerHeight;

    // Create engine
    engine = Engine.create({
        gravity: { x: 0, y: 1, scale: 0.001 }
    });

    // Create renderer (invisible — we sync DOM elements)
    render = Render.create({
        element: container,
        engine: engine,
        options: {
            width,
            height,
            wireframes: false,
            background: 'transparent',
            pixelRatio: 1,
        }
    });
    render.canvas.style.position = 'absolute';
    render.canvas.style.top = '0';
    render.canvas.style.left = '0';
    render.canvas.style.pointerEvents = 'none';
    render.canvas.style.opacity = '0'; // Hidden — DOM-synced

    // Walls
    const wallOptions = { isStatic: true, render: { visible: false } };
    const walls = [
        Bodies.rectangle(width / 2, height + 25, width, 50, wallOptions), // floor
        Bodies.rectangle(width / 2, -25, width, 50, wallOptions), // ceiling
        Bodies.rectangle(-25, height / 2, 50, height, wallOptions), // left
        Bodies.rectangle(width + 25, height / 2, 50, height, wallOptions), // right
    ];
    Composite.add(engine.world, walls);

    // Add physics to draggable elements
    const draggables = document.querySelectorAll('[data-physics="draggable"]');
    draggables.forEach((el, i) => {
        const rect = el.getBoundingClientRect();
        const body = Bodies.rectangle(
            rect.left + rect.width / 2,
            rect.top + rect.height / 2,
            rect.width,
            rect.height,
            {
                restitution: 0.6,
                friction: 0.1,
                frictionAir: 0.02,
                density: 0.002,
                render: { visible: false },
            }
        );
        body.domElement = el;
        body.originalX = rect.left + rect.width / 2;
        body.originalY = rect.top + rect.height / 2;
        originalPositions.set(el, { x: rect.left, y: rect.top });
        physicsBodies.push(body);
        Composite.add(engine.world, body);
    });

    // Ensure hero container clips overflow to prevent infinite scroll
    container.style.overflow = 'hidden';

    // Mouse constraint for drag & drop — ONLY in hero section
    const heroSection = document.getElementById('hero');
    const mouseTarget = heroSection || container;
    const mouse = Mouse.create(mouseTarget);
    
    // Remove ALL scroll-blocking events immediately
    mouse.element.removeEventListener('mousewheel', mouse.mousewheel);
    mouse.element.removeEventListener('DOMMouseScroll', mouse.mousewheel);
    mouse.element.removeEventListener('wheel', mouse.mousewheel);
    
    mouseConstraint = MouseConstraint.create(engine, {
        mouse: mouse,
        constraint: {
            stiffness: 0.2,
            render: { visible: false }
        }
    });
    
    // Also remove from constraint's mouse reference
    mouseConstraint.mouse.element.removeEventListener('mousewheel', mouseConstraint.mouse.mousewheel);
    mouseConstraint.mouse.element.removeEventListener('DOMMouseScroll', mouseConstraint.mouse.mousewheel);

    Composite.add(engine.world, mouseConstraint);
    
    // Ensure body scroll is never blocked
    document.body.style.overflow = '';
    document.documentElement.style.overflow = '';

    // Run engine
    runner = Runner.create();
    Runner.run(runner, engine);
    Render.run(render);

    // Sync DOM with physics
    Events.on(engine, 'afterUpdate', syncDOMWithPhysics);

    // Gravity toggle
    const toggleBtn = document.getElementById('gravity-toggle');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', toggleGravity);
    }

    // Reset button
    const resetBtn = document.getElementById('reset-layout');
    if (resetBtn) {
        resetBtn.addEventListener('click', resetLayout);
    }

    // Handle resize
    window.addEventListener('resize', debounce(handleResize, 300));
}

function syncDOMWithPhysics() {
    physicsBodies.forEach(body => {
        const el = body.domElement;
        if (!el) return;

        const { x, y } = body.position;
        const angle = body.angle;

        if (body.isDecoration) {
            el.style.left = `${x - 15}px`;
            el.style.top = `${y - 15}px`;
            el.style.transform = `rotate(${angle}rad)`;
        } else {
            const rect = el.getBoundingClientRect();
            const dx = x - (rect.left + rect.width / 2);
            const dy = y - (rect.top + rect.height / 2);
            el.style.transform = `translate(${dx}px, ${dy}px) rotate(${angle}rad)`;
        }
    });
}

function toggleGravity() {
    gravityEnabled = !gravityEnabled;
    engine.gravity.y = gravityEnabled ? 1 : 0;
    engine.gravity.scale = gravityEnabled ? 0.001 : 0;

    const toggleBtn = document.getElementById('gravity-toggle');
    if (toggleBtn) {
        toggleBtn.textContent = gravityEnabled ? 'Gravity: ON' : 'Gravity: OFF';
    }

    // When gravity off, give bodies a gentle upward push
    if (!gravityEnabled) {
        physicsBodies.forEach(body => {
            Body.applyForce(body, body.position, {
                x: (Math.random() - 0.5) * 0.005,
                y: -0.005
            });
        });
    }
}

function resetLayout() {
    physicsBodies.forEach(body => {
        if (body.isDecoration) return;
        Body.setPosition(body, { x: body.originalX, y: body.originalY });
        Body.setVelocity(body, { x: 0, y: 0 });
        Body.setAngle(body, 0);
        Body.setAngularVelocity(body, 0);

        if (body.domElement) {
            body.domElement.style.transform = '';
        }
    });
}

function handleResize() {
    if (!render) return;
    const width = window.innerWidth;
    const height = window.innerHeight;
    render.options.width = width;
    render.options.height = height;
    render.canvas.width = width;
    render.canvas.height = height;
}

function debounce(fn, delay) {
    let timer;
    return (...args) => {
        clearTimeout(timer);
        timer = setTimeout(() => fn(...args), delay);
    };
}
