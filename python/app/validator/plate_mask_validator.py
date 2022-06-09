import re

def is_valid_plate(plate):
    
    if type(plate) is not str:
        return False
    
    if plate == "":
        return False
    
    m = re.fullmatch(r"([a-zA-Z]{1,3}\-[a-zA-Z]{1,2}[1-9]{0,4})", plate)
    
    return m is not None
    