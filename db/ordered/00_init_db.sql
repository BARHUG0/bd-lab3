-- Create the database itself if needed (usually done by env vars, but safe to check)
-- CREATE DATABASE crud;

-- Run table creation scripts from ddl folder (if needed)
\i /docker-entrypoint-initdb.d/ddl/00_init_db.sql
\i /docker-entrypoint-initdb.d/ddl/01_create_tables.sql

-- Run data insertion and other table scripts from data folder in order
\i /docker-entrypoint-initdb.d/data/01_insert_titles_table.sql
\i /docker-entrypoint-initdb.d/data/02_us_tshirt_size_table.sql
\i /docker-entrypoint-initdb.d/data/03_country_table.sql
\i /docker-entrypoint-initdb.d/data/04_institution_table.sql
\i /docker-entrypoint-initdb.d/data/05_status_table.sql
\i /docker-entrypoint-initdb.d/data/07_team_role_table.sql
\i /docker-entrypoint-initdb.d/data/08_user_table.sql
\i /docker-entrypoint-initdb.d/data/09_team_table.sql
\i /docker-entrypoint-initdb.d/data/10_team_members_table.sql
\i /docker-entrypoint-initdb.d/data/11_contest_table.sql
\i /docker-entrypoint-initdb.d/data/12_team_contests_table.sql
