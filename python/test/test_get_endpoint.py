# import pytest

# doesn't work. "fixture client not found." Couldn't find proper solution in internet.
# idea is to test endpoints:
# 1. GET - assert 200 + check format + check search
# 2. POST - assert 200, 400, 401 with diff data sets

#def test_request_example(client):
#    response = client.get("/plate")    
#    assert b"<h2>Hello, World!</h2>" in response.data