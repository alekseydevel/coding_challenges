package main

import (
	"encoding/json"
	"encoding/xml"
	"errors"
	"os"
	"strings"
)

type Writer interface {
	export(items []Coffee) error
}

type LocalXmlWriter struct {
	filePath string
}

func getWriter(source string) (Writer, error) {
	if strings.Contains(source, ".json") {
		return &LocalJsonWriter{filePath: source}, nil
	}

	if strings.Contains(source, ".xml") {
		return &LocalXmlWriter{filePath: source}, nil
	}

	return nil, errors.New("could not find any exporter")
}

func (xw LocalXmlWriter) export(items []Coffee) error  {

	m, _ := xml.Marshal(items)
	err := os.WriteFile(xw.filePath, m, 0644)

	if err != nil {
		return err
	}

	return nil
}


type LocalJsonWriter struct {
	filePath string
}

func (jw LocalJsonWriter) export(items []Coffee) error  {
	j, _ := json.Marshal(items)
	err := os.WriteFile(jw.filePath, j, 0644)

	if err != nil {
		return err
	}

	return nil
}