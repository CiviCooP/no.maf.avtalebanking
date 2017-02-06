# no.maf.avtalebanking

Customisations to CiviBanking to store Avtale Giro information.
The avtale giro information consist of the following:

- Maximum amount
- Send notification

The extension will add a new tab on the contact summary. That tab will show
the bank account number and the Avtale Giro information with functionality to update that information.


## Explanation of design choices

The reason for implementing this as a separate tab is due to the fact the Bank Accounts in CiviBanking could
not easily be extended.

## Requirements

* org.project60.banking (CiviBanking) - https://github.com/Project60/org.project60.banking