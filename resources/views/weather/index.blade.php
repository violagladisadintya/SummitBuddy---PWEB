@extends('layouts.app')

@section('title', 'Info Cuaca Gunung - SummitBuddy')

@section('hero')
<header class="hero-small">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Info Cuaca Gunung</h1>
        <p>Cek kondisi cuaca sebelum memulai pendakianmu</p>
    </div>
</header>
@endsection

@section('content')
<div class="weather-container">
    <div class="location-selector">
        <label for="mountainSelect">Pilih Lokasi Pendakian:</label>
        <select id="mountainSelect" class="mountain-select">
            <option value="Semeru">🏔️ Gunung Semeru</option>
            <option value="Rinjani">🏔️ Gunung Rinjani</option>
            <option value="Bromo">🌋 Gunung Bromo</option>
            <option value="Merbabu">🏔️ Gunung Merbabu</option>
            <option value="Merapi">🌋 Gunung Merapi</option>
            <option value="Prau">🏔️ Gunung Prau</option>
            <option value="Sumbing">🏔️ Gunung Sumbing</option>
            <option value="Lawu">🏔️ Gunung Lawu</option>
        </select>
        <button id="refreshWeatherBtn" class="btn-refresh-weather">🔄 Refresh Cuaca</button>
    </div>

    <div class="weather-card" id="weatherCard">
        <div class="weather-loading" id="weatherLoading">
            <div class="spinner"></div>
            <p>Mengambil data cuaca...</p>
        </div>

        <div class="weather-content" id="weatherContent" style="display: none;">
            <div class="weather-header">
                <div class="weather-location">
                    <h2 id="weatherLocation">Gunung Semeru</h2>
                    <p id="weatherDesc">-</p>
                </div>
                <img id="weatherIcon" src="" alt="weather icon" class="weather-icon">
            </div>

            <div class="weather-temp">
                <span id="weatherTemp" class="temp-value">--</span>
                <span class="temp-unit">°C</span>
            </div>

            <div class="weather-details">
                <div class="detail-item">
                    <span class="detail-label">🌡️ Terasa Seperti</span>
                    <span class="detail-value" id="weatherFeelsLike">--°C</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">💧 Kelembaban</span>
                    <span class="detail-value" id="weatherHumidity">--%</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">💨 Kecepatan Angin</span>
                    <span class="detail-value" id="weatherWind">-- km/h</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">👁️ Visibilitas</span>
                    <span class="detail-value" id="weatherVisibility">-- km</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">📊 Tekanan Udara</span>
                    <span class="detail-value" id="weatherPressure">-- mb</span>
                </div>
            </div>

            <div class="weather-tips">
                <div class="tips-header">
                    <span>🎒 Tips Pendakian</span>
                </div>
                <div class="tips-content" id="weatherTips"></div>
            </div>

            <div class="weather-update">
                <small>Terakhir diperbarui: <span id="weatherTime">-</span></small>
                <button onclick="loadWeather()" class="btn-small-refresh">🔄 Refresh</button>
            </div>
        </div>

        <div class="weather-error" id="weatherError" style="display: none;">
            <p>⚠️ Gagal memuat data cuaca</p>
            <p class="error-hint">Periksa koneksi internet dan coba lagi</p>
            <button onclick="loadWeather()" class="btn-retry">Coba Lagi</button>
        </div>
    </div>
</div>

<style>
.weather-container {
    max-width: 600px;
    margin: 0 auto;
}

.location-selector {
    background: white;
    padding: 20px;
    border-radius: 20px;
    margin-bottom: 20px;
    display: flex;
    gap: 15px;
    align-items: center;
    flex-wrap: wrap;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

.dark .location-selector {
    background: #2d2d44;
}

.location-selector label {
    font-weight: 600;
    color: #1b5e2f;
    margin: 0;
}

.dark .location-selector label {
    color: #ff8c42;
}

.mountain-select {
    flex: 1;
    padding: 12px 20px;
    border: 2px solid #e0e0e0;
    border-radius: 50px;
    font-size: 14px;
    background: white;
    cursor: pointer;
}

.dark .mountain-select {
    background: #1a1a2e;
    border-color: #3d3d5c;
    color: #eee;
}

.btn-refresh-weather {
    background: linear-gradient(135deg, #1b5e2f, #43a047);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 50px;
    cursor: pointer;
    font-weight: 500;
}

.weather-card {
    background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%);
    border-radius: 30px;
    padding: 30px;
    color: white;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}

.weather-loading {
    text-align: center;
    padding: 40px;
}

.spinner {
    width: 50px;
    height: 50px;
    border: 4px solid rgba(255,255,255,0.3);
    border-top-color: white;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 20px;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.weather-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.weather-location h2 {
    font-size: 28px;
    margin: 0 0 5px 0;
}

.weather-location p {
    opacity: 0.9;
    margin: 0;
    font-size: 14px;
}

.weather-icon {
    width: 80px;
    height: 80px;
    filter: drop-shadow(2px 2px 4px rgba(0,0,0,0.2));
}

.weather-temp {
    text-align: center;
    margin: 20px 0;
}

.temp-value {
    font-size: 64px;
    font-weight: bold;
}

.temp-unit {
    font-size: 28px;
    opacity: 0.8;
}

.weather-details {
    background: rgba(255,255,255,0.2);
    border-radius: 20px;
    padding: 15px;
    margin: 20px 0;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid rgba(255,255,255,0.2);
}

.detail-item:last-child {
    border-bottom: none;
}

.weather-tips {
    background: rgba(0,0,0,0.3);
    border-radius: 15px;
    padding: 15px;
    margin: 15px 0;
}

.tips-header {
    font-weight: bold;
    margin-bottom: 10px;
    font-size: 14px;
}

.tips-content {
    font-size: 13px;
    line-height: 1.5;
}

.weather-update {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 15px;
    font-size: 11px;
    opacity: 0.7;
}

.btn-small-refresh, .btn-retry {
    background: rgba(255,255,255,0.2);
    border: none;
    padding: 6px 12px;
    border-radius: 20px;
    color: white;
    cursor: pointer;
    font-size: 12px;
}

.weather-error {
    text-align: center;
    padding: 40px;
}

.error-hint {
    font-size: 12px;
    opacity: 0.7;
}
</style>

@push('scripts')
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

async function loadWeather() {
    const loadingDiv = document.getElementById('weatherLoading');
    const contentDiv = document.getElementById('weatherContent');
    const errorDiv = document.getElementById('weatherError');
    const select = document.getElementById('mountainSelect');
    const location = select ? select.value : 'Semeru';

    loadingDiv.style.display = 'block';
    contentDiv.style.display = 'none';
    errorDiv.style.display = 'none';

    try {
        const response = await fetch(`/api/weather?location=${encodeURIComponent(location)}`, {
            headers: { 'Accept': 'application/json' }
        });

        if (!response.ok) throw new Error('Gagal mengambil data');

        const result = await response.json();

        if (result.success) {
            const data = result.data;
            document.getElementById('weatherLocation').textContent = data.location;
            document.getElementById('weatherDesc').textContent = data.description;
            document.getElementById('weatherTemp').textContent = data.temperature;
            document.getElementById('weatherFeelsLike').textContent = data.feels_like + '°C';
            document.getElementById('weatherHumidity').textContent = data.humidity + '%';
            document.getElementById('weatherWind').textContent = data.wind_speed + ' km/h';
            document.getElementById('weatherVisibility').textContent = data.visibility + ' km';
            document.getElementById('weatherPressure').textContent = data.pressure + ' mb';
            if (data.icon_url) document.getElementById('weatherIcon').src = data.icon_url;
            document.getElementById('weatherTime').textContent = new Date().toLocaleTimeString('id-ID');

            const temp = parseInt(data.temperature);
            const desc = data.description.toLowerCase();
            let tips = '';
            if (temp < 10) tips += '❄️ Suhu sangat dingin! Bawa jaket tebal.<br>';
            else if (temp < 20) tips += '🧥 Suhu dingin, bawa jaket hangat.<br>';
            if (desc.includes('rain')) tips += '☔ Bawa jas hujan!<br>';
            if (parseInt(data.wind_speed) > 20) tips += '💨 Angin kencang! Waspada.<br>';
            if (tips === '') tips = '🏔️ Cuaca cerah, selamat mendaki!';
            document.getElementById('weatherTips').innerHTML = tips;

            loadingDiv.style.display = 'none';
            contentDiv.style.display = 'block';
        } else {
            throw new Error(result.message);
        }
    } catch (error) {
        loadingDiv.style.display = 'none';
        errorDiv.style.display = 'block';
    }
}

document.getElementById('mountainSelect')?.addEventListener('change', loadWeather);
document.getElementById('refreshWeatherBtn')?.addEventListener('click', loadWeather);
document.addEventListener('DOMContentLoaded', loadWeather);
</script>
@endpush
@endsection
