mail
====
These scripts will grab a folder of your choosing from gmail and insert it into a MySQL table. I'm doing this to play around with my emails using Sphinx.

form.php
===
This will ask you for your email and password, then send you to folders.php, where it will connect to your mailbox and show you a list of available folders.

folders.php
===
This will present a list of folders from your gmail account. Copy and paste one of them into the field at the bottom.

gmail.php
===
This brings together your authorization details, gets emails, and inserts them into MySQL. Depending on the size of your mailbox, it could take a while.

that's it for now
===
Let me know if you see ways to improve this process. I have a lot to learn :)
