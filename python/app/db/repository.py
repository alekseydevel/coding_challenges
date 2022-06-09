# will be folder if many folders

from sqlite3 import Timestamp
import time
from sqlalchemy import Table, select, insert, Column, Integer, String, DateTime, MetaData
from sqlalchemy.engine import create_engine

engine = create_engine("postgresql://postgres:postgres@db:5432/plates")

from flask import Flask
from flask_sqlalchemy import SQLAlchemy

db = SQLAlchemy()

class Plate(db.Model):
    __tablename__ = 'plates'
    
    # id = db.Column('id', Integer),
    # plate = db.Column('plate',String),
    # plate_clean = db.Column('plate_clean', String),
    # timestamp = db.Column('timestamp', DateTime)

class PlateRepository:
    def find_all():
        rows = engine.connect().execute(
            "select * from plates"
        )
        
        return [dict(row) for row in rows]
    
    def insert(plate):
        
        plate = str(plate)
        
        p = Plate(plate=plate, plate_clean=plate, timestamp=time.time())
        
        db.session.add(p)
        db.session.commit()
