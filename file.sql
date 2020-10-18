IF Environment.ISO.ISSUERER = '1' AND Environment.BET.TerminalID IS NOT NULL THEN --THIS IS US ON US
		 	--CREDIT THE TERMINAL ACCOUNT AND DEBIT FIEDL  AccountIdentification1_102
		 	SET Environment.BET.DEBITCODE = THE(SELECT ITEM T.DEBITCODE FROM Database.ZBDB_ESB.DB2INST1.TRANSACTIONCODE AS T WHERE T.PROCESSINGCODE = Environment.ISO.PROCESSINGCODE AND T.SOURCE = Environment.BET.TerminalSource );-- WILL NEED TO USE 6 CHARS
			SET Environment.BET.CREDITCODE = THE(SELECT ITEM T.CREDITCODE FROM Database.ZBDB_ESB.DB2INST1.TRANSACTIONCODE AS T WHERE T.PROCESSINGCODE = Environment.ISO.PROCESSINGCODE AND T.SOURCE = Environment.BET.TerminalSource);
				IF Environment.ISO.PROCESSINGCODE = '21' THEN
				---for transacstions that increase the customer's balance
				--deposit working @tmbizvo 10032020

				--GOOD CODE
				SET Environment.ISO.CREDITACC = ISOMSG.AccountIdentification1_102;
				--07/07/2020 check if its a zwl or usd txn @tmbizvo
				  IF ISOMSG.CurrencyCodeTransaction_049 = '932' THEN   -- then ZWL TXN

						CALL getTerminalAccount( Environment.ISO.Field041, DEBITACC);
						SET Environment.ISO.DEBITACC = DEBITACC;

				  ELSE
				  			CALL getTerminalUSDAccount(Environment.ISO.Field041, DEBITACC);
				  			SET Environment.ISO.DEBITACC = DEBITACC;

				  END IF;
				--GOOD CODE END

				ELSE
			---	for transacstions that decrease the customer's balance
			--cash withdrwal, purchase, purchase w/cash back,   working @tmbizvo 10032020

			--BEGIN LOGIC FOR FUNDS TRANSFER
			IF Environment.ISO.PROCESSINGCODE = '40' THEN -- THIS IS A FUNDS TRANSFER , SHOULD CREDIT THE RECEIVING ACCOUNT

				SET Environment.ISO.CREDITACC = ISOMSG.AccountIdentification2_103;
				SET Environment.ISO.DEBITACC =  ISOMSG.AccountIdentification1_102;

			ELSE -- THIS CDREDITS THE POS/ATM ACCOUNT
				--07/07/2020 check if its a zwl or usd txn @tmbizvo
				 IF ISOMSG.CurrencyCodeTransaction_049 = '932' THEN   -- then ZWL TXN

				 	CALL getTerminalAccount( Environment.ISO.Field041, CREDITACC);
				 	SET Environment.ISO.CREDITACC = CREDITACC;

				 ELSE
				 	CALL getTerminalUSDAccount(Environment.ISO.Field041, CREDITACC);
				 	SET Environment.ISO.CREDITACC = CREDITACC;

				 END IF;

				SET Environment.ISO.DEBITACC =  ISOMSG.AccountIdentification1_102;
			END IF;

			--END LOGIC FOR FUNDS TRANSFER


			---
			END IF;

		ELSEIF Environment.ISO.ISSUERER = '1' AND Environment.BET.TerminalID IS NULL  THEN -- THIS IS US ON THEM

		 --Advice transactions

		SET Environment.BET.DEBITCODE = THE(SELECT ITEM T.ADVICEDEBITCODE FROM Database.ZBDB_ESB.DB2INST1.TRANSACTIONCODE AS T WHERE T.PROCESSINGCODE = Environment.ISO.PROCESSINGCODE);
		SET Environment.BET.CREDITCODE = THE(SELECT ITEM T.ADVICECREDITCODE FROM Database.ZBDB_ESB.DB2INST1.TRANSACTIONCODE AS T WHERE T.PROCESSINGCODE = Environment.ISO.PROCESSINGCODE);

			IF Environment.BET.MCC = '6011' OR Environment.BET.MCC = '6012' THEN

				IF Environment.ISO.PROCESSINGCODE = '21' THEN

					SET Environment.ISO.CREDITACC = ISOMSG.AccountIdentification1_102;
					 IF ISOMSG.CurrencyCodeTransaction_049 = '932' THEN   -- then ZWL TXN --07/07/2020 check if its a zwl or usd txn @tmbizvo
					 	--getAcquirerATMAccount(IN ACQUIRERID CHARACTER , OUT ACCOUNT CHARACTER )

					 	CALL getAcquirerATMAccount(ISOMSG.AcquiringInstitutionIdentificationCode_032,DEBITACC );
						SET Environment.ISO.DEBITACC = DEBITACC;

					 ELSE
					 	CALL getAcquirerATMUSDAccount(ISOMSG.AcquiringInstitutionIdentificationCode_032, DEBITACC);
					 	SET Environment.ISO.DEBITACC = DEBITACC;
					 END IF;

				ELSE -- a
						IF Environment.ISO.PROCESSINGCODE = '40' THEN

								SET Environment.ISO.DEBITACC = ISOMSG.AccountIdentification1_102;
								SET Environment.ISO.CREDITACC = ISOMSG.AccountIdentification2_103;

							ELSE
								SET Environment.ISO.DEBITACC = ISOMSG.AccountIdentification1_102;
								 IF ISOMSG.CurrencyCodeTransaction_049 = '932' THEN   -- then ZWL TXN --07/07/2020 check if its a zwl or usd txn @tmbizvo

								 	CALL getAcquirerATMAccount(ISOMSG.AcquiringInstitutionIdentificationCode_032,CREDITACC );
									SET Environment.ISO.CREDITACC = CREDITACC;

								 ELSE
								 	CALL getAcquirerATMUSDAccount(ISOMSG.AcquiringInstitutionIdentificationCode_032, CREDITACC);
									 SET Environment.ISO.CREDITACC = CREDITACC;

								 END IF;

						END IF;

				END IF;

			ELSE

			IF Environment.ISO.PROCESSINGCODE = '21' THEN

				SET Environment.ISO.CREDITACC = ISOMSG.AccountIdentification1_102;
				 IF ISOMSG.CurrencyCodeTransaction_049 = '932' THEN   -- then ZWL TXN --07/07/2020 check if its a zwl or usd txn @tmbizvo

				 	 	CALL getAcquirerPOSAccount (ISOMSG.AcquiringInstitutionIdentificationCode_032,DEBITACC);
						SET Environment.ISO.DEBITACC = DEBITACC;
				 ELSE
				 		CALL getAcquirerPOSUSDAccount(ISOMSG.AcquiringInstitutionIdentificationCode_032,DEBITACC);
						 SET Environment.ISO.DEBITACC = DEBITACC;

				 END IF;

			ELSE

				IF Environment.ISO.PROCESSINGCODE = '40' THEN

						SET Environment.ISO.DEBITACC = ISOMSG.AccountIdentification1_102;
						SET Environment.ISO.CREDITACC = ISOMSG.AccountIdentification2_103;

					ELSE
						SET Environment.ISO.DEBITACC = ISOMSG.AccountIdentification1_102;
						 	IF ISOMSG.CurrencyCodeTransaction_049 = '932' THEN   -- then ZWL TXN --07/07/2020 check if its a zwl or usd txn @tmbizvo

						 	CALL getAcquirerPOSAccount (ISOMSG.AcquiringInstitutionIdentificationCode_032,CREDITACC);
								SET Environment.ISO.CREDITACC = CREDITACC;
						 	ELSE
						 		CALL getAcquirerPOSUSDAccount(ISOMSG.AcquiringInstitutionIdentificationCode_032,CREDITACC);
						 		SET Environment.ISO.CREDITACC = CREDITACC;
						 	END IF;
				END IF;

			END IF;
			END IF;

			ELSEIF 	Environment.ISO.ISSUERER = '0' AND Environment.BET.TerminalID IS NOT NULL THEN --this is them on us
--			--CREDIT TERMINAL ACCOUNT and DEBIT ACQUIRER GL

				IF Environment.BET.MCC = '6011' OR Environment.BET.MCC = '6012' THEN

				IF Environment.ISO.PROCESSINGCODE = '21' THEN
				---for transacstions that increase the customer's balance
					CALL getTerminalAccount( Environment.ISO.Field041, DEBITACC);
				 	SET Environment.ISO.DEBITACC = DEBITACC;


					 IF ISOMSG.CurrencyCodeTransaction_049 = '932' THEN   -- then ZWL TXN --07/07/2020 check if its a zwl or usd txn @tmbizvo
					 	--getAcquirerATMAccount(IN ACQUIRERID CHARACTER , OUT ACCOUNT CHARACTER )

					 		CALL getAcquirerATMAccount(ISOMSG.AcquiringInstitutionIdentificationCode_032,CREDITACC );
							SET Environment.ISO.CREDITACC = CREDITACC;

						 ELSE
							 CALL getAcquirerATMUSDAccount(ISOMSG.AcquiringInstitutionIdentificationCode_032, CREDITACC);
							SET Environment.ISO.CREDITACC = CREDITACC;

					 END IF;

				ELSE -- a
						IF Environment.ISO.PROCESSINGCODE = '40' THEN

								SET Environment.ISO.DEBITACC = ISOMSG.AccountIdentification1_102;
								SET Environment.ISO.CREDITACC = ISOMSG.AccountIdentification2_103;

						ELSE

								CALL getTerminalAccount( Environment.ISO.Field041, CREDITACC);
				 				SET Environment.ISO.CREDITACC = CREDITACC;


								 IF ISOMSG.CurrencyCodeTransaction_049 = '932' THEN   -- then ZWL TXN --07/07/2020 check if its a zwl or usd txn @tmbizvo

								 	CALL getAcquirerATMAccount(ISOMSG.AcquiringInstitutionIdentificationCode_032,DEBITACC );
									SET Environment.ISO.DEBITACC = DEBITACC;

								 ELSE
								 	CALL getAcquirerATMUSDAccount(ISOMSG.AcquiringInstitutionIdentificationCode_032, DEBITACC);
									 SET Environment.ISO.DEBITACC = DEBITACC;

								 END IF;

						END IF;

				END IF;

			ELSE

			IF Environment.ISO.PROCESSINGCODE = '21' THEN
				--CREDIT TERMINAL ACCOUNT and DEBIT ACQUIRER GL
				---for transacstions that increase the customer's balance

				CALL getTerminalAccount( Environment.ISO.Field041, DEBITACC);
				SET Environment.ISO.DEBITACC = DEBITACC;


				 IF ISOMSG.CurrencyCodeTransaction_049 = '932' THEN   -- then ZWL TXN --07/07/2020 check if its a zwl or usd txn @tmbizvo

				 	 	CALL getAcquirerPOSAccount (ISOMSG.AcquiringInstitutionIdentificationCode_032,CREDITACC);
						SET Environment.ISO.CREDITACC = CREDITACC;
				 ELSE
				 		CALL getAcquirerPOSUSDAccount(ISOMSG.AcquiringInstitutionIdentificationCode_032,CREDITACC);
						 SET Environment.ISO.CREDITACC = CREDITACC;

				 END IF;

			ELSE

				IF Environment.ISO.PROCESSINGCODE = '40' THEN

						SET Environment.ISO.DEBITACC = ISOMSG.AccountIdentification1_102;
						SET Environment.ISO.CREDITACC = ISOMSG.AccountIdentification2_103;

					ELSE
						CALL getTerminalAccount( Environment.ISO.Field041, CREDITACC);
						SET Environment.ISO.CREDITACC = CREDITACC;

						 	IF ISOMSG.CurrencyCodeTransaction_049 = '932' THEN   -- then ZWL TXN --07/07/2020 check if its a zwl or usd txn @tmbizvo

						 	CALL getAcquirerPOSAccount (ISOMSG.AcquiringInstitutionIdentificationCode_032,DEBITACC);
								SET Environment.ISO.CREDITACC = CREDITACC;
						 	ELSE
						 		CALL getAcquirerPOSUSDAccount(ISOMSG.AcquiringInstitutionIdentificationCode_032,DEBITACC);
						 		SET Environment.ISO.DEBITACC = DEBITACC;
						 	END IF;
				END IF;

			END IF;
			END IF;

		 END IF;
