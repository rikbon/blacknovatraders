#!/usr/bin/env bash
set -e

INTERVAL=${SCHEDULER_INTERVAL_SEC:-60}

echo "[Scheduler] Starting BlackNova Traders game tick daemon (interval: ${INTERVAL}s)..."

# Wait for DB before starting ticks
if [ -n "$BNT_DATABASE_HOST" ] && [ "$BNT_DATABASE_HOST" != "localhost" ]; then
    echo "[Scheduler] Waiting for database ($BNT_DATABASE_HOST)..."
    until mysqladmin ping -h "$BNT_DATABASE_HOST" -P "${BNT_DATABASE_PORT:-3306}" -u "${BNT_DATABASE_USERNAME:-root}" --password="${BNT_DATABASE_PASSWORD:-root}" --skip-ssl --silent 2>/dev/null; do
        sleep 3
    done
    echo "[Scheduler] Database connection verified."
fi

while true; do
    echo "[$(date -u +'%Y-%m-%dT%H:%M:%SZ')] Running scheduler tick..."
    php /app/scheduler.php > /dev/null 2>&1 || echo "[Scheduler] Warning: Tick returned non-zero status"
    sleep "$INTERVAL"
done
