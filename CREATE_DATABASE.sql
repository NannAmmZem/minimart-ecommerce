-- Mini Mart Database Creation Script for Laragon
-- Run this in MySQL Console or HeidiSQL

CREATE DATABASE IF NOT EXISTS minimart_laragon 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE minimart_laragon;

-- Verify database is created
SELECT 'Database minimart_laragon created successfully!' AS status;
