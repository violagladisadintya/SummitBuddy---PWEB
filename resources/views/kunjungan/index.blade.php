@extends('layouts.app')

@section('title', 'Statistik Kunjungan - SummitBuddy')

@section('hero')
<header class="hero-small">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Statistik Kunjungan</h1>
        <p>Pantau aktivitasmu di SummitBuddy</p>
    </div>
</header>
@endsection

@section('content')
<div class="kunjungan-container">
    <div class="stats-card">
        <div class="stats-header">
            <div class="stats-icon">📊</div>
            <h2>Statistik Kunjungan</h2>
        </div>

        <div class="stats-grid">
            <div class="stat-badge">
                <div class="badge-icon">🔢</div>
                <div class="badge-info">
                    <span class="badge-label">Total Kunjungan</span>
                    <span class="badge-value" id="statJumlah">{{ $jumlah }}</span>
                </div>
            </div>
            <div class="stat-badge">
                <div class="badge-icon">🕐</div>
                <div class="badge-info">
                    <span class="badge-label">Pertama Kali</span>
                    <span class="badge-value" id="statPertama">{{ $pertama ?? 'Belum ada' }}</span>
                </div>
            </div>
            <div class="stat-badge">
                <div class="badge-icon">🔄</div>
                <div class="badge-info">
                    <span class="badge-label">Terakhir Kali</span>
                    <span class="badge-value" id="statTerakhir">{{ $terakhir ?? 'Belum ada' }}</span>
                </div>
            </div>
        </div>

        <div class="stats-actions">
            <button id="resetStatsBtn" class="btn-reset-stats">🗑️ Reset Statistik</button>
            <button id="refreshStatsBtn" class="btn-refresh-stats">🔄 Refresh</button>
        </div>

        <div class="stats-info">
            <div class="info-icon">💡</div>
            <div class="info-text">Data kunjungan disimpan di server menggunakan Laravel Session.</div>
        </div>
    </div>

    <div class="aktivitas-card">
        <h3>📋 Riwayat Aktivitas</h3>
        <div id="aktivitasList" class="aktivitas-list">
            @php $aktivitas = session('aktivitas_kunjungan', []); @endphp
            @forelse($aktivitas as $act)
                <div class="aktivitas-item">
                    <span class="aktivitas-time">{{ $act['waktu'] }}</span>
                    <span class="aktivitas-desc">Kunjungan ke-{{ $act['jumlah_ke'] }}</span>
                </div>
            @empty
                <p class="empty-aktivitas">Belum ada aktivitas</p>
            @endforelse
        </div>
    </div>

    <div class="explanation-card">
        <h3>🏔️ Informasi Session</h3>
        <div class="session-info">
            <div class="session-row"><span>Session ID:</span><code>{{ session()->getId() }}</code></div>
            <div class="session-row"><span>Driver Session:</span><code>{{ config('session.driver') }}</code></div>
        </div>
    </div>
</div>

<style>
.kunjungan-container { max-width: 800px; margin: 0 auto; }
.stats-card { background: linear-gradient(135deg, #1b5e2f 0%, #43a047 100%); border-radius: 30px; padding: 40px; color: white; margin-bottom: 30px; }
.stats-header { display: flex; align-items: center; gap: 15px; margin-bottom: 30px; }
.stats-icon { font-size: 48px; }
.stats-header h2 { margin: 0; font-size: 28px; }
.stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
.stat-badge { background: rgba(255,255,255,0.15); border-radius: 20px; padding: 20px; display: flex; align-items: center; gap: 15px; }
.badge-icon { font-size: 32px; }
.badge-label { display: block; font-size: 12px; opacity: 0.8; margin-bottom: 5px; }
.badge-value { display: block; font-size: 20px; font-weight: bold; }
.stats-actions { display: flex; gap: 15px; margin-bottom: 20px; }
.btn-reset-stats, .btn-refresh-stats { padding: 12px 24px; border: none; border-radius: 50px; cursor: pointer; font-weight: 600; background: rgba(255,255,255,0.2); color: white; }
.stats-info { background: rgba(255,255,255,0.15); border-radius: 15px; padding: 15px; display: flex; gap: 15px; font-size: 13px; }
.aktivitas-card { background: white; border-radius: 20px; padding: 25px; margin-bottom: 20px; box-shadow: 0 5px 20px rgba(0,0,0,0.08); }
.dark .aktivitas-card { background: #2d2d44; color: #eee; }
.aktivitas-card h3 { margin-bottom: 20px; color: #1b5e2f; }
.dark .aktivitas-card h3 { color: #ff8c42; }
.aktivitas-item { display: flex; justify-content: space-between; padding: 12px; border-bottom: 1px solid #f0f0f0; }
.dark .aktivitas-item { border-bottom-color: #3d3d5c; }
.empty-aktivitas { text-align: center; padding: 20px; color: #999; }
.explanation-card { background: white; border-radius: 20px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.08); }
.dark .explanation-card { background: #2d2d44; color: #eee; }
.session-info { background: #f5f5f5; border-radius: 12px; padding: 15px; margin-top: 15px; font-size: 12px; }
.dark .session-info { background: #1a1a2e; }
.session-row { display: flex; justify-content: space-between; padding: 5px 0; }
</style>

@push('scripts')
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;
async function refreshStats() {
    const response = await fetch('{{ route("kunjungan.stats") }}', { headers: { 'Accept': 'application/json' } });
    const result = await response.json();
    if (result.success) {
        document.getElementById('statJumlah').textContent = result.jumlah;
        document.getElementById('statPertama').textContent = result.pertama || 'Belum ada';
        document.getElementById('statTerakhir').textContent = result.terakhir || 'Belum ada';
        const listDiv = document.getElementById('aktivitasList');
        if (result.aktivitas && result.aktivitas.length > 0) {
            listDiv.innerHTML = result.aktivitas.map(a => `<div class="aktivitas-item"><span class="aktivitas-time">${a.waktu}</span><span class="aktivitas-desc">Kunjungan ke-${a.jumlah_ke}</span></div>`).join('');
        } else {
            listDiv.innerHTML = '<p class="empty-aktivitas">Belum ada aktivitas</p>';
        }
    }
}
async function resetStats() {
    if (!confirm('Reset statistik kunjungan?')) return;
    const response = await fetch('{{ route("kunjungan.reset") }}', { method: 'DELETE', headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF } });
    const result = await response.json();
    if (result.success) { refreshStats(); alert(result.message); }
}
document.getElementById('resetStatsBtn')?.addEventListener('click', resetStats);
document.getElementById('refreshStatsBtn')?.addEventListener('click', refreshStats);
</script>
@endpush
@endsection
