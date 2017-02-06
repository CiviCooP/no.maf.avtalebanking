# no.maf.avtalebanking

Customisations to CiviBanking to store Avtale Giro information. That information
consist of maximum amount and whether the donor wants to receive notification.

The extension will add a new Tab on the contact summary that tab will show
the bank account number and the AvtaleGiro information with functionality to
add.

## Explanation of design choices

The reason for implementing this as a separate tab is due to the fact the Bank Accounts in CiviBanking could
not easily be extended.

## Requirements

* org.project60.banking (CiviBanking) - https://github.com/Project60/org.project60.banking