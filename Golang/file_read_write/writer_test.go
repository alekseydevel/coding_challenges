package main

import (
	"errors"
	"github.com/stretchr/testify/assert"
	"testing"
)

func TestGetExporterShouldGiveJsonOne(t *testing.T) {
	expectedExporter := &LocalJsonWriter{"some.json"}
	actualExporter, _ := getWriter("some.json")
	assert.Equal(t, expectedExporter, actualExporter)
}

func TestGetExporterShouldGiveXmlOne(t *testing.T) {
	expectedExporter := &LocalXmlWriter{"some.xml"}
	actualExporter, _ := getWriter("some.xml")
	assert.Equal(t, expectedExporter, actualExporter)
}

func TestGetExporterShouldReturnError(t *testing.T) {
	actualExporter, err := getWriter("some")
	assert.Equal(t, nil, actualExporter)
	assert.Equal(t, errors.New("could not find any exporter"), err)
}