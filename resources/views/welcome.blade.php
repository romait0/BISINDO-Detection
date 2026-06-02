<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RuangIsyarat - Deteksi BISINDO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: #030712; 
            color: #ffffff;
            /* Scroll tetap aktif tapi smooth saat berpindah frame */
            scroll-behavior: smooth; 
        }

        .bg-grid {
            background-size: 40px 40px;
            background-image: linear-gradient(to right, rgba(255, 255, 255, 0.015) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255, 255, 255, 0.015) 1px, transparent 1px);
        }

        .blob {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(56, 189, 248, 0.12) 0%, rgba(59, 130, 246, 0.04) 70%, transparent 100%);
            filter: blur(80px);
            z-index: -1;
        }

        /* Glass Card Base - Menggunakan min-height dinamis agar teks tidak meluber keluar */
        .glass-card {
            background: rgba(255, 255, 255, 0.01);
            backdrop-filter: blur(16px);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Border khusus masing-masing kartu sesuai gambar revisi */
        .border-sky { border: 1px solid rgba(56, 189, 248, 0.2); }
        .border-purple { border: 1px solid rgba(168, 85, 247, 0.2); }
        .border-emerald { border: 1px solid rgba(16, 185, 129, 0.2); }

        .btn-gradient {
            background: linear-gradient(135deg, #38bdf8 0%, #1d4ed8 100%);
            box-shadow: 0 4px 20px rgba(56, 189, 248, 0.15);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(56, 189, 248, 0.35);
        }

        .btn-outline {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.3s ease;
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: #38bdf8;
        }

        /* Animasi Highlight premium sinkron warna saat tombol ditekan */
        .card-highlight-sky { animation: glowSky 1.5s cubic-bezier(0.25, 1, 0.5, 1); }
        .card-highlight-purple { animation: glowPurple 1.5s cubic-bezier(0.25, 1, 0.5, 1); }
        .card-highlight-emerald { animation: glowEmerald 1.5s cubic-bezier(0.25, 1, 0.5, 1); }

        @keyframes glowSky {
            0% { border-color: rgba(56, 189, 248, 0.2); background: rgba(255, 255, 255, 0.01); }
            20% { border-color: rgba(56, 189, 248, 0.6); background: rgba(56, 189, 248, 0.04); box-shadow: 0 0 30px rgba(56, 189, 248, 0.15); }
            100% { border-color: rgba(56, 189, 248, 0.2); background: rgba(255, 255, 255, 0.01); }
        }
        @keyframes glowPurple {
            0% { border-color: rgba(168, 85, 247, 0.2); background: rgba(255, 255, 255, 0.01); }
            20% { border-color: rgba(168, 85, 247, 0.6); background: rgba(168, 85, 247, 0.04); box-shadow: 0 0 30px rgba(168, 85, 247, 0.15); }
            100% { border-color: rgba(168, 85, 247, 0.2); background: rgba(255, 255, 255, 0.01); }
        }
        @keyframes glowEmerald {
            0% { border-color: rgba(16, 185, 129, 0.2); background: rgba(255, 255, 255, 0.01); }
            20% { border-color: rgba(16, 185, 129, 0.6); background: rgba(16, 185, 129, 0.04); box-shadow: 0 0 30px rgba(16, 185, 129, 0.15); }
            100% { border-color: rgba(16, 185, 129, 0.2); background: rgba(255, 255, 255, 0.01); }
        }

        .text-glow {
            text-shadow: 0 0 30px rgba(56, 189, 248, 0.2);
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade { animation: fadeInUp 0.8s cubic-bezier(0.25, 1, 0.5, 1) forwards; }
    </style>
</head>
<body class="antialiased relative bg-grid">
    
    <div class="blob top-[-10%] left-[20%]"></div>
    <div class="blob bottom-[-10%] right-[20%]"></div>

    <section class="h-screen flex flex-col justify-between py-8 relative z-10 box-border">
        <header class="max-w-6xl w-full mx-auto px-8 flex justify-between items-center">
            <div class="flex items-center gap-3 group cursor-pointer">
                <div class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center border border-white/10 group-hover:border-sky-400/50 transition-colors">
                    <i class="fas fa-hand-sparkles text-sky-400"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-2xl font-bold tracking-tight text-white">Ruang<span class="text-sky-400">Isyarat</span></span>
                    <span class="text-[9px] font-semibold tracking-[0.3em] text-slate-500 uppercase">Beyond Silence</span>
                </div>
            </div>

           <a href="{{ route('katalog') }}" class="btn-outline px-5 py-2.5 rounded-xl text-sm font-medium inline-block text-center">Katalog Isyarat</a>
        </header>

        <div class="text-center max-w-3xl mx-auto px-8 animate-fade my-auto">
            <span class="px-3.5 py-1.5 rounded-full border border-sky-500/20 bg-sky-500/5 text-sky-400 text-xs font-semibold tracking-wider uppercase mb-6 inline-block">
                Powered by YOLOv11 Edge AI
            </span>
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-6 leading-[1.15]">
                Bicara Lewat <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 via-blue-400 to-indigo-400 text-glow">Ekspresi Tangan.</span>
            </h1>
            <p class="text-slate-400 text-base md:text-lg leading-relaxed max-w-xl mx-auto mb-10">
                Penerjemah Bahasa Isyarat Indonesia berbasis visi komputer pintar. Instan, privat, dan berjalan langsung di browsermu.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="/deteksi" class="btn-gradient px-8 py-4 rounded-xl font-semibold text-base flex items-center gap-2.5 w-full sm:w-auto justify-center">
                    Mulai Deteksi <i class="fas fa-video text-sm opacity-80"></i>
                </a>
                <button onclick="pemicuKapabilitas()" class="btn-outline px-8 py-4 rounded-xl font-semibold text-base w-full sm:w-auto">
                    Lihat Kapabilitas
                </button>
            </div>
        </div>

        <div class="h-12 w-full"></div>
    </section>

    <section id="screen-kapabilitas" class="h-screen flex flex-col justify-between py-12 relative z-10 box-border">
        
        <div class="w-full flex-grow flex items-center justify-center">
            
            <div class="grid md:grid-cols-3 gap-6 max-w-5xl mx-auto w-full px-8">
                
                <div id="card-sky" class="feature-card glass-card border-sky p-8 rounded-2xl flex flex-col justify-between min-h-[16rem] group">
                    <div>
                        <div class="w-11 h-11 bg-sky-500/10 rounded-xl flex items-center justify-center text-sky-400 mb-6 border border-sky-500/20">
                            <i class="fas fa-bolt text-lg"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Real-time Proses</h3>
                        <p class="text-slate-400 text-sm leading-relaxed">Deteksi super cepat dengan latensi super minim, menghasilkan translasi instan tepat saat tangan bergerak.</p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-white/[0.04] flex justify-between items-center text-xs text-sky-400 font-medium">
                        <span>Latency Track</span>
                        <span class="bg-sky-500/10 px-2 py-0.5 rounded text-[10px]">~10ms</span>
                    </div>
                </div>

                <div id="card-purple" class="feature-card glass-card border-purple p-8 rounded-2xl flex flex-col justify-between min-h-[16rem] group">
                    <div>
                        <div class="w-11 h-11 bg-purple-500/10 rounded-xl flex items-center justify-center text-purple-400 mb-6 border border-purple-500/20">
                            <i class="fas fa-brain text-lg"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">YOLOv11 Accuracy</h3>
                        <p class="text-slate-400 text-sm leading-relaxed">Didukung arsitektur model object detection terbaru untuk mengenali detail bentuk gestur alfabet BISINDO secara presisi.</p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-white/[0.04] flex justify-between items-center text-xs text-purple-400 font-medium">
                        <span>Confidence Rate</span>
                        <span class="bg-purple-500/10 px-2 py-0.5 rounded text-[10px]">High Metrics</span>
                    </div>
                </div>

                <div id="card-emerald" class="feature-card glass-card border-emerald p-8 rounded-2xl flex flex-col justify-between min-h-[16rem] group">
                    <div>
                        <div class="w-11 h-11 bg-emerald-500/10 rounded-xl flex items-center justify-center text-emerald-400 mb-6 border border-emerald-500/20">
                            <i class="fas fa-shield-alt text-lg"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Privasi On-Device</h3>
                        <p class="text-slate-400 text-sm leading-relaxed">Seluruh pemrosesan video dilakukan langsung di perangkat kamu. Tidak ada data gambar yang dikirim ke server luar.</p>
                    </div>
                    <div class="pt-4 mt-4 border-t border-white/[0.04] flex justify-between items-center text-xs text-emerald-400 font-medium">
                        <span>Local Connection</span>
                        <span class="bg-emerald-500/10 px-2 py-0.5 rounded text-[10px]">100% Secure</span>
                    </div>
                </div>

            </div>

        </div>

        <footer class="max-w-7xl mx-auto px-8 w-full text-center">
            <p class="text-slate-600 text-[11px] tracking-wider uppercase mb-1">RuangIsyarat &copy; 2026 // Inklusivitas Komunikasi</p>
            <p class="text-slate-500 text-xs italic">Didesain untuk kegunaan maksimal dan aksesibilitas inklusif.</p>
        </footer>
    </section>

    <script>
        function pemicuKapabilitas() {
            // 1. Scroll mulus pas satu frame penuh ke halaman kapabilitas
            const targetScreen = document.getElementById('screen-kapabilitas');
            targetScreen.scrollIntoView({ behavior: 'smooth' });

            // 2. Berikan kilatan animasi pada kartu sesuai id masing-masing setelah layar bergeser
            const cardSky = document.getElementById('card-sky');
            const cardPurple = document.getElementById('card-purple');
            const cardEmerald = document.getElementById('card-emerald');

            cardSky.classList.remove('card-highlight-sky');
            cardPurple.classList.remove('card-highlight-purple');
            cardEmerald.classList.remove('card-highlight-emerald');
            
            void cardSky.offsetWidth; // Trigger reflow
            
            cardSky.classList.add('card-highlight-sky');
            cardPurple.classList.add('card-highlight-purple');
            cardEmerald.classList.add('card-highlight-emerald');
        }
    </script>

</body>
</html>