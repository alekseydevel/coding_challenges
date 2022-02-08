package main

type Command struct {
	writer Writer
	reader Reader
	logger ErrorLogger
}

func (c Command) exec()  {

	data, err := c.reader.read()
	validateErrorAndExitIfNeeded(err)

	err = c.writer.export(data)
	validateErrorAndExitIfNeeded(err)

	c.logger.logInfo("Finished with success")
}
