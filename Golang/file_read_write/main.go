package main

import (
	"errors"
	"fmt"
	"os"
)

var Logger ErrorLogger

const Env = "dev" // "dev" for STDOUT
const LogOutputFile = "./var/output/log.txt"

func main() {

	args := os.Args

	if len(args) < 3 {
		getLoggerInstance().logError(errors.New("2 params required: import and export sources"))
		os.Exit(1)
	}

	importPath := args[1]
	exportPath := args[2]

	exporter, err := getExporter(exportPath)
	validateErrorAndExitIfNeeded(err)

	reader, err := getReader(importPath)
	validateErrorAndExitIfNeeded(err)

	data, err := reader.read()
	validateErrorAndExitIfNeeded(err)

	err = exporter.export(data)
	validateErrorAndExitIfNeeded(err)

	getLoggerInstance().logInfo("Finished with success")
}

func getLoggerInstance() ErrorLogger {

	if Logger == nil {
		Logger = resolveLogger()
	}

	return Logger
}

func resolveLogger() ErrorLogger {

	if Env == "dev" {
		return &StdoutLogger{}
	}

	return &LocalFileErrorLogger{
		FileName: LogOutputFile,
	}
}

func validateErrorAndExitIfNeeded(err error) {
	if err != nil {
		getLoggerInstance().logError(err)
		fmt.Println("Error occurred, please check the logs")
		os.Exit(1)
	}
}