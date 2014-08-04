Collect your email
====
These scripts will grab a folder of your choosing from gmail and insert it into a MySQL table. I'm doing this, because, ultimately, I want to play around with my emails using Sphinx. To get started, download these files, create a table with 'id', 'sender', 'subject', 'date' and 'message' fields. ```gmail.php``` will expect those names. Then, open up ```form.php``` in your browser.

###form.php

This will ask you for your email and password, then send you to ```folders.php```, where it will connect to your mailbox and show you a list of available folders.

###folders.php

This will present a list of folders from your gmail account. Copy and paste one of them into the field at the bottom.

###gmail.php

This brings together your authorization details, gets emails, and inserts the sender name, subject, date and content into MySQL. Depending on the size of your mailbox, it could take a while.

###that's it for now

Let me know if you see ways to improve this process. I have a lot to learn :)
