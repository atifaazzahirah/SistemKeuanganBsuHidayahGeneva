# Sistem Pencatatan dan Pelaporan Keuangan Bank Sampah Unit Hidayah Geneva

## Deskripsi Proyek

Sistem Penyetoran Bank Sampah Unit Geneva Hidayah adalah aplikasi berbasis web yang dikembangkan menggunakan **framework Laravel**. Sistem ini bertujuan untuk membantu pengelolaan data penyetoran sampah, data nasabah, jenis sampah, serta laporan penyetoran secara terstruktur, cepat, dan akurat.

Aplikasi ini dirancang untuk mendukung kegiatan operasional Bank Sampah Unit Geneva Hidayah agar lebih efektif dibandingkan dengan pencatatan manual.

---

## Fitur Utama

* Manajemen data nasabah bank sampah
* Manajemen data sampah
* Pencatatan transaksi penyetoran sampah
* Perhitungan total setoran
* Laporan penyetoran berdasarkan periode tertentu
* Sistem berbasis web dengan Laravel

---

## Teknologi yang Digunakan

* **Framework** : Laravel
* **Bahasa Pemrograman** : PHP
* **Database** : MySQL
* **Web Server** : Apache (XAMPP / Laragon)
* **Frontend** : Blade Template, HTML, CSS, JavaScript

---

## Persyaratan Sistem

Pastikan perangkat Anda telah memenuhi persyaratan berikut:

* PHP >= 8.2.12
* Composer
* MySQL / MariaDB
* Web server (XAMPP / Laragon)
* Git

---

## Instalasi dan Konfigurasi

### 1. Clone atau Unduh Proyek

Clone repository :

```bash
git clone https://github.com/atifaazzahirah/SistemKeuanganBsuHidayahGeneva.git
```
```
```
---
### 2. Install Dependency Laravel

Masuk ke folder proyek lalu jalankan perintah berikut:

```bash
composer install
```
---

### 3. Konfigurasi File Environment

Salin file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Kemudian generate application key:

```bash
php artisan key:generate
```

---

### 4. Download Database

Database **tidak disertakan langsung di repository**. Silakan unduh file database melalui Google Drive pada tautan berikut:

> **Link Google Drive Database:**
> https://drive.google.com/drive/folders/1B6xJVdGChH4vkuaZ0d4mrNcFL73Ots7C?usp=drive_link 

---

### 5. Import Database

1. Buka **phpMyAdmin**
2. Buat database baru, misalnya:

   ```
   ```

bsu_hidayah_geneva

````
3. Import file `.sql` yang telah diunduh dari Google Drive

---

### 6. Konfigurasi Database di File .env
Sesuaikan konfigurasi database pada file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bsu_hidayah_geneva
DB_USERNAME=root
DB_PASSWORD=
````

---

### 7. Menjalankan Aplikasi

Jalankan perintah berikut untuk menjalankan server Laravel:

```bash
php artisan serve
```

Akses aplikasi melalui browser:

```
http://127.0.0.1:8000
login dengan menggunakan
admin2@example.com
password : 12345678
```

---

## Struktur Direktori Penting

* `app/` : Logika aplikasi (Controller, Model)
* `resources/views/` : Tampilan (Blade)
* `routes/web.php` : Routing aplikasi
* `database/` : Konfigurasi database
* `public/` : Akses file publik

---

## Catatan Penting

* Pastikan database telah diimpor sebelum menjalankan aplikasi
* Jika terjadi error permission, pastikan folder `storage` dan `bootstrap/cache` memiliki izin akses

---

## Penutup

Sistem ini diharapkan dapat membantu pengelolaan penyetoran Bank Sampah Unit Geneva Hidayah secara digital dan terintegrasi. Pengembangan lebih lanjut dapat dilakukan dengan menambahkan fitur laporan grafik, export data, dan manajemen pengguna.

---

**Dikembangkan menggunakan Laravel** 🚀
