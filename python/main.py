from flask import jsonify
from flask import request
from python.app.validator.create_plate_request_validator import validate_plate
from app.validator.plate_mask_validator import is_valid_plate
from app.db.repository import PlateRepository
from flask import Flask

app = Flask(__name__)

class InvalidUsage(Exception):
    status_code = 400

    def __init__(self, message, status_code=None, payload=None):
        super().__init__()

        self.message = message

        if status_code is not None:
            self.status_code = status_code
        self.payload = payload

    def to_dict(self):
        rv = dict(self.payload or ())
        rv['message'] = self.message
        return rv

@app.errorhandler(InvalidUsage)
def invalid_api_usage(e):
    return jsonify(e.to_dict()), e.status_code


@app.route("/plate", methods = ['GET'])
def index():
    
    data = PlateRepository.find_all()
    
    return jsonify(data)

@app.route("/plate", methods = ["POST"])
def create_plate():
    
    errors = validate_plate(request)
    
    if errors is not None:
        raise InvalidUsage(errors)
    
    plateValue = request.get_json().get('plate')
    
    if not is_valid_plate(plateValue):
        raise InvalidUsage(errors, 422)

    PlateRepository.insert(plateValue)
    
    return jsonify(), 201
