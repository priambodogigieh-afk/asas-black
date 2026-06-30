# Asas Black IoT Dashboard

Dashboard Laravel untuk monitoring alat peraga Hukum Asas Black menggunakan 3 sensor DS18B20 berbasis NodeMCU ESP8266.

## Fitur

- Login guru dan siswa berbasis database.
- Dashboard guru untuk monitoring sensor dan penilaian praktikum.
- Praktikum siswa dengan kalkulasi Asas Black.
- MQTT subscriber IoTKita untuk topic:
  - `asasblack/suhu/panas`
  - `asasblack/suhu/dingin`
  - `asasblack/suhu/campuran`
- API realtime `GET /api/sensor/latest`.
- Card suhu realtime, LCD virtual 16x2, dan Chart.js realtime.
- Penilaian guru: nilai, komentar, status `Lulus` atau `Revisi`.

## Setup

```bash
composer install
npm install
php artisan migrate
npm run build
php artisan serve
```

Jalankan subscriber MQTT pada terminal terpisah:

```bash
php artisan mqtt:subscribe
```

## Environment MQTT

Isi nilai berikut di `.env` lokal atau di environment variables Railway. Jangan commit file `.env`.

```env
MQTT_HOST=mqtt.iotkita.com
MQTT_PORT=1883
MQTT_USERNAME=...
MQTT_PASSWORD=...
MQTT_CLIENT_ID=laravel_asas_black_dashboard
IOTKITA_API_KEY=...

# Tambahkan konfigurasi TLS jika menggunakan broker MQTT yang aman (port 8883/ssl)
MQTT_TLS_ENABLED=false
MQTT_TLS_ALLOW_SELF_SIGNED_CERT=false
MQTT_TLS_VERIFY_PEER=true
MQTT_TLS_VERIFY_PEER_NAME=true

# Lokasi binary PHP CLI (default 'php')
PHP_PATH=php
```

## Hosting di Railway

Saat menghosting aplikasi ini di Railway, pastikan Anda melakukan hal berikut agar koneksi MQTT berjalan dengan baik:

1. **Konfigurasi Environment Variables**:
   Masukkan semua variabel lingkungan di atas ke panel **Variables** di Railway service Anda. Jika menggunakan broker MQTT publik (seperti EMQX atau HiveMQ Cloud) yang menggunakan koneksi aman, ubah `MQTT_TLS_ENABLED` menjadi `true`, `MQTT_PORT` menjadi `8883` (atau port SSL yang sesuai), dan sesuaikan host/username/password.

2. **Dua Pilihan Menjalankan Subscriber MQTT di Railway**:

   * **Opsi A: Melalui Tombol UI "Konek MQTT" (Default)**
     - Ketika pengguna mengklik tombol "Konek MQTT" pada halaman dashboard di web server, backend akan mendeteksi path CLI PHP secara otomatis (menggunakan `PHP_PATH=php` ketika FPM aktif) dan menjalankan `php artisan mqtt:subscribe` di background container web.
     - **Catatan**: Opsi ini bersifat *ephemeral* (proses background akan mati jika container web dimulai ulang atau jika ada deployment baru). Pengguna harus mengklik kembali tombol "Konek MQTT" jika data berhenti terupdate.

   * **Opsi B: Sebagai Worker Service Terpisah (Sangat Direkomendasikan)**
     - Aplikasi ini sudah dilengkapi dengan `Procfile` yang mendefinisikan proses `worker` untuk menjalankan daemon subscriber MQTT secara terus-menerus.
     - Di dashboard Railway, tambahkan service baru (**New Service**) -> **GitHub Repo** -> pilih repository yang sama.
     - Pada service baru tersebut, buka tab **Settings** -> bagian **Deploy** -> ubah **Start Command** menjadi:
       ```bash
       php artisan mqtt:subscribe
       ```
     - Railway akan menjalankan service tersebut sebagai background worker yang terus aktif. Jika daemon subscriber mengalami crash atau broker terputus, Railway secara otomatis akan me-restart service tersebut agar monitoring sensor tetap berjalan secara realtime tanpa harus menekan tombol "Konek MQTT" di UI web.

## Struktur Utama

- `config/mqtt-client.php` konfigurasi MQTT Laravel.
- `app/Console/Commands/MqttSubscribeCommand.php` subscriber MQTT.
- `app/Models/SensorReading.php` model pembacaan sensor.
- `app/Http/Controllers/SensorReadingController.php` endpoint data realtime.
- `database/migrations/*sensor_readings*` tabel data sensor.
- `resources/js/app.js` fetch realtime, LCD virtual, Chart.js, kalkulasi Asas Black.
- `resources/views/pages/shared/praktikum.blade.php` dashboard praktikum siswa.
- `resources/views/pages/shared/monitoring.blade.php` monitoring sensor.
- `resources/views/pages/teacher/dashboard.blade.php` dashboard monitoring guru.
