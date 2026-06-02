<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RuangIsyarat - Katalog BISINDO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: #030712; 
            color: #ffffff;
        }

        .bg-grid {
            background-size: 40px 40px;
            background-image: linear-gradient(to right, rgba(255, 255, 255, 0.015) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255, 255, 255, 0.015) 1px, transparent 1px);
        }

        .blob {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(56, 189, 248, 0.1) 0%, rgba(168, 85, 247, 0.03) 70%, transparent 100%);
            filter: blur(80px);
            z-index: -1;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.01);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-card:hover {
            transform: translateY(-4px);
            border-color: rgba(56, 189, 248, 0.3);
            box-shadow: 0 10px 30px rgba(56, 189, 248, 0.08);
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

        .text-glow {
            text-shadow: 0 0 30px rgba(56, 189, 248, 0.2);
        }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #030712; }
        ::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(56, 189, 248, 0.3); }
    </style>
</head>
<body class="antialiased relative bg-grid min-h-screen flex flex-col justify-between py-8 box-border">
    
    <div class="blob top-[-10%] right-[10%]"></div>
    <div class="blob bottom-[10%] left-[5%]"></div>

    <header class="max-w-6xl w-full mx-auto px-8 flex justify-between items-center mb-12">
        <a href="/" class="flex items-center gap-3 group cursor-pointer">
            <div class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center border border-white/10 group-hover:border-sky-400/50 transition-colors">
                <i class="fas fa-arrow-left text-slate-400 group-hover:text-sky-400 transition-colors"></i>
            </div>
            <div class="flex flex-col">
                <span class="text-2xl font-bold tracking-tight text-white">Ruang<span class="text-sky-400">Isyarat</span></span>
                <span class="text-[11px] font-semibold tracking-[0.2em] text-slate-500 uppercase mt-0.5">Katalog Isyarat</span>
            </div>
        </a>
        <a href="/" class="btn-outline px-5 py-2.5 rounded-xl text-sm font-medium flex items-center gap-2">
            <i class="fas fa-home text-xs opacity-70"></i> Kembali
        </a>
    </header>

    <main class="max-w-6xl w-full mx-auto px-8 flex-grow">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
            <div>
                <h1 class="text-4xl font-extrabold tracking-tight mb-2">
                    Katalog Isyarat <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-blue-500 text-glow">BISINDO</span>
                </h1>
                <p class="text-slate-400 text-sm md:text-base">
                    Panduan visual isyarat tangan alfabet dan kosa kata Bahasa Isyarat Indonesia.
                </p>
            </div>
            
            <div class="relative w-full md:w-80">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500">
                    <i class="fas fa-search text-sm"></i>
                </span>
                <input 
                    type="text" 
                    id="search-input"
                    placeholder="Cari isyarat (Contoh: Makan)..." 
                    class="w-full bg-white/[0.02] border border-white/10 rounded-xl py-3 pl-11 pr-4 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-sky-400 focus:bg-white/[0.04] transition-all"
                    oninput="filterKatalog()"
                >
            </div>
        </div>

        <div class="flex gap-2.5 mb-10 border-b border-white/[0.05] pb-4">
            <button onclick="gantiKategori('semua')" id="tab-semua" class="px-4 py-2 rounded-xl text-xs font-semibold uppercase tracking-wider bg-sky-500/10 text-sky-400 border border-sky-500/20 transition-all">Semua</button>
            <button onclick="gantiKategori('alfabet')" id="tab-alfabet" class="px-4 py-2 rounded-xl text-xs font-semibold uppercase tracking-wider text-slate-400 hover:text-white transition-all">Alfabet</button>
            <button onclick="gantiKategori('kata')" id="tab-kata" class="px-4 py-2 rounded-xl text-xs font-semibold uppercase tracking-wider text-slate-400 hover:text-white transition-all">Kosa Kata</button>
        </div>

        <div id="katalog-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5 mb-16">
            </div>

    </main>

    <footer class="max-w-7xl mx-auto px-8 w-full text-center mt-auto">
        <p class="text-slate-600 text-[11px] tracking-wider uppercase mb-1">RuangIsyarat &copy; 2026 // Inklusivitas Komunikasi</p>
        <p class="text-slate-500 text-xs italic">Didesain untuk kegunaan maksimal dan aksesibilitas inklusif.</p>
    </footer>

    <script>
        const dataKatalog = [
            { nama: "A", jenis: "alfabet" }, { nama: "Anda", jenis: "kata" }, { nama: "Apa", jenis: "kata" },
            { nama: "B", jenis: "alfabet" }, { nama: "Berhenti", jenis: "kata" }, { nama: "Bodoh", jenis: "kata" },
            { nama: "C", jenis: "alfabet" }, { nama: "Cantik", jenis: "kata" },
            { nama: "D", jenis: "alfabet" }, { nama: "E", jenis: "alfabet" }, { nama: "F", jenis: "alfabet" },
            { nama: "G", jenis: "alfabet" }, { nama: "H", jenis: "alfabet" }, { nama: "Halo", jenis: "kata" },
            { nama: "Hati-hati", jenis: "kata" }, { nama: "I", jenis: "alfabet" }, { nama: "J", jenis: "alfabet" },
            { nama: "K", jenis: "alfabet" }, { nama: "L", jenis: "alfabet" }, { nama: "Lelah", jenis: "kata" },
            { nama: "M", jenis: "alfabet" }, { nama: "Maaf", jenis: "kata" }, { nama: "Makan", jenis: "kata" },
            { nama: "Mau", jenis: "kata" }, { nama: "Membaca", jenis: "kata" }, { nama: "N", jenis: "alfabet" },
            { nama: "Nama", jenis: "kata" }, { nama: "O", jenis: "alfabet" }, { nama: "P", jenis: "alfabet" },
            { nama: "Q", jenis: "alfabet" }, { nama: "R", jenis: "alfabet" }, { nama: "S", jenis: "alfabet" },
            { nama: "Sama-sama", jenis: "kata" }, { nama: "Saya", jenis: "kata" }, { nama: "Siapa", jenis: "kata" },
            { nama: "Sombong", jenis: "kata" }, { nama: "T", jenis: "alfabet" }, { nama: "Takut", jenis: "kata" },
            { nama: "Terima kasih", jenis: "kata" }, { nama: "U", jenis: "alfabet" }, { nama: "V", jenis: "alfabet" },
            { nama: "W", jenis: "alfabet" }, { nama: "X", jenis: "alfabet" }, { nama: "Y", jenis: "alfabet" },
            { nama: "Z", jenis: "alfabet" }
        ];

        const katalogGrid = document.getElementById('katalog-grid');
        let kategoriAktif = 'semua';

        function renderKatalog() {
            katalogGrid.innerHTML = '';
            
            dataKatalog.forEach(item => {
                const card = document.createElement('div');
                card.className = 'item-katalog glass-card p-4 rounded-2xl flex flex-col items-center justify-between group';
                card.setAttribute('data-nama', item.nama.toUpperCase());
                card.setAttribute('data-jenis', item.jenis);

                const labelSub = item.jenis === 'alfabet' ? 'Alfabet Isyarat' : 'Kosa Kata';
                
                // Menyiapkan rute gambar terenkode (menghindari error spasi url)
                const encodedNama = encodeURIComponent(item.nama);
                const pathBase = `/images/katalog/${item.nama}`;

                card.innerHTML = `
                    <div class="w-full aspect-square bg-white/[0.02] border border-white/[0.05] rounded-xl flex items-center justify-center overflow-hidden mb-4 relative">
                        <img 
                            src="${pathBase}.jpg" 
                            alt="Isyarat ${item.nama}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            onerror="tryPng(this, '${pathBase}')"
                        >
                        <span class="absolute top-2 right-2 text-[9px] bg-sky-500/10 border border-sky-500/20 text-sky-400 px-2 py-0.5 rounded-md font-bold uppercase tracking-wider">
                            ${item.jenis}
                        </span>
                    </div>
                    <div class="text-center w-full">
                        <h3 class="text-xl font-bold text-white group-hover:text-sky-400 transition-colors tracking-tight break-words">${item.nama}</h3>
                        <p class="text-[10px] text-slate-500 tracking-wide uppercase mt-0.5">${labelSub}</p>
                    </div>
                `;
                katalogGrid.appendChild(card);
            });
            filterKatalog();
        }

        // Jalur pengecekan format gambar otomatis
        function tryPng(element, basePath) {
            element.onerror = function() { tryJpeg(element, basePath); };
            element.src = basePath + '.png';
        }

        function tryJpeg(element, basePath) {
            const namaClean = basePath.split('/').pop();
            element.onerror = function() { tryPlaceholder(element, namaClean); };
            element.src = basePath + '.jpeg';
        }

        function tryPlaceholder(element, nama) {
            element.onerror = null;
            element.src = 'https://placehold.co/300x300/0f172a/38bdf8?text=' + encodeURIComponent(nama);
        }

        function filterKatalog() {
            const query = document.getElementById('search-input').value.toUpperCase();
            const cards = document.querySelectorAll('.item-katalog');

            cards.forEach(card => {
                const nama = card.getAttribute('data-nama');
                const jenis = card.getAttribute('data-jenis');

                const cocokQuery = nama.includes(query);
                const cocokKategori = (kategoriAktif === 'semua') || (jenis === kategoriAktif);

                if (cocokQuery && cocokKategori) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function gantiKategori(kategori) {
            kategoriAktif = kategori;
            const tabs = ['semua', 'alfabet', 'kata'];
            tabs.forEach(t => {
                const btn = document.getElementById(`tab-${t}`);
                if (t === kategori) {
                    btn.className = "px-4 py-2 rounded-xl text-xs font-semibold uppercase tracking-wider bg-sky-500/10 text-sky-400 border border-sky-500/20 transition-all";
                } else {
                    btn.className = "px-4 py-2 rounded-xl text-xs font-semibold uppercase tracking-wider text-slate-400 hover:text-white transition-all";
                }
            });
            filterKatalog();
        }

        window.onload = renderKatalog;
    </script>

</body>
</html>