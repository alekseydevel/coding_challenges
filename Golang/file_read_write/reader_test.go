package main

import (
	"errors"
	"github.com/stretchr/testify/assert"
	"testing"
)

func TestGetImporterShouldReturnRemoteOne(t *testing.T) {
	actualReader, err := getReader("http://some-source.com/")
	expectedReader := &RemoteReader{Source: "http://some-source.com/"}
	assert.Equal(t, expectedReader, actualReader)
	assert.Equal(t, nil, err)
}

func TestGetImporterShouldReturnLocalOne(t *testing.T) {
	actualReader, err := getReader("./file")
	expectedReader := &LocalReader{Filename: "./file"}
	assert.Equal(t, expectedReader, actualReader)
	assert.Equal(t, nil, err)
}

func TestGetImporterShouldReturnErrorIfNoSourceProvided(t *testing.T) {
	actualReader, err := getReader("")

	assert.Equal(t, nil, actualReader)
	assert.Equal(t, errors.New("filepath must be provided"), err)
}

