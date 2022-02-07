package main

import (
	"encoding/xml"
	"errors"
	"io/ioutil"
	"net/http"
	"os"
	"strings"
)

func getReader(source string) (Reader, error)  {

	if len(source) == 0 {
		return nil, errors.New("filepath must be provided")
	}

	if strings.Contains(source, "http") {
		return &RemoteReader{Source: source}, nil
	}

	return &LocalReader{Filename: source}, nil
}

type Reader interface {
	read() ([]Coffee, error)
}

type LocalReader struct {
	Filename string
}

type RemoteReader struct {
	Source string
}

func (lr LocalReader) read() ([]Coffee, error) {

	location := lr.Filename

	if len(location) == 0 {
		return nil, errors.New("file source must be non-empty string")
	}

	data, err := os.ReadFile(location)

	if err != nil {
		return nil, err
	}

	var catalog CoffeeCatalog

	err = xml.Unmarshal(data, &catalog)

	if err != nil {
		return nil, err
	}

	return catalog.Items, nil
}

func (rr RemoteReader) read() ([]Coffee, error) {

	location := rr.Source
	response, err := http.Get(location)

	if err != nil {
		return nil, err
	}

	data, err := ioutil.ReadAll(response.Body)

	if err != nil {
		return nil, err
	}

	var catalog CoffeeCatalog

	err = xml.Unmarshal(data, &catalog)

	if err != nil {
		return nil, err
	}

	return catalog.Items, nil
}
