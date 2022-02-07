package main

import (
	"fmt"
	"os"
)

type ErrorLogger interface {
	logError(err error)
	logInfo(message string)
}

type LocalFileErrorLogger struct {
	FileName string
}

func (l LocalFileErrorLogger) write(s string)  {
	f, err := os.OpenFile(l.FileName, os.O_APPEND|os.O_WRONLY|os.O_CREATE, 0600)
	if err != nil {
		panic(err)
	}

	defer f.Close()

	if _, err = f.WriteString(fmt.Sprintf("%s\n", s)); err != nil {
		panic(err)
	}
}

func (l LocalFileErrorLogger) logError(logMessage error)  {
	l.write(logMessage.Error())
}

func (l LocalFileErrorLogger) logInfo(logMessage string)  {
	l.write(logMessage)
}

type StdoutLogger struct {

}

func (l StdoutLogger) logError(logMessage error)  {
	fmt.Println(logMessage)
}

func (l StdoutLogger) logInfo(logMessage string)  {
	fmt.Println(logMessage)
}
