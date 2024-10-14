(function() {
    let decorations = [
        '🎄', '🍄', '❄️', '❄️', '❄️', '❄️'
    ];

    function createDecoration() {
        let decoration = document.createElement('div');
        decoration.classList.add('christmas-decoration');
        decoration.textContent = decorations[Math.floor(Math.random() * decorations.length)];
        decoration.style.left = Math.random() * 100 + 'vw';
        decoration.style.animationDuration = Math.random() * 2 + 3 + 's';
        document.body.appendChild(decoration);

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
            font-size: 2rem;
            animation: fall linear infinite;
        }
        @keyframes fall {
            to {
                transform: translateY(100vh);
            }
        }
    `;
    document.head.appendChild(style);
})();
