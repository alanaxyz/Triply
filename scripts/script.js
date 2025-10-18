let index = 0;
    const slides = document.querySelectorAll("#carousel img");

    function mostrarSlide() {
        document.getElementById("carousel").style.transform = `translateX(${-index * 100}%)`;
    }

    function moverSlide(direcao) {
        index += direcao;
        if (index < 0) index = slides.length - 1;
        if (index >= slides.length) index = 0;
        mostrarSlide();
    }

    setInterval(() => {
        moverSlide(1);
    }, 3000);
