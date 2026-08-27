<?php
// Lógica de Back-end com WAF (Web Application Firewall) Simulado
if(isset($_GET['ajax']) && isset($_GET['ip']) && !empty($_GET['ip'])){
    $ip = $_GET['ip'];
    
    // --- INÍCIO DO FILTRO DE SEGURANÇA (WAF) ---
    // Bloqueia tentativas fáceis de leitura e a palavra "flag"
    $blacklist = ['cat', 'flag', 'tail', 'less', 'head', 'more', 'nano', 'vim', 'vi'];
    
    foreach($blacklist as $word) {
        if(stripos($ip, $word) !== false) {
            echo "[!] AEGIS WAF ALERT: Comportamento malicioso detectado. A string '{$word}' é proibida.";
            exit;
        }
    }
    // --- FIM DO FILTRO ---

    $output = shell_exec("ping -c 4 " . $ip);
    sleep(1);
    
    if($output === null) {
        echo "[!] Erro crítico: Falha ao alcançar o host ou comando inválido.";
    } else {
        echo $output;
    }
    exit; 
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aegis NOC | Network Diagnostics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #0f172a; color: #e2e8f0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; }
        .sidebar { background-color: #0b1120; border-right: 1px solid #1e293b; }
        .topbar { background-color: #0f172a; border-bottom: 1px solid #1e293b; }
        .card { background-color: #1e293b; border: 1px solid #334155; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .terminal-output { font-family: 'Consolas', 'Courier New', monospace; background-color: #020617; color: #22c55e; }
        .cursor-blink { animation: blink 1s step-end infinite; }
        @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0; } }
    </style>
</head>
<body class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="sidebar w-64 h-full flex flex-col hidden md:flex">
        <div class="p-5 flex items-center gap-3 border-b border-slate-800">
            <div class="w-8 h-8 bg-indigo-600 rounded flex items-center justify-center font-bold text-white shadow-lg shadow-indigo-500/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <span class="text-xl font-bold text-white tracking-wide">Aegis NOC</span>
        </div>
        <nav class="flex-1 py-4">
            <ul class="space-y-1 text-sm font-medium">
                <li><a href="#" class="flex items-center gap-3 px-5 py-3 text-slate-400 hover:bg-slate-800 hover:text-white transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg> Dashboard</a></li>
                <li><a href="#" class="flex items-center gap-3 px-5 py-3 bg-indigo-600/10 text-indigo-400 border-r-4 border-indigo-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg> Diagnostics</a></li>
            </ul>
        </nav>
        <div class="p-5 border-t border-slate-800">
            <div class="flex items-center gap-3">
                <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                <span class="text-xs text-slate-400 uppercase tracking-widest">Cluster Online</span>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full overflow-hidden bg-slate-900">
        
        <header class="topbar h-16 px-6 flex items-center justify-between">
            <div>
                <h1 class="text-lg font-semibold text-white">Network Diagnostics Center</h1>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-xs px-2 py-1 bg-slate-800 rounded text-slate-300 border border-slate-700">Restricted Access</span>
                <div class="w-8 h-8 bg-indigo-900 rounded-full flex items-center justify-center text-sm font-bold text-indigo-300 border border-indigo-700">W</div>
            </div>
        </header>

        <div class="flex-1 overflow-auto p-6 lg:p-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="card p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Avg Latency</p>
                            <p class="text-2xl font-bold text-white mt-1">12.4 <span class="text-sm text-slate-500 font-normal">ms</span></p>
                        </div>
                        <div class="p-2 bg-emerald-500/10 rounded-lg"><svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg></div>
                    </div>
                </div>
                <div class="card p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">WAF Rules</p>
                            <p class="text-2xl font-bold text-white mt-1">Active</p>
                        </div>
                        <div class="p-2 bg-indigo-500/10 rounded-lg"><svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg></div>
                    </div>
                </div>
                <div class="card p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Active Nodes</p>
                            <p class="text-2xl font-bold text-white mt-1">142</p>
                        </div>
                        <div class="p-2 bg-sky-500/10 rounded-lg"><svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div>
                    </div>
                </div>
            </div>

            <!-- Formulário de Interação -->
            <div class="card p-1 mb-6 bg-slate-800/50 border-slate-700">
                <form id="pingForm" class="flex flex-col sm:flex-row gap-2">
                    <div class="flex-grow relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-slate-500 font-mono text-sm">target ></span>
                        </div>
                        <input type="text" id="ipInput" placeholder="Enter IP or FQDN (e.g., 127.0.0.1)" 
                               class="w-full bg-transparent border-none rounded-lg pl-24 pr-4 py-4 text-sm text-white placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all" required>
                    </div>
                    <button type="submit" id="submitBtn" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-4 px-8 rounded-md shadow-lg shadow-indigo-600/20 transition-all flex items-center justify-center gap-2 m-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Execute
                    </button>
                </form>
            </div>

            <!-- Terminal -->
            <div class="card overflow-hidden border-slate-700 shadow-2xl flex flex-col h-[400px]">
                <div class="bg-slate-800 px-4 py-2 border-b border-slate-700 flex justify-between items-center">
                    <div class="flex gap-2">
                        <div class="w-3 h-3 rounded-full bg-slate-600"></div>
                        <div class="w-3 h-3 rounded-full bg-slate-600"></div>
                        <div class="w-3 h-3 rounded-full bg-slate-600"></div>
                    </div>
                    <span class="text-[11px] text-slate-400 font-mono uppercase tracking-widest">www-data@srv-01:~</span>
                </div>
                
                <div class="terminal-output flex-1 p-5 overflow-y-auto relative">
                    <pre id="terminalContent" class="whitespace-pre-wrap text-sm leading-relaxed mt-2 text-slate-400">System diagnostic tool initialized. Waiting for parameters...<span class="cursor-blink text-slate-400">_</span></pre>
                </div>
            </div>
        </div>
    </main>
    
    <script>
        document.getElementById('pingForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const ip = document.getElementById('ipInput').value;
            const terminal = document.getElementById('terminalContent');
            const btn = document.getElementById('submitBtn');
            
            btn.disabled = true;
            btn.innerHTML = '<svg class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            
            terminal.innerHTML = `<span class="text-indigo-400">www-data@srv-01:~$</span> ping_tool --target ${ip}<br><br>`;
            terminal.innerHTML += `<span class="text-amber-400">[*] Resolving DNS and establishing ICMP socket...</span><br><br><span class="cursor-blink text-green-500">_</span>`;
            
            try {
                const response = await fetch(`?ajax=1&ip=${encodeURIComponent(ip)}`);
                const data = await response.text();
                
                setTimeout(() => {
                    // Se o WAF bloquear, a saída fica vermelha
                    if(data.includes("WAF ALERT")) {
                        terminal.innerHTML = `<span class="text-indigo-400">www-data@srv-01:~$</span> ping_tool --target ${ip}<br><br><span class="text-red-500">${data}</span><br><br><span class="text-indigo-400">www-data@srv-01:~$</span> <span class="cursor-blink text-green-500">_</span>`;
                    } else {
                        terminal.innerHTML = `<span class="text-indigo-400">www-data@srv-01:~$</span> ping_tool --target ${ip}<br><br><span class="text-green-500">${data}</span><br><br><span class="text-indigo-400">www-data@srv-01:~$</span> <span class="cursor-blink text-green-500">_</span>`;
                    }
                    resetButton();
                }, 1000); 

            } catch (error) {
                terminal.innerHTML += `<br><span class="text-red-500">[!] Connection error.</span>`;
                resetButton();
            }

            function resetButton() {
                btn.disabled = false;
                btn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg> Execute';
            }
        });
    </script>
</body>
</html>