#!/bin/bash

# Set variables
BACKUP_PATH="/var/www/galaxy-pos"  # Updated path
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_NAME="database_backup_$DATE"

# Database credentials
DB_USER="dennykate"
DB_PASS="11223344"
DB_NAME="galaxy_food_and_drink"

# Create backup directory if it doesn't exist
mkdir -p $BACKUP_PATH/backups

# Create database backup with better error handling
if mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_PATH/backups/$BACKUP_NAME.sql 2>/dev/null; then
    echo "Database backup created successfully"
else
    echo "Error creating database backup"
    exit 1
fi

# Create zip archive
cd $BACKUP_PATH/backups
if command -v zip >/dev/null 2>&1; then
    zip $BACKUP_NAME.zip $BACKUP_NAME.sql
    # Remove the .sql file after successful zip
    if [ $? -eq 0 ]; then
        rm $BACKUP_NAME.sql
        chmod 600 $BACKUP_NAME.zip
        echo "Backup completed: $BACKUP_PATH/backups/$BACKUP_NAME.zip"
    else
        echo "Error creating zip file"
        exit 1
    fi
else
    echo "zip command not found. Please install zip package"
    exit 1
fi
