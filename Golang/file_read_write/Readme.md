XML (Coffee catalog) remote/local reader + writer (JSON in this example)

Usage:
1. tests: `go tests .`
2. command 
   1. local input: `go run . ./var/input/sample.xml ./var/output/result.json`
   2. remote input `go run . https://COFFE_XML_URL ./var/output/result.json`
3. todo / consider:
   1. read / write streaming (at the moment "readAll" is used)
   2. xml values sanitizing (trim)
