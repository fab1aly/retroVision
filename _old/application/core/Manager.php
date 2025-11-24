<?php

	abstract class Manager
	{
		protected static $dbh;

		public function __construct()
		{
			if(!(self::$dbh instanceof PDO))
			{
				self::$dbh = new PDO(CONFIGURATION['database']['dsn'], CONFIGURATION['database']['username'], CONFIGURATION['database']['password'], CONFIGURATION['database']['options']);
			}
		}
	}