from app.validator.plate_mask_validator import is_valid_plate
import unittest

class TestIsValidPlate(unittest.TestCase):
    def test_should_return_false_if_empty_string(self):
        self.assertFalse(is_valid_plate(""))
        
    def test_should_return_false_if_not_string(self):
        self.assertFalse(is_valid_plate([]))
        self.assertFalse(is_valid_plate(1))
        self.assertFalse(is_valid_plate(True))
        
    def test_should_return_false_if_too_long(self):
        self.assertFalse(is_valid_plate("LDS-DS129387129837"))
        
    def test_should_return_false_if_has_special_char(self):
        self.assertFalse(is_valid_plate("LDS-DS12 3"))
        self.assertFalse(is_valid_plate("LDS-DS12*3"))
        self.assertFalse(is_valid_plate("LDS-DS12_3"))
        
    def test_should_return_false_if_has_no_hyphen(self):
        self.assertFalse(is_valid_plate("LDSTQ1213"))
        
    def test_should_return_false_if_starts_from_digit(self):
        self.assertFalse(is_valid_plate("11-BB123"))
        
    def test_should_return_false_if_last_sections_starts_from_zero(self):
        self.assertFalse(is_valid_plate("M-BB0123"))
        
    def test_should_return_true_if_correct_mask(self):
        self.assertTrue(is_valid_plate("LDS-BB123"))
        self.assertTrue(is_valid_plate("KW-B123"))
        self.assertTrue(is_valid_plate("B-SS1234"))
        
    def test_should_return_true_if_correct_mask_and_lowercased(self):
        self.assertTrue(is_valid_plate("brm-dk123"))
