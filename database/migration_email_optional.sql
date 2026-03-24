-- Migration to make email optional in users table
ALTER TABLE users MODIFY COLUMN email VARCHAR(100) UNIQUE NULL;