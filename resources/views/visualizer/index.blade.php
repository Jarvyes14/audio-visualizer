<x-app-layout>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .visualizer-container {
            background: #000;
            overflow: hidden;
            height: calc(100vh - 64px);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        canvas {
            display: block;
            width: 100%;
            height: 100%;
        }

        .controls {
            width: 25%;
            position: fixed;
            bottom: 0%;
            left: 100%;
            transform: translateX(-79%) translateY(20%) scale(0.5);
            display: flex;
            flex-direction: column;
            gap: 15px;
            z-index: 10;
            align-items: center;
        }

        .button-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
        }

        button {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
        }

        button:hover:not(:disabled) {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.4);
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.2);
        }

        button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        button.active {
            background: rgba(0, 255, 100, 0.2);
            border-color: rgba(0, 255, 100, 0.4);
            box-shadow: 0 0 30px rgba(0, 255, 100, 0.3);
        }

        button.screenshot-btn {
            background: rgba(255, 100, 0, 0.2);
            border-color: rgba(255, 100, 0, 0.4);
        }

        button.screenshot-btn:hover:not(:disabled) {
            background: rgba(255, 100, 0, 0.3);
            box-shadow: 0 0 30px rgba(255, 100, 0, 0.3);
        }

        .slider-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            padding: 12px 24px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
        }

        .slider-container label {
            color: white;
            font-size: 14px;
            font-weight: 500;
            min-width: 100px;
        }

        input[type="range"] {
            width: 200px;
            height: 6px;
            border-radius: 3px;
            background: rgba(255, 255, 255, 0.2);
            outline: none;
        }

        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: white;
            cursor: pointer;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        input[type="range"]::-moz-range-thumb {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: white;
            cursor: pointer;
            border: none;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        .status {
            position: fixed;
            top: 90px;
            left: 50%;
            transform: translateX(-50%);
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            z-index: 10;
            text-align: center;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        .info {
            position: fixed;
            top: 120px;
            left: 50%;
            transform: translateX(-50%);
            color: rgba(255, 255, 255, 0.6);
            font-size: 12px;
            z-index: 10;
            text-align: center;
            max-width: 500px;
        }

        .all-sliders {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .user-info {
            position: fixed;
            top: 80px;
            right: 30px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 15px 20px;
            color: white;
            z-index: 10;
        }

        .notification {
            position: fixed;
            top: 90px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 255, 100, 0.2);
            border: 1px solid rgba(0, 255, 100, 0.4);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 15px 30px;
            color: white;
            z-index: 20;
            box-shadow: 0 0 30px rgba(0, 255, 100, 0.3);
            animation: slideDown 0.3s ease-out;
            display: none;
        }

        @keyframes slideDown {
            from {
                transform: translateX(-50%) translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateX(-50%) translateY(0);
                opacity: 1;
            }
        }
    </style>

    <div class="visualizer-container">
        <canvas id="canvas"></canvas>

        <div class="user-info">
            <div><strong>{{ auth()->user()->name }}</strong></div>
            <div style="font-size: 12px; opacity: 0.8;">{{ auth()->user()->email }}</div>
        </div>

        <div class="notification" id="notification"></div>

        <div class="controls">
            <div class="button-group">
                <button id="micBtn">🎤 Micrófono</button>
                <button id="systemBtn">🔊 Audio del Sistema</button>
                <button id="stopBtn" disabled>⏹️ Detener</button>
                <button id="screenshotBtn" class="screenshot-btn" disabled>📸 Capturar & Enviar</button>
            </div>
            <div class="all-sliders">
                <div class="slider-container">
                    <label for="sensitivity">Sensibilidad:</label>
                    <input type="range" id="sensitivity" min="1" max="1000" value="500" step="1">
                    <span id="sensitivityValue" style="color: white; min-width: 40px;">500</span>
                </div>
                <div class="slider-container">
                    <label for="maxDisplacement">Máx. Deformación:</label>
                    <input type="range" id="maxDisplacement" min="0" max="1" value="0.5" step="0.05">
                    <span id="maxDisplacementValue" style="color: white; min-width: 40px;">0.50</span>
                </div>
            </div>
            <div class="all-sliders">
                <div class="slider-container">
                    <label for="speed">Velocidad:</label>
                    <input type="range" id="speed" min="1" max="50" value="1" step="1">
                    <span id="speedValue" style="color: white; min-width: 40px;">1</span>
                </div>
                <div class="slider-container">
                    <label for="amplitude">Tamaño Esfera:</label>
                    <input type="range" id="amplitude" min="40" max="300" value="100" step="1">
                    <span id="amplitudeValue" style="color: white; min-width: 40px;">100</span>
                </div>
            </div>
        </div>

        <div class="status" id="status">Elige una fuente de audio para comenzar</div>
        <div class="info" id="info">Nota: Para capturar audio del sistema, selecciónalo en el diálogo de permisos</div>
    </div>

    <script>
        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');
        const micBtn = document.getElementById('micBtn');
        const systemBtn = document.getElementById('systemBtn');
        const stopBtn = document.getElementById('stopBtn');
        const screenshotBtn = document.getElementById('screenshotBtn');
        const status = document.getElementById('status');
        const info = document.getElementById('info');
        const notification = document.getElementById('notification');

        const sensitivitySlider = document.getElementById('sensitivity');
        const sensitivityValue = document.getElementById('sensitivityValue');
        const maxDisplacementSlider = document.getElementById('maxDisplacement');
        const maxDisplacementValue = document.getElementById('maxDisplacementValue');
        const speedSlider = document.getElementById('speed');
        const speedValue = document.getElementById('speedValue');
        const amplitudeSlider = document.getElementById('amplitude');
        const amplitudeValue = document.getElementById('amplitudeValue');

        let audioContext, analyser, source, dataArray, bufferLength;
        let animationId;
        let colorOffset = 0;
        let rotationX = 0;
        let rotationY = 0;
        let rotationZ = 0;
        let particles = [];
        let baseSpherePositions = [];
        let sensitivity = 0.5;
        let speed = 1;
        let amplitude = 300;
        let maxDisplacement = 0.5;
        let maxAudioIndex = 0;
        let displacementFactor = 2.0;
        let waveshaper;   // ← junto a audioContext, analyser, etc.

        function makeDistortionCurve(amount = 50) {
            const samples = 44100;
            const curve = new Float32Array(samples);
            const deg = Math.PI / 180;
            for (let i = 0; i < samples; i++) {
                const x = (i * 2) / samples - 1;               // -1 … 1
                curve[i] = ((3 + amount) * x * 20 * deg) / (Math.PI + amount * Math.abs(x));
            }
            return curve;
        }

        // Función para mostrar notificación
        function showNotification(message, type = 'success') {
            notification.textContent = message;
            notification.style.display = 'block';

            if (type === 'error') {
                notification.style.background = 'rgba(255, 0, 100, 0.2)';
                notification.style.borderColor = 'rgba(255, 0, 100, 0.4)';
                notification.style.boxShadow = '0 0 30px rgba(255, 0, 100, 0.3)';
            } else {
                notification.style.background = 'rgba(0, 255, 100, 0.2)';
                notification.style.borderColor = 'rgba(0, 255, 100, 0.4)';
                notification.style.boxShadow = '0 0 30px rgba(0, 255, 100, 0.3)';
            }

            setTimeout(() => {
                notification.style.display = 'none';
            }, 4000);
        }

        // Función para capturar screenshot
        screenshotBtn.addEventListener('click', async () => {
            try {
                screenshotBtn.disabled = true;
                screenshotBtn.textContent = '📸 Enviando...';

                // Capturar canvas como imagen
                const imageData = canvas.toDataURL('image/png');

                // Enviar al servidor
                const response = await fetch('{{ route("screenshot.capture") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        image: imageData
                    })
                });

                const data = await response.json();

                if (data.success) {
                    showNotification('✅ Screenshot capturado y enviado a tu correo!', 'success');
                } else {
                    showNotification('❌ Error: ' + data.message, 'error');
                }

            } catch (error) {
                console.error('Error:', error);
                showNotification('❌ Error al capturar screenshot', 'error');
            } finally {
                screenshotBtn.disabled = false;
                screenshotBtn.textContent = '📸 Capturar & Enviar';
            }
        });

        sensitivitySlider.addEventListener('input', (e) => {
            sensitivity = parseFloat(e.target.value);
            sensitivityValue.textContent = sensitivity.toFixed(2);
            if (analyser) {
                analyser.smoothingTimeConstant = 1.0 - sensitivity;
            }
        });

        maxDisplacementSlider.addEventListener('input', (e) => {
            maxDisplacement = parseFloat(e.target.value);
            maxDisplacementValue.textContent = maxDisplacement.toFixed(2);
        });

        speedSlider.addEventListener('input', (e) => {
            speed = parseFloat(e.target.value);
            speedValue.textContent = speed.toFixed(1);
        });

        amplitudeSlider.addEventListener('input', (e) => {
            amplitude = parseFloat(e.target.value);
            amplitudeValue.textContent = amplitude.toFixed(0);
        });

        function resizeCanvas() {
            const container = document.querySelector('.visualizer-container');
            canvas.width = container.clientWidth;
            canvas.height = container.clientHeight;
        }
        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);

        const BASE_RADIUS = 200;
        const PARTICLE_DENSITY = 1500;

        function getSpherePosition(index, total) {
            const phi = Math.acos(-1 + (2 * index) / total);
            const theta = Math.sqrt(total * Math.PI) * phi;
            const radius = BASE_RADIUS;

            return {
                x: radius * Math.cos(theta) * Math.sin(phi),
                y: radius * Math.sin(theta) * Math.sin(phi),
                z: radius * Math.cos(phi)
            };
        }

        function initParticles() {
            baseSpherePositions = [];
            particles = [];

            const maxIndex = maxAudioIndex > 0 ? maxAudioIndex : 128;

            for (let i = 0; i < PARTICLE_DENSITY; i++) {
                baseSpherePositions.push(getSpherePosition(i, PARTICLE_DENSITY));
                const randomIndex = Math.floor(Math.random() * maxIndex);
                particles.push({
                    id: i,
                    audioIndex: randomIndex,
                    current: { x: 0, y: 0, z: 0 }
                });
            }
        }

        function getColor(position, time, intensity = 0) {
            const colors = [
                { r: 0, g: 255, b: 100 },
                { r: 138, g: 43, b: 226 },
                { r: 255, g: 0, b: 100 },
                { r: 0, g: 150, b: 255 },
                { r: 255, g: 220, b: 0 }
            ];

            const totalColors = colors.length;
            const colorPosition = (position + time) % totalColors;
            const index1 = Math.floor(colorPosition);
            const index2 = (index1 + 1) % totalColors;
            const blend = colorPosition - index1;

            const c1 = colors[index1];
            const c2 = colors[index2];

            let r = Math.floor(c1.r + (c2.r - c1.r) * blend);
            let g = Math.floor(c1.g + (c2.g - c1.g) * blend);
            let b = Math.floor(c1.b + (c2.b - c1.b) * blend);

            const brightness = 0.8 + 0.85 * Math.min(Math.max(intensity, 0), 1);

            r = Math.min(255, Math.floor(r * brightness));
            g = Math.min(255, Math.floor(g * brightness));
            b = Math.min(255, Math.floor(b * brightness));

            return { r, g, b };
        }

        function rotate3D(point, rx, ry, rz) {
            let { x, y, z } = point;

            let y1 = y * Math.cos(rx) - z * Math.sin(rx);
            let z1 = y * Math.sin(rx) + z * Math.cos(rx);
            y = y1;
            z = z1;

            let x1 = x * Math.cos(ry) + z * Math.sin(ry);
            z1 = -x * Math.sin(ry) + z * Math.cos(ry);
            x = x1;
            z = z1;

            x1 = x * Math.cos(rz) - y * Math.sin(rz);
            y1 = x * Math.sin(rz) + y * Math.cos(rz);

            return { x: x1, y: y1, z: z1 };
        }

        function project3D(point, centerX, centerY) {
            const perspective = 800;
            const scale = perspective / (perspective + point.z);

            return {
                x: centerX + point.x * scale,
                y: centerY + point.y * scale,
                scale: scale,
                z: point.z
            };
        }

        async function initAudio(stream, sourceName) {
            if (audioContext) audioContext.close();

            audioContext = new (window.AudioContext || window.webkitAudioContext)();
            analyser     = audioContext.createAnalyser();
            source       = audioContext.createMediaStreamSource(stream);

            /* ---------- NODOS DE ECO ---------- */
            const delay       = audioContext.createDelay(1);   // 1 s max
            const feedbackGain= audioContext.createGain();
            const dryGain     = audioContext.createGain();     // señal original
            const wetGain     = audioContext.createGain();     // señal con eco
            const mix         = audioContext.createGain();     // salida final

            delay.delayTime.value     = 0.25;                  // 250 ms de eco
            feedbackGain.gain.value   = 0.4;                   // 40 % de feedback
            dryGain.gain.value        = 0.7;                   // 70 % original
            wetGain.gain.value        = 0.6;                   // 60 % eco (total >100 % es válido)

            /* ---------- CADENA ---------- */
            source.connect(dryGain);      // ruta seca
            source.connect(delay);        // ruta húmeda
            delay.connect(feedbackGain);
            feedbackGain.connect(delay);  // feedback
            feedbackGain.connect(wetGain);

            dryGain.connect(mix);
            wetGain.connect(mix);
            mix.connect(analyser);        // para el visualizador
            mix.connect(audioContext.destination); // altavoces

            /* ---------- ANALIZADOR (igual que antes) ---------- */
            analyser.fftSize = 256;
            analyser.smoothingTimeConstant = 1.0 - sensitivity;
            bufferLength = analyser.frequencyBinCount;
            dataArray    = new Uint8Array(bufferLength);
            maxAudioIndex= bufferLength;

            /* ---------- UI ---------- */
            micBtn.disabled   = true;
            systemBtn.disabled= true;
            stopBtn.disabled  = false;
            screenshotBtn.disabled = false;

            if (sourceName === 'micrófono') micBtn.classList.add('active');
            else systemBtn.classList.add('active');

            status.textContent = `🎵 Capturando ${sourceName}...`;
            info.textContent   = '';

            initParticles();
            visualize();
        }

        micBtn.addEventListener('click', async () => {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                await initAudio(stream, 'micrófono');
            } catch (err) {
                status.textContent = '❌ Error: No se pudo acceder al micrófono';
                showNotification('❌ No se pudo acceder al micrófono', 'error');
                console.error(err);
            }
        });

        systemBtn.addEventListener('click', async () => {
            try {
                const stream = await navigator.mediaDevices.getDisplayMedia({
                    video: true,
                    audio: {
                        echoCancellation: false,
                        noiseSuppression: false,
                        autoGainControl: false
                    }
                });

                stream.getVideoTracks().forEach(track => track.stop());

                if (stream.getAudioTracks().length === 0) {
                    status.textContent = '❌ No se seleccionó audio del sistema';
                    info.textContent = 'Asegúrate de marcar "Compartir audio de la pestaña" en el diálogo';
                    return;
                }

                await initAudio(stream, 'audio del sistema');
            } catch (err) {
                status.textContent = '❌ Error: No se pudo capturar el audio del sistema';
                info.textContent = 'Intenta de nuevo y marca "Compartir audio de la pestaña"';
                showNotification('❌ No se pudo capturar el audio del sistema', 'error');
                console.error(err);
            }
        });

        stopBtn.addEventListener('click', () => {
            if (animationId) cancelAnimationFrame(animationId);
            if (source) source.disconnect();
            if (audioContext) audioContext.close();

            micBtn.disabled = false;
            systemBtn.disabled = false;
            stopBtn.disabled = true;
            screenshotBtn.disabled = true;
            micBtn.classList.remove('active');
            systemBtn.classList.remove('active');

            status.textContent = 'Detenido';
            info.textContent = 'Elige una fuente de audio para comenzar';

            ctx.fillStyle = '#000';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
        });

        function visualize() {
            animationId = requestAnimationFrame(visualize);

            if (analyser) {
                analyser.getByteFrequencyData(dataArray);
            }

            ctx.fillStyle = 'rgba(0, 0, 0, 0.15)';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            const centerX = canvas.width / 2;
            const centerY = canvas.height / 2;

            rotationX += 0.005 * speed;
            rotationY += 0.007 * speed;
            rotationZ += 0.003 * speed;

            colorOffset += 0.01 * speed;

            const scaleFactor = amplitude / BASE_RADIUS;
            const magnitudeFactor = sensitivity * displacementFactor;

            const projectedParticles = particles.map((particle, i) => {
                const base = baseSpherePositions[i];

                let x = base.x;
                let y = base.y;
                let z = base.z;

                x *= scaleFactor;
                y *= scaleFactor;
                z *= scaleFactor;

                if (analyser && dataArray.length > 0) {
                    const audioIndex = particle.audioIndex;
                    let audioAmplitude = (dataArray[audioIndex] / 255) * 0.1;
                    audioAmplitude *= magnitudeFactor;

                    const maxMovement = BASE_RADIUS * maxDisplacement;
                    audioAmplitude = Math.min(audioAmplitude, maxMovement);

                    const distance = Math.sqrt(x * x + y * y + z * z);
                    if (distance > 0) {
                        x += (x / distance) * audioAmplitude;
                        y += (y / distance) * audioAmplitude;
                        z += (z / distance) * audioAmplitude;
                    }
                }

                const rotated = rotate3D({ x, y, z }, rotationX, rotationY, rotationZ);
                const projected = project3D(rotated, centerX, centerY);

                return {
                    ...projected,
                    index: i,
                    audioIndex: particle.audioIndex
                };
            });

            projectedParticles.sort((a, b) => b.z - a.z);

            projectedParticles.forEach(p => {
                const colorPos = (p.index / particles.length) * 5;

                let intensity = 0;
                if (analyser && dataArray && typeof p.audioIndex === 'number' && dataArray.length > p.audioIndex) {
                    intensity = dataArray[p.audioIndex] / 765;
                }

                const color = getColor(colorPos, colorOffset, intensity);
                const size = 1.5 * p.scale;

                const innerAlpha = 0.5 + 0.5 * intensity;
                const midAlpha = 0.25 + 0.55 * intensity;
                const outerAlpha = 0.05 + 0.5 * intensity;

                const gradient = ctx.createRadialGradient(p.x, p.y, 0, p.x, p.y, size * 3);
                gradient.addColorStop(0, `rgba(${color.r}, ${color.g}, ${color.b}, ${innerAlpha})`);
                gradient.addColorStop(0.3, `rgba(${color.r}, ${color.g}, ${color.b}, ${midAlpha})`);
                gradient.addColorStop(0.6, `rgba(${color.r}, ${color.g}, ${color.b}, ${outerAlpha})`);
                gradient.addColorStop(1, `rgba(${color.r}, ${color.g}, ${color.b}, 0)`);

                ctx.fillStyle = gradient;
                ctx.beginPath();
                ctx.arc(p.x, p.y, size * 3, 0, Math.PI * 2);
                ctx.fill();

                const centerAlpha = 0.6 + 0.4 * intensity;
                ctx.fillStyle = `rgba(255, 255, 255, ${centerAlpha})`;
                ctx.beginPath();
                ctx.arc(p.x, p.y, size * 0.5, 0, Math.PI * 2);
                ctx.fill();
            });
        }
    </script>
</x-app-layout>
