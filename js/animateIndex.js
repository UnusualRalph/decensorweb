document.addEventListener('DOMContentLoaded', () => {
    const logo = document.querySelector('.anarchy-symbol');
    const body = document.body;

    // 1. Create the Shout Overlay
    const shout = document.createElement('div');
    shout.id = 'shout-box';
    shout.innerText = "FUCK BEING SILENCED";
    body.appendChild(shout);

    // 2. Immediate Animation Sequence
    // Small delay to ensure the browser has painted the initial frame
    setTimeout(() => {
        shout.style.opacity = "1";
        shout.style.transform = "translateX(-50%) scale(1.1) rotate(-3deg)";
        body.classList.add('shake');

        // Remove the shake after 400ms
        setTimeout(() => body.classList.remove('shake'), 400);

        // FADE AWAY after 2 seconds
        setTimeout(() => {
            shout.style.opacity = "0";
            shout.style.transform = "translateX(-50%) scale(0.8) rotate(0deg)";
        }, 2500);
    }, 100);

    // 3. Constant Logo Glitch
    const glitch = (el) => {
        setInterval(() => {
            if (Math.random() > 0.9) {
                el.style.transform = `translate(${Math.random() * 10 - 5}px) skew(${Math.random() * 10 - 5}deg)`;
                el.style.filter = "contrast(200%) brightness(150%)";
                setTimeout(() => {
                    el.style.transform = "skew(-5deg)";
                    el.style.filter = "none";
                }, 50);
            }
        }, 150);
    };

    if (logo) glitch(logo);
});