-- =====================================================
-- REWARD DATETIME MIGRATION SQL
-- Run this in GreenCup_Admin database
-- =====================================================

-- =====================================================
-- FOR MYSQL/MARIADB
-- =====================================================
ALTER TABLE rewards 
MODIFY COLUMN valid_from DATETIME NOT NULL,
MODIFY COLUMN valid_until DATETIME NOT NULL;

-- Verify changes
DESCRIBE rewards;


-- =====================================================
-- FOR POSTGRESQL
-- =====================================================
ALTER TABLE rewards 
ALTER COLUMN valid_from TYPE TIMESTAMP,
ALTER COLUMN valid_until TYPE TIMESTAMP;

-- Verify changes
\d rewards;


-- =====================================================
-- FOR SQLITE (Requires Table Recreation)
-- =====================================================

-- Step 1: Create new table with datetime columns
CREATE TABLE rewards_new (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    points_required INTEGER NOT NULL,
    quantity INTEGER NOT NULL,
    quantity_redeemed INTEGER DEFAULT 0,
    image_path VARCHAR(255),
    valid_from DATETIME NOT NULL,
    valid_until DATETIME NOT NULL,
    is_active BOOLEAN DEFAULT 1,
    seller_id INTEGER NOT NULL,
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (seller_id) REFERENCES sellers(id) ON DELETE CASCADE
);

-- Step 2: Copy data with datetime conversion
-- This converts DATE to DATETIME
-- valid_from: converts to start of day (00:00:00)
-- valid_until: converts to end of day (23:59:59)
INSERT INTO rewards_new 
SELECT 
    id,
    name,
    description,
    points_required,
    quantity,
    quantity_redeemed,
    image_path,
    datetime(valid_from) as valid_from,
    datetime(valid_until, '+23 hours +59 minutes +59 seconds') as valid_until,
    is_active,
    seller_id,
    created_at,
    updated_at
FROM rewards;

-- Step 3: Verify data copied correctly
SELECT 
    id, 
    name, 
    valid_from, 
    valid_until,
    datetime(valid_until) as check_datetime
FROM rewards_new 
LIMIT 5;

-- Step 4: Drop old table
DROP TABLE rewards;

-- Step 5: Rename new table
ALTER TABLE rewards_new RENAME TO rewards;

-- Step 6: Verify final structure
PRAGMA table_info(rewards);

-- Step 7: Verify all data is present
SELECT COUNT(*) as total_rewards FROM rewards;


-- =====================================================
-- ROLLBACK SCRIPT (IF NEEDED)
-- =====================================================

-- FOR MYSQL/MARIADB
ALTER TABLE rewards 
MODIFY COLUMN valid_from DATE NOT NULL,
MODIFY COLUMN valid_until DATE NOT NULL;

-- FOR POSTGRESQL
ALTER TABLE rewards 
ALTER COLUMN valid_from TYPE DATE,
ALTER COLUMN valid_until TYPE DATE;

-- FOR SQLITE: Restore from backup
-- cp database.backup.sqlite database.sqlite


-- =====================================================
-- DATA VERIFICATION QUERIES
-- =====================================================

-- Check if datetime values are correct
SELECT 
    id,
    name,
    valid_from,
    valid_until,
    CASE 
        WHEN valid_from <= datetime('now') AND valid_until >= datetime('now') 
        THEN 'ACTIVE'
        ELSE 'INACTIVE'
    END as status
FROM rewards
ORDER BY valid_until DESC;

-- Check rewards expiring soon (within 24 hours)
SELECT 
    id,
    name,
    valid_until,
    CAST((julianday(valid_until) - julianday('now')) * 24 AS INTEGER) as hours_remaining
FROM rewards
WHERE valid_until >= datetime('now')
    AND valid_until <= datetime('now', '+24 hours')
ORDER BY hours_remaining ASC;

-- Check expired rewards
SELECT 
    id,
    name,
    valid_until,
    datetime('now') as current_time
FROM rewards
WHERE valid_until < datetime('now')
ORDER BY valid_until DESC;


-- =====================================================
-- SAMPLE TEST DATA
-- =====================================================

-- Insert test reward expiring in 2 hours
INSERT INTO rewards (
    name, 
    description, 
    points_required, 
    quantity, 
    quantity_redeemed, 
    valid_from, 
    valid_until, 
    is_active, 
    seller_id,
    created_at,
    updated_at
) VALUES (
    'Test Reward - 2 Hours',
    'This reward expires in 2 hours for testing countdown',
    100,
    10,
    0,
    datetime('now'),
    datetime('now', '+2 hours'),
    1,
    1, -- Replace with actual seller_id
    datetime('now'),
    datetime('now')
);

-- Insert test reward expiring in 30 minutes (for urgent testing)
INSERT INTO rewards (
    name, 
    description, 
    points_required, 
    quantity, 
    quantity_redeemed, 
    valid_from, 
    valid_until, 
    is_active, 
    seller_id,
    created_at,
    updated_at
) VALUES (
    'Test Reward - 30 Minutes',
    'This reward expires in 30 minutes for testing countdown',
    50,
    5,
    0,
    datetime('now'),
    datetime('now', '+30 minutes'),
    1,
    1, -- Replace with actual seller_id
    datetime('now'),
    datetime('now')
);

-- Insert test reward expiring in 7 days (for long-term testing)
INSERT INTO rewards (
    name, 
    description, 
    points_required, 
    quantity, 
    quantity_redeemed, 
    valid_from, 
    valid_until, 
    is_active, 
    seller_id,
    created_at,
    updated_at
) VALUES (
    'Test Reward - 7 Days',
    'This reward expires in 7 days for testing countdown',
    200,
    20,
    0,
    datetime('now'),
    datetime('now', '+7 days'),
    1,
    1, -- Replace with actual seller_id
    datetime('now'),
    datetime('now')
);


-- =====================================================
-- NOTES
-- =====================================================

/*
1. BACKUP DATABASE BEFORE RUNNING!
   - For SQLite: cp database/database.sqlite database/database.backup.sqlite
   - For MySQL: mysqldump -u user -p database > backup.sql

2. TEST ON STAGING FIRST
   - Never run directly on production
   - Test with sample data first

3. TIMEZONE CONSIDERATION
   - datetime('now') uses UTC
   - Adjust based on your application's timezone setting
   - Check config/app.php timezone configuration

4. VERIFY AFTER MIGRATION
   - Run verification queries above
   - Check API responses
   - Test consumer countdown display

5. LARAVEL MIGRATION ALTERNATIVE
   - Preferred: Use Laravel migration (see REWARD_DATETIME_IMPLEMENTATION.md)
   - This SQL is for manual database updates if needed
*/
