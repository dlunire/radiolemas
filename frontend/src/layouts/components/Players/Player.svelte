<script lang="ts">
  import { onMount, onDestroy } from "svelte";

  let canvas: HTMLCanvasElement;
  let ctx: CanvasRenderingContext2D | null;

  // URL del stream en vivo (cámbiala por la de RadioLemas)
  const streamUrl = "https://tu-radio-stream-url.com/stream";

  let audioCtx: AudioContext;
  let audio: HTMLAudioElement;
  let analyser: AnalyserNode;
  let dataArray: Uint8Array;
  let animationId: number;

  function startStream() {
    // Crear contexto de audio
    audioCtx = new (window.AudioContext || (window as any).webkitAudioContext)();

    // Crear elemento <audio> pero no insertarlo en el DOM
    audio = new Audio(streamUrl);
    audio.crossOrigin = "anonymous";
    audio.autoplay = true;

    // Conectar <audio> al contexto
    const source = audioCtx.createMediaElementSource(audio);

    // Crear analizador
    analyser = audioCtx.createAnalyser();
    analyser.fftSize = 2048;

    source.connect(analyser);
    analyser.connect(audioCtx.destination);

    dataArray = new Uint8Array(analyser.fftSize);

    draw();
  }

  function draw() {
    if (!ctx || !canvas) return;

    animationId = requestAnimationFrame(draw);

    analyser.getByteTimeDomainData(dataArray);

    ctx.fillStyle = "#111"; // fondo
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    ctx.lineWidth = 2;
    ctx.strokeStyle = "#0f0"; // color de la onda

    ctx.beginPath();

    const sliceWidth = (canvas.width * 1.0) / dataArray.length;
    let x = 0;

    for (let i = 0; i < dataArray.length; i++) {
      const v = dataArray[i] / 128.0;
      const y = (v * canvas.height) / 2;

      if (i === 0) ctx.moveTo(x, y);
      else ctx.lineTo(x, y);

      x += sliceWidth;
    }

    ctx.lineTo(canvas.width, canvas.height / 2);
    ctx.stroke();
  }

  onMount(() => {
    ctx = canvas.getContext("2d");

    // Usuario debe interactuar (click/tap) para iniciar audio
    const startOnClick = () => {
      startStream();
      window.removeEventListener("click", startOnClick);
    };

    window.addEventListener("click", startOnClick);
  });

  onDestroy(() => {
    if (animationId) cancelAnimationFrame(animationId);
    if (audio) audio.pause();
    if (audioCtx) audioCtx.close();
  });
</script>

<div class="player">
  <p>Haz clic en cualquier parte para iniciar el stream 🎧</p>
  <canvas bind:this={canvas} width="600" height="200"></canvas>
</div>

<style>
  .player {
    text-align: center;
    padding: 1rem;
    background: #000;
    color: #fff;
  }

  canvas {
    width: 100%;
    max-width: 600px;
    height: 200px;
    border: 1px solid #333;
    background: #111;
  }
</style>

