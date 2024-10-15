(function() {
    let decorations = [
        '❄️'
    ];
    let altDecorations = ['🍄', '🏕', '⛺'];
    let snowflakeClicks = 0;
    const windDirections = ['left', 'right', 'up', 'down'];
    const windStrength = Math.random() * 1 + 1;
    const windDirection = windDirections[Math.floor(Math.random() * windDirections.length)];

    function createDecoration() {
        let decoration = document.createElement('div');
        decoration.classList.add('christmas-decoration');
        if (snowflakeClicks < 5) {
            decoration.textContent = decorations[Math.floor(Math.random() * decorations.length)];
        } else {
            decoration.textContent = altDecorations[Math.floor(Math.random() * altDecorations.length)];
        }
        decoration.style.left = Math.random() * 100 + 'vw';
        decoration.style.fontSize = (Math.random() * 1.5 + 1) + 'rem';
        decoration.style.transform = `rotate(${Math.random() * 360}deg)`;
        decoration.style.animationDuration = (Math.random() * 2 + 3) / windStrength + 's';
        decoration.style.cursor = 'pointer';
        document.body.appendChild(decoration);

        decoration.addEventListener('click', () => {
            if (decoration.textContent === '❄️') {
                snowflakeClicks++;
            }
            decoration.remove();
        });

        setTimeout(() => {
            decoration.remove();
        }, 5000);
    }

    setInterval(createDecoration, 1000);

    let style = document.createElement('style');
    style.innerHTML = `
        .christmas-decoration {
            position: fixed;
            top: -50px;
            animation: fall linear infinite;
            pointer-events: auto;
            filter: brightness(1.2);
        }
        @keyframes fall {
            to {
                transform: translateY(100vh) ${windDirection === 'left' ? 'translateX(-' + windStrength * 10 + 'vw)' : windDirection === 'right' ? 'translateX(' + windStrength * 10 + 'vw)' : windDirection === 'up' ? 'translateY(-' + windStrength * 10 + 'vh)' : 'translateY(' + windStrength * 10 + 'vh)'};
            }
        }
        .wind-indicator {
            position: fixed;
            ${windDirection === 'left' ? 'left: 0;' : windDirection === 'right' ? 'right: 0;' : windDirection === 'up' ? 'top: 0;' : 'bottom: 0;'}
            font-size: 3rem;
            opacity: ${windStrength / 3};
            animation: move-wind ${5 / windStrength}s linear infinite;
        }
        @keyframes move-wind {
            to {
                ${windDirection === 'left' ? 'transform: translateX(100vw);' : windDirection === 'right' ? 'transform: translateX(-100vw);' : windDirection === 'up' ? 'transform: translateY(100vh);' : 'transform: translateY(-100vh);'}
            }
        }
    `;
    document.head.appendChild(style);

    let windIndicator = document.createElement('div');
    windIndicator.classList.add('wind-indicator');
    windIndicator.textContent = '💨';
    document.body.appendChild(windIndicator);

    // Start creating decorations immediately
    for (let i = 0; i < 10; i++) {
        createDecoration();
    }
})();
