initial requirements can be found in JS/auto-plate-api repository.
originally the task was to use SQLAlchemy + Flask, however I've struggled a lot with
- libraries and their exceptions
- configuring the "Class" way of SQL Models:
  - sqlalchemy.ext issue
  - failure on mapping the class to DB table in context of primary key (app could not boot)