#!/bin/sh
mysql -u Levkoadmin -pLamp314tree15 billiardhub < initDatabase.sql
mysql -u Levkoadmin -pLamp314tree15 billiardhub < views.sql

mysql -u Levkoadmin -pLamp314tree15 billiardhub < groupMatches.sql
mysql -u Levkoadmin -pLamp314tree15 billiardhub < matchProcedures.sql
mysql -u Levkoadmin -pLamp314tree15 billiardhub < liveMatchProcedures.sql
mysql -u Levkoadmin -pLamp314tree15 billiardhub < tournamentProcedures.sql
mysql -u Levkoadmin -pLamp314tree15 billiardhub < tournamentInputProcedures.sql

mysql -u Levkoadmin -pLamp314tree15 billiardhub < KOprocedures.sql
mysql -u Levkoadmin -pLamp314tree15 billiardhub < DEprocedures.sql
mysql -u Levkoadmin -pLamp314tree15 billiardhub < GROUP-KOprocedures.sql

mysql -u Levkoadmin -pLamp314tree15 billiardhub < initFillDatabase.sql
mysql -u Levkoadmin -pLamp314tree15 billiardhub < fillDatabase.sql
