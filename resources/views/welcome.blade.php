<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="{{ asset('images/logo.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            overflow: hidden;
            background: #000;
        }

        .intro-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #000;
            z-index: 9999;
        }

        .intro-video {
            /* Asegura que el video esté visible para que el usuario sepa que está ahí,
               pero se superpondrá con la pantalla de inicio */
            width: 100%;
            height: 100%;
            /* Inicia el video oculto y silenciado hasta que se inicie la experiencia */
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        /* ESTILO PARA EL BOTÓN INICIAR EXPERIENCIA (NUEVO) */
        .start-button {
            position: absolute; /* Para que esté sobre el video */
            color: white;
            padding: 15px 40px;
            font-size: 50px;
            font-weight: 200;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            cursor: pointer;
            transition: all 0.3s;
            z-index: 10001; /* Más alto que el skip-button */
            animation: pulse-start 2s infinite;
        }

        .start-button:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.6);
        }

        @keyframes pulse-start {
            0% {
                /* Sombra de texto inicial ligera */
                text-shadow: 0 0 5px rgba(255, 255, 255, 0.5), 0 0 10px rgba(255, 255, 255, 0.3);
                transform: scale(1);
            }
            50% {
                /* Sombra de texto intensa y difusa (efecto pulso/neón) */
                text-shadow: 0 0 0.1px #fff, 0 0 10px #fff, 0 0 50px #fff, 0 0 0px #667eea, 0 0 0px #667eea;
                transform: scale(1.04);
            }
            100% {
                /* Vuelve a la sombra de texto inicial */
                text-shadow: 0 0 5px rgba(255, 255, 255, 0.5), 0 0 10px rgba(255, 255, 255, 0.3);
                transform: scale(1);
            }
        }
        /* FIN ESTILO PARA EL BOTÓN INICIAR EXPERIENCIA */

        .skip-button {
            position: fixed;
            bottom: 40px;
            right: 40px;
            color: white;
            padding: 12px 30px;
            border-radius: 30px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            z-index: 10000;
        }

        .skip-button.hidden {
            display: none; /* Ocultar hasta que inicie el video */
        }

        .skip-button:hover {
            transform: scale(1.05);
        }

        @keyframes pulse {
            0%, 100% {
                box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
            }
            50% {
                box-shadow: 0 0 40px rgba(255, 255, 255, 0.5);
            }
        }

        .main-content {
            display: none;
            min-height: 100vh;
            background: black;
            position: relative;
            overflow: hidden;
        }

        .main-content.active {
            display: block;
        }

        .hero-section {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 40px 20px;
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 700;
            color: white;
            margin-bottom: 20px;
            text-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            animation: fadeInUp 1s ease-out;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 40px;
            max-width: 600px;
            animation: fadeInUp 1s ease-out 0.2s both;
        }

        .cta-buttons {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
            animation: fadeInUp 1s ease-out 0.4s both;
        }

        .cta-button {
            padding: 16px 40px;
            border-radius: 30px;
            font-size: 18px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .cta-primary {
            background: white;
            color: black;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .cta-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        .cta-secondary {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .cta-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
        }

        .background-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            opacity: 0.5;
        }

        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 20s infinite ease-in-out;
        }

        .shape:nth-child(1) {
            width: 300px;
            height: 300px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 200px;
            height: 200px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            width: 150px;
            height: 150px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-50px) rotate(180deg);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.2rem;
            }

            .cta-buttons {
                flex-direction: column;
                width: 100%;
                padding: 0 20px;
            }

            .cta-button {
                width: 100%;
                justify-content: center;
            }

            .skip-button {
                bottom: 20px;
                right: 20px;
                padding: 10px 20px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
<div class="intro-container" id="introContainer">
    <audio id="introAudio">
        <source src="{{ asset('intro/audio.mp3') }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
    <video id="introVideo" class="intro-video" muted>
        <source src="{{ asset('intro/video.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <button class="start-button" id="startButton">Iniciar Experiencia</button>

    <button class="skip-button hidden" id="skipButton">Saltar Intro →</button>
</div>

<div class="main-content" id="mainContent">
    <div class="background-animation">
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
    </div>

    <div class="hero-section">
        <h1 class="hero-title">Audio Visualizer</h1>
        <p class="hero-subtitle">
            Transform your audio into stunning 3D visualizations.
            Create, capture, and share your unique sound spheres.
        </p>

        <div class="cta-buttons">
            @auth
                <a href="{{ route('dashboard') }}" class="cta-button cta-primary">
                    <span>Go to Dashboard</span>
                    <span>→</span>
                </a>
                <a href="{{ route('visualizer.index') }}" class="cta-button cta-secondary">
                    <span>🎵 Launch Visualizer</span>
                </a>
            @else
                <a href="{{ route('register') }}" class="cta-button cta-primary">
                    <span>Get Started Free</span>
                    <span>→</span>
                </a>
                <a href="{{ route('login') }}" class="cta-button cta-secondary">
                    <span>Sign In</span>
                </a>
            @endauth
        </div>
    </div>
</div>

<script>
    const introContainer = document.getElementById('introContainer');
    const mainContent = document.getElementById('mainContent');
    const skipButton = document.getElementById('skipButton');
    const startButton = document.getElementById('startButton'); // Referencia al nuevo botón
    const introVideo = document.getElementById('introVideo');
    const introAudio = document.getElementById('introAudio');

    // Función para mostrar el contenido principal (Skip o End)
    function showMainContent() {
        introContainer.style.display = 'none';
        mainContent.classList.add('active');

        // Pausar video y audio
        introVideo.pause();
        introAudio.pause();
    }

    // Función para iniciar la reproducción del video y audio
    function startExperience() {
        // Ocultar el botón de inicio
        startButton.style.display = 'none';

        // Mostrar el video (quitando la opacidad 0) y el botón de saltar
        introVideo.style.opacity = '1';
        skipButton.classList.remove('hidden');

        // 3. Iniciar reproducción del video (silenciado)
        introVideo.play().catch(error => {
            console.error('Video playback failed:', error);
            // Si el video falla, ir directamente al contenido principal
            setTimeout(showMainContent, 500);
        });

        // Desmutear y reproducir el audio
        introVideo.muted = false; // El video DEBE estar silenciado inicialmente para que funcione el play() en algunos navegadores
        introAudio.play().catch(error => {
            console.warn('Audio playback was prevented. User interaction required for audio.');
            // Puedes dejar el audio silenciado o mostrar un indicador
        });
    }

    // --- Event Listeners ---

    // NUEVO: Escuchar el clic en el botón Iniciar Experiencia
    startButton.addEventListener('click', startExperience);

    // Cuando el video termina, mostrar contenido principal
    introVideo.addEventListener('ended', showMainContent);

    // Botón de saltar
    skipButton.addEventListener('click', showMainContent);

    // Si el video no carga o falla, mostrar contenido principal después de 3 segundos
    introVideo.addEventListener('error', () => {
        console.error('Video failed to load.');
        setTimeout(showMainContent, 3000);
    });

    // Manejo de tecla ESC para saltar intro
    document.addEventListener('keydown', (e) => {
        // Solo permitir saltar si la intro está visible Y YA ha iniciado (el botón de inicio no es visible)
        if (e.key === 'Escape' && introContainer.style.display !== 'none' && startButton.style.display === 'none') {
            showMainContent();
        }
    });
</script>
</body>
</html>
