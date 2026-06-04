<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RuangIsyarat - AI Word Assembler</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght=400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #020617; color: #f8fafc; margin: 0; }
        .glass { background: rgba(30, 41, 59, 0.4); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 28px; }
        .gradient-text { background: linear-gradient(135deg, #38bdf8, #818cf8); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .video-container { position: relative; border-radius: 32px; overflow: hidden; border: 1px solid rgba(255, 255, 255, 0.1); height: 100%; }
        .corner { position: absolute; width: 30px; height: 30px; border: 4px solid #38bdf8; z-index: 10; opacity: 0.6; }
        .tl { top: 20px; left: 20px; border-right: 0; border-bottom: 0; border-radius: 12px 0 0 0; }
        .tr { top: 20px; right: 20px; border-left: 0; border-bottom: 0; border-radius: 0 12px 0 0; }
        .bl { bottom: 20px; left: 20px; border-right: 0; border-top: 0; border-radius: 0 0 0 12px; }
        .br { bottom: 20px; right: 20px; border-left: 0; border-top: 0; border-radius: 0 0 12px 0; }
        .word-glow { text-shadow: 0 0 15px rgba(56, 189, 248, 0.3); }
        .pulse { animation: p 2s infinite; } @keyframes p { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }
    </style>
</head>
<body class="antialiased h-screen overflow-hidden flex flex-col px-6 lg:px-12 py-4">

    <nav class="flex justify-between items-center mb-6 shrink-0">
        <a href="/" class="flex items-center gap-4 group cursor-pointer select-none">
            <div class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center border border-white/10 group-hover:border-sky-400/50 transition-colors">
                <i class="fas fa-hand-sparkles text-sky-400"></i>
            </div>
            <div class="flex flex-col">
                <h1 class="text-2xl font-extrabold tracking-tight leading-none text-white transition-all group-hover:tracking-normal">
                    Ruang<span class="gradient-text">Isyarat</span>
                </h1>
                <span class="text-[9px] font-bold tracking-[0.3em] text-slate-500 uppercase mt-1 opacity-70 group-hover:text-white transition-colors">
                    Beyond Silence
                </span>
            </div>
        </a>
        
        <div class="bg-slate-900/60 px-5 py-2 rounded-full border border-white/5 text-[10px] font-bold tracking-widest text-slate-400 uppercase shadow-inner">
            <span class="w-2 h-2 bg-sky-400 rounded-full inline-block mr-2 pulse"></span> System Optimized
        </div>
    </nav>

    <main class="grid grid-cols-1 lg:grid-cols-12 gap-6 flex-grow overflow-hidden items-stretch mb-4">
        
        <!-- Video Stream Box -->
        <div class="lg:col-span-8 flex flex-col gap-4 overflow-hidden">
            <div class="video-container bg-slate-950 relative overflow-hidden">
                <div class="corner tl"></div><div class="corner tr"></div><div class="corner bl"></div><div class="corner br"></div>
                <video id="video" autoplay playsinline class="w-full h-full object-cover scale-x-[-1]"></video>
                <div class="absolute bottom-6 left-6 glass px-4 py-1.5 text-[10px] font-bold text-slate-400 tracking-wider">
                    YOLOv11 <span class="text-sky-400">Analysis Active</span>
                </div>
            </div>
            
            <div class="flex items-center justify-between bg-slate-900/40 px-6 py-3 rounded-2xl border border-white/5 shrink-0 text-[10px] font-bold tracking-widest text-slate-500 uppercase">
                <div>FPS: <span id="fps-val" class="text-sky-400 font-mono">--</span></div>
                <div class="max-w-md truncate">Log: <span id="debug-log" class="text-amber-400 normal-case font-mono">Initializing camera...</span></div>
                <div>Status: <span id="status-badge" class="text-emerald-400">READY</span></div>
            </div>
        </div>

        <!-- Sidebar Info & Result -->
        <div class="lg:col-span-4 flex flex-col gap-4 overflow-hidden">
            <div class="glass w-full p-6 border-t-2 border-sky-500/20 shrink-0 shadow-xl">
                <div class="flex justify-between items-center mb-4">
                    <p class="text-[11px] font-bold text-sky-400 uppercase tracking-widest italic">Interpretation Result</p>
                    <div class="flex gap-2">
                        <button onclick="clearMemory()" class="h-9 w-9 rounded-xl bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/20 transition-all flex items-center justify-center active:scale-90" title="Clear Memory">
                            <i class="fas fa-trash-alt text-[10px]"></i>
                        </button>
                        <button onclick="speakWord()" class="h-9 w-9 rounded-xl bg-sky-500/10 hover:bg-sky-500/20 text-sky-400 border border-sky-500/20 transition-all flex items-center justify-center active:scale-90" title="Play Voice">
                            <i class="fas fa-volume-up text-[10px]"></i>
                        </button>
                    </div>
                </div>
                
                <h2 id="result" class="text-6xl font-extrabold tracking-tighter text-white mb-5 transition-all">-</h2>

                <div class="bg-black/30 p-5 rounded-2xl border border-white/5 shadow-inner">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest block mb-3">Final Word Composition</span>
                    <h3 id="word-memory" class="text-3xl font-extrabold tracking-[0.1em] text-white uppercase break-all word-glow">...</h3>
                </div>
            </div>

            <div class="glass w-full p-6 border-l-2 border-sky-500/20 flex-grow flex flex-col justify-center">
                <p class="text-[11px] font-bold text-sky-400 uppercase tracking-widest mb-6 italic">Akurasi Sistem</p>
                <ul class="space-y-5">
                    <li class="flex gap-4 items-start">
                        <div class="h-8 w-8 bg-sky-500/10 rounded-lg flex-none flex items-center justify-center text-sky-400 border border-sky-500/10"><i class="fas fa-sun text-xs"></i></div>
                        <div>
                            <p class="text-[12px] font-bold text-white uppercase mb-1 tracking-tight">Pencahayaan</p>
                            <p class="text-[11px] text-slate-400 leading-snug">Optimalkan intensitas cahaya agar fitur objek tangan terdeteksi jelas.</p>
                        </div>
                    </li>
                    <li class="flex gap-4 items-start">
                        <div class="h-8 w-8 bg-sky-500/10 rounded-lg flex-none flex items-center justify-center text-sky-400 border border-sky-500/10"><i class="fas fa-expand-arrows-alt text-xs"></i></div>
                        <div>
                            <p class="text-[12px] font-bold text-white uppercase mb-1 tracking-tight">Area Deteksi</p>
                            <p class="text-[11px] text-slate-400 leading-snug">Mundurlah 1 meter, pastikan pundak, dada, dan tangan masuk frame kamera utuh.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </main>

<script>
    const video = document.getElementById("video"), 
          canvas = document.createElement("canvas"), 
          ctx = canvas.getContext("2d"), 
          resultText = document.getElementById("result"), 
          wordDisplay = document.getElementById("word-memory"), 
          fpsVal = document.getElementById("fps-val"), 
          debugLog = document.getElementById("debug-log"),
          statusBadge = document.getElementById("status-badge"),
          csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    let isProcessing = false, wordBuffer = []; 

    // KONFIGURASI FILTER ANTI-FALSE POSITIVE
    const CONFIDENCE_THRESHOLD = 0.70; // Batas akurasi minimal (70%)
    const REQUIRED_STABLE_FRAMES = 3;   // Harus konsisten selama 3 frame berurutan
    
    let activeCandidate = null;        
    let stableFrameCount = 0;           

    // Ambil Stream Video Kamera Laptop/Webcam
    navigator.mediaDevices.getUserMedia({ video: { width: 640, height: 480 } })
        .then(s => { video.srcObject = s; debugLog.innerText = "Camera active. Awaiting gesture..."; })
        .catch(e => { debugLog.innerText = "Camera Error: " + e.message; statusBadge.innerText = "ERROR"; statusBadge.className = "text-red-400"; });

    // Fitur Suara Text-To-Speech (Bahasa Indonesia)
    function speakWord() {
        const fullWord = wordBuffer.join("");
        if (!fullWord) return;
        window.speechSynthesis.cancel();
        const msg = new SpeechSynthesisUtterance(fullWord);
        msg.lang = 'id-ID'; msg.rate = 0.95;
        window.speechSynthesis.speak(msg);
    }

    // Mengosongkan Susunan Kalimat
    function clearMemory() {
        wordBuffer = []; 
        wordDisplay.innerText = "..."; 
        resultText.innerText = "-";
        activeCandidate = null;
        stableFrameCount = 0;
        debugLog.innerText = "Memory cleared.";
    }

    // Engine Core Deteksi Real-Time Loop
    async function detect() {
        if (isProcessing || video.videoWidth === 0) { setTimeout(detect, 200); return; }
        isProcessing = true; 
        const start = Date.now();
        
        // Setup dimensi frame inferensi YOLOv11 terbaik (416x416) demi performa jaringan yang cepat
        canvas.width = 416; 
        canvas.height = 416;

        // Efek mirroring spasial natural
        ctx.translate(416, 0);
        ctx.scale(-1, 1);
        ctx.drawImage(video, 0, 0, 416, 416);
        ctx.setTransform(1, 0, 0, 1, 0, 0);

        // Konversi tangkapan layar menjadi berkas Blob Biner Murni (Bukan Base64 String)
        canvas.toBlob(async (blob) => {
            if (!blob) { isProcessing = false; setTimeout(detect, 200); return; }

            const formData = new FormData();
            formData.append('image', blob, 'frame.jpg');

            try {
                const res = await fetch("/detect", {
                    method: "POST",
                    headers: { 
                        "X-CSRF-TOKEN": csrfToken 
                    },
                    body: formData
                });
                
                const data = await res.json();
                
                if (!res.ok) {
                    debugLog.innerText = `Error: ${data.message || data.error}`;
                    statusBadge.innerText = "API ERROR";
                    statusBadge.className = "text-red-400";
                    resetTracker();
                } else {
                    statusBadge.innerText = "CONNECTED";
                    statusBadge.className = "text-emerald-400";
                    
                    // Pembacaan data array prediksi dari model Object Detection baru
                    if (data.predictions && data.predictions.length > 0) {
                        const p = data.predictions[0];
                        
                        // Menangkap parameter deteksi standar YOLO baru
                        const currentClass = p.class;
                        const currentConfidence = p.confidence;
                        
                        debugLog.innerText = `Target: ${currentClass} (${(currentConfidence * 100).toFixed(0)}%)`;
                        
                        if (currentConfidence >= CONFIDENCE_THRESHOLD) {
                            resultText.innerText = currentClass;
                            resultText.className = "text-6xl font-extrabold tracking-tighter text-sky-400 transition-all scale-105 duration-200";
                            
                            // Algoritma Penahan Stabilitas Input Isyarat Jari
                            if (currentClass === activeCandidate) {
                                stableFrameCount++;
                            } else {
                                activeCandidate = currentClass;
                                stableFrameCount = 1;
                            }
                            
                            if (stableFrameCount === REQUIRED_STABLE_FRAMES) {
                                if (wordBuffer[wordBuffer.length - 1] !== currentClass || wordBuffer[wordBuffer.length - 1] == currentClass) {
                                    const isWord = currentClass.length > 1;
                                    if (wordBuffer.length > 0 && (isWord || wordBuffer[wordBuffer.length - 1].length > 1)) {
                                        wordBuffer.push(" "); 
                                    }
                                    wordBuffer.push(currentClass); 
                                    wordDisplay.innerText = wordBuffer.join("");
                                }
                            }
                        } else {
                            resetTracker();
                        }
                    } else {
                        resetTracker();
                        debugLog.innerText = "Streaming clear. No signs detected.";
                    }
                }
            } catch (e) { 
                debugLog.innerText = "Network connection interrupted.";
                statusBadge.innerText = "DISCONNECTED";
                statusBadge.className = "text-amber-400";
                resetTracker();
            }
            
            fpsVal.innerText = Math.round(1000 / (Date.now() - start));
            isProcessing = false; 
            setTimeout(detect, 200); // Trigger frame berikutnya
        }, "image/jpeg", 0.7);
    }

    function resetTracker() {
        stableFrameCount = 0;
        activeCandidate = null;
        resultText.innerText = "-";
        resultText.className = "text-6xl font-extrabold tracking-tighter text-white transition-all scale-100 duration-200";
    }

    video.onloadeddata = () => detect();
</script>
</body>
</html>
