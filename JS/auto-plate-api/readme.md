# coding challenge

## simple API with 2 endpoints:

### 1. create licence plate record
### 2. retrieve list of records (can be with search query)

## Requirements:
1. Creation of licence plate record:
   - 1 to 3 characters before the hyphen (M-AA123)
   - 1 or 2 characters after the hyphen (M-AA123)
   - A maximum 4 digits number in the end (can’t start with a 0) (M-AA123)

2. Retrieve / search
   - Levenstein distance search (<=1)
   - We don't care about special chars during search

## Solution description:

- Express + Postgres
- Levenstein extension for PG
- Tests for validator and sanitizer
- Docker-compose (will fail after 1st build + up because of delay lack => 
  app will fail to connect cause PG will be not booted yet)

## ToDo:
- env config files handling
- some ToDos insde the files (singleton of DB client, etc)
- Integration test with DB
- Endpoint tests (request \ response)
- Docker-compose delay for App boot