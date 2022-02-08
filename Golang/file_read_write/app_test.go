package main

import (
	"encoding/xml"
	"github.com/stretchr/testify/assert"
	"testing"
)

type StringReader struct {
	xmlString string
}

func (sr StringWriter) getExportedData() []Coffee {
	return sr.ExportedData
}

func (sr StringReader) read() ([]Coffee, error)  {
	var data CoffeeCatalog

	err := xml.Unmarshal([]byte(sr.xmlString), &data)
	if err != nil {
		return nil, err
	}

	return data.Items, nil
}

type StringWriter struct {
	ExportedData []Coffee
}

func (sr *StringWriter) export(data []Coffee) error {
	sr.ExportedData = data

	return nil
}

func TestApp(t *testing.T) {

	xmlStr := "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<catalog>\n    <item>\n        <entity_id>340</entity_id></item>\n</catalog>"

	writer := &StringWriter{}

	app := Command{writer: writer, reader: &StringReader{xmlStr}, logger: getLoggerInstance()}

	app.exec()

	assert.Equal(t, []Coffee{{Id:340}}, writer.ExportedData)
}
