from flask_inputs import Inputs
from flask_inputs.validators import JsonSchema

plate_schema = {
   'type': 'object',
   'properties': {
       'plate': {
           'type': 'string',
       }
   },
   'required': ['plate']
}


class PlateInputs(Inputs):
   json = [JsonSchema(schema=plate_schema)]


def validate_plate(request):
    inputs = PlateInputs(request)
   
    inputs.validate()

    if len(inputs.errors) > 0:
       return inputs.errors

    return None
   