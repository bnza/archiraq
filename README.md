[![Build Status](https://travis-ci.org/bnza/archiraq.svg?branch=master)](https://travis-ci.org/bnza/archiraq)

# Archiraq

Iraqi archaeological sites webGIS

[Documentation](docs/index.md)

## GeoJSONL Import

This project supports importing archaeological site data from GeoJSONL (Newline-Delimited GeoJSON) files.

### 1. Data Validation

Before importing, validate the data consistency and vocabulary references:

```bash
# Validate chronology string vs individual flag columns (SURVEY type only)
php bin/console app:validate:chronology-consistency path/to/file.jsonl

# Validate chronology codes against vocabulary
php bin/console app:validate:chronology-codes path/to/file.jsonl

# Validate survey codes against vocabulary
php bin/console app:validate:surveys path/to/file.jsonl
```

### 2. Full Re-import

To replace all existing site data with a new dataset:

**Warning:** This operation is destructive.

```bash
# 1. Truncate existing tables
php bin/console app:db:truncate-sites --force

# 2. Import the new file
# You will be prompted for contributor metadata unless provided via options
php bin/console app:import:geojsonl path/to/file.jsonl \
    --email="contributor@example.com" \
    --contributor="Name" \
    --institution="Institution" \
    --description="Dataset description"
```

### 3. Materialized View Refresh

The import automatically refreshes the `geom.mat_site` view. To refresh it manually:

```bash
php bin/console app:db:refresh-mat-view
```

