USE pos_namin;

-- Add status column if it doesn't exist
ALTER TABLE users
ADD COLUMN IF NOT EXISTS status ENUM('active', 'inactive') NOT NULL DEFAULT 'active' AFTER role;

-- Update existing records to have 'active' status
UPDATE users SET status = 'active' WHERE status IS NULL;
