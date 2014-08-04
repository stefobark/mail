Collect your email
====
These scripts will grab a folder of your choosing from gmail and insert it into a MySQL table. I'm doing this, because, ultimately, I want to play around with my emails using Sphinx. To get started, download these files, create a table with 'id', 'sender', 'subject', 'date' and 'message' fields. ```gmail.php``` will expect those names. Then, open up ```form.php``` in your browser.

###form.php

This will ask you for your email and password, then send you to ```folders.php```, where it will connect to your mailbox and show you a list of available folders.

###folders.php

This will present a list of folders from your gmail account. Copy and paste one of them into the field at the bottom.

###gmail.php

This brings together your authorization details, gets emails, and inserts the sender name, subject, date and content into MySQL. Depending on the size of your mailbox, it could take a while.

###gmail.conf
This is the Sphinx configuration file used to index a table with 'sender', 'subject', 'date', and 'message' fields. It connects to a database named 'test' on 127.0.0.1:9306 with the 'root' user and no password. It uses the field/string data type. So, it's fulltext indexed but also stored as a string attribute (so, when searching Sphinx, we'll get text content in the result set.. otherwise, Sphinx ditches the actual text content with fulltext fields).

After your table is ready, run indexer like this:

```indexer -c /path/to/project/gmail.conf emails```

Then, play around, search your emails with Sphinx!

###that's it for now

Let me know if you see ways to improve this process. I have a lot to learn :)
