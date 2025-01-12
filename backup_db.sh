#!/bin/bash

# Set variables
BACKUP_PATH="/var/www/galaxy-pos"
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_NAME="database_backup_$DATE"

# Database credentials
DB_USER="dennykate"
DB_PASS="11223344"
DB_NAME="galaxy_food_and_drink"

# Create backup directory if it doesn't exist
mkdir -p $BACKUP_PATH/backups

# Create database backup
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_PATH/backups/$BACKUP_NAME.sql

# Create zip archive
cd $BACKUP_PATH/backups
zip $BACKUP_NAME.zip $BACKUP_NAME.sql

# Remove the .sql file (optional)
rm $BACKUP_NAME.sql

# Set appropriate permissions
chmod 600 $BACKUP_NAME.zip

# Print completion message
echo "Backup completed: $BACKUP_PATH/backups/$BACKUP_NAME.zip"
