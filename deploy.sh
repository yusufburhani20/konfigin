#!/bin/bash
# ==========================================
# KONFIGIN Smart Auto Deployment Script
# ==========================================

LOG_PREFIX="[$(date '+%H:%M:%S')]"
APP_DIR="$(cd "$(dirname "$0")" && pwd)"

# Nonaktifkan interaksi terminal untuk git
export GIT_TERMINAL_PROMPT=0
export GIT_ASKPASS=echo
export SSH_ASKPASS=echo

# Pastikan git safe directory
git config --global --add safe.directory "$APP_DIR" 2>/dev/null || true

# Fungsi untuk menangani error fatal
die() {
    echo "$LOG_PREFIX ❌ ERROR: $1"
    echo "[PROCESS_FAILED]"
    exit 1
}

echo "$LOG_PREFIX 🚀 Memulai proses deployment KONFIGIN..."

# 1. Pindah ke direktori utama
cd "$APP_DIR" || die "Gagal masuk ke direktori $APP_DIR"

OLD_COMMIT=$(git rev-parse HEAD 2>/dev/null || echo "initial")

# 2. Menarik kode terbaru dari GitHub
echo "$LOG_PREFIX 📥 Menarik kode terbaru dari GitHub..."

if [ -n "$GITHUB_TOKEN" ] && [ -n "$GITHUB_USER" ]; then
    GITHUB_USER=$(echo "$GITHUB_USER" | tr -d '[:space:]')
    GITHUB_TOKEN=$(echo "$GITHUB_TOKEN" | tr -d '[:space:]')
    REPO_URL=$(git remote get-url origin)
    CLEAN_PATH=$(echo "$REPO_URL" | sed -E -e 's|https://([^@]+@)?github.com/||' -e 's|git@github.com:||' -e 's|\.git$||' | tr -d '[:space:]')
    CLEAN_PATH=${CLEAN_PATH%/}
    AUTHED_URL="https://${GITHUB_USER}:${GITHUB_TOKEN}@github.com/${CLEAN_PATH}.git"
    git fetch "$AUTHED_URL" main 2>&1
else
    git fetch origin main 2>&1
fi

if [ $? -ne 0 ]; then
    die "git fetch GAGAL! Periksa koneksi atau kredensial GitHub."
fi

# Reset ke FETCH_HEAD
git reset --hard FETCH_HEAD 2>&1 || die "Gagal melakukan git reset --hard ke kode terbaru."
NEW_COMMIT=$(git rev-parse HEAD 2>/dev/null)

echo "$LOG_PREFIX ✅ Kode berhasil disinkronkan ($OLD_COMMIT -> $NEW_COMMIT)."

# Deteksi perubahan file
if [ "$OLD_COMMIT" != "$NEW_COMMIT" ] && [ "$OLD_COMMIT" != "initial" ]; then
    CHANGED_FILES=$(git diff --name-only "$OLD_COMMIT" "$NEW_COMMIT" 2>/dev/null)
else
    CHANGED_FILES=""
fi

# 3. Dependensi PHP (Composer) - Hanya jika composer.lock berubah
if echo "$CHANGED_FILES" | grep -qE "^composer\.(lock|json)"; then
    echo "$LOG_PREFIX 📦 Perubahan dependensi PHP terdeteksi, menjalankan composer install..."
    /www/server/php/83/bin/php /usr/bin/composer install --no-dev --optimize-autoloader --no-interaction 2>&1 || die "Gagal composer install"
else
    echo "$LOG_PREFIX ⏩ Tidak ada perubahan composer.lock, melewati composer install."
fi

# 4. Migrasi Database - Jalankan jika ada perubahan file migration atau deploy pertama
if [ -z "$CHANGED_FILES" ] || echo "$CHANGED_FILES" | grep -qE "^database/migrations/"; then
    echo "$LOG_PREFIX 🗄️  Memeriksa / menjalankan migrasi database..."
    /www/server/php/83/bin/php artisan migrate --force 2>&1 || die "Gagal menjalankan migrasi database"
else
    echo "$LOG_PREFIX ⏩ Tidak ada file migration baru, melewati artisan migrate."
fi

# 5. Build Aset Frontend (NPM/Vite) - Hanya jika ada perubahan package atau asset frontend
if echo "$CHANGED_FILES" | grep -qE "^package(-lock)?\.json"; then
    echo "$LOG_PREFIX 📦 Dependensi npm berubah, menjalankan npm install..."
    npm install --legacy-peer-deps 2>&1 || echo "$LOG_PREFIX ⚠️  Peringatan: npm install gagal."
fi

if echo "$CHANGED_FILES" | grep -qE "(^vite\.config\.js|^package(-lock)?\.json|^resources/(css|js)/)"; then
    echo "$LOG_PREFIX 🏗️  Membangun aset frontend (npm run build)..."
    npm run build 2>&1 || echo "$LOG_PREFIX ⚠️  Peringatan: npm run build gagal."
else
    echo "$LOG_PREFIX ⏩ Tidak ada perubahan aset frontend Vite, melewati build."
fi

# 6. Set permission direktori yang wajib writable (storage & bootstrap/cache)
chown -R www:www storage bootstrap/cache 2>/dev/null || true
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

# 7. Bersihkan Cache Laravel (cukup 1 perintah optimize:clear)
echo "$LOG_PREFIX 🧹 Membersihkan cache aplikasi..."
/www/server/php/83/bin/php artisan optimize:clear 2>&1

echo "$LOG_PREFIX ✅ DEPLOYMENT SELESAI SUKSES!"
echo "[PROCESS_COMPLETED]"
