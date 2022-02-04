<?php

namespace Command;

class MigrateDataLocal extends MigrateData
{
    protected static $defaultName = 'app:migrate:local';
    protected static $defaultDescription = 'Migrates XML data from given source and uploads into local file)';
}
